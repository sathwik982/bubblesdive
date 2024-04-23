<?php
session_start();

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}


include '../app/database/Connection.php';
$db = new Connection();

$userData = $_SESSION["auth"];

?>

<?php include '../layout/_assign.php';


$error_message = $success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $status = $_POST['status'];
    $roleName = $_POST['roleName'];

    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword) || empty($status) || empty($roleName)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format. Please enter a valid email address.";
    } elseif ($password !== $confirmPassword) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        $sqlCheckEmail = "SELECT COUNT(*) as count FROM `users` WHERE email = ?";
        $resultCheckEmail = $db->run($sqlCheckEmail, [$email]);

        if ($resultCheckEmail["status"] == "success") {
            $emailCount = $resultCheckEmail["data"][0]['count'];

            if ($emailCount > 0) {
                $error_message = "Email is already registered. Please use a different email address.";
            } else {
                $sqlRole = "SELECT roleId FROM `roles` WHERE roleName = ?";
                $resultRole = $db->run($sqlRole, [$roleName]);

                if ($resultRole["status"] == "success") {
                    $roleId = $resultRole["data"][0]['roleId'];

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `users` (fullName, email, password, roleId, status) VALUES (?, ?, ?, ?, ?)";
                    $params = [$fullName, $email, $hashedPassword, $roleId, $status];
                    $result = $db->run($sql, $params);

                    if ($result["status"] == "success") {
                        $success_message = "User registered successfully! Redirecting...";
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 1000); 
                            </script>';
                    } else {
                        $error_message = "Failed to register user. Please try again.";
                    }
                } else {
                    $error_message = "Role not found. Please select a valid role.";
                }
            }
        } else {
            $error_message = "Error checking email availability. Please try again.";
        }
    }
}
?>



<!-- TEMPLATE STARTS -->

<!-- TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">User Registration</h2>
            <div class="header-sub-title">
            </div>
        </div>

        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php elseif (!empty($success_message)) : ?>
                            <div class="alert alert-success"><?= $success_message ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName" placeholder="Full Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status" required>
                                        <option value="" selected>Please Select</option>
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="roleName" class="form-label">Role</label><br>
                                    <select class="form-control" name="roleName" required>
                                        <option value="" selected>Please Select</option>
                                        <?php
                                        $sqlRoles = "SELECT * FROM `roles`";
                                        $resultRoles = $db->run($sqlRoles);

                                        if ($resultRoles["status"] == "success") {
                                            $roles = $resultRoles["data"];
                                            foreach ($roles as $role) {
                                                echo "<option value='" . $role['roleName'] . "'>" . $role['roleName'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>

        <?php include '../layout/_scripts.php'; ?>
        <!-- scripts -->
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>

        </body>

        </html>
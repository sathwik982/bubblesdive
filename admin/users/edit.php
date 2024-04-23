<?php
session_start();

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}


$userData = $_SESSION["auth"];

?>

<?php include '../layout/_assign.php';




$error_message = '';
$success_message = '';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);

    $sql = "SELECT u.*, r.roleName 
        FROM `users` u 
        LEFT JOIN `roles` r ON u.roleId = r.roleId 
        WHERE u.userId = ?";

    $params = [$userId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $users = $result["data"][0];
        $fullName = htmlspecialchars($users['fullName']);
        $email = htmlspecialchars($users['email']);
        $roleId = htmlspecialchars($users['roleId']);
        $status = htmlspecialchars($users['status']);
        $roleName = htmlspecialchars($users['roleName']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = intval($_POST['userId']);
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $roleId = htmlspecialchars($_POST['roleId']);
    $status = htmlspecialchars($_POST['status']);

    $sql_check_changes = "SELECT * FROM `users` WHERE userId = ?";
    $params_check_changes = [$userId];
    $result_check_changes = $db->run($sql_check_changes, $params_check_changes);

    if ($result_check_changes["status"] == "success" && !empty($result_check_changes["data"])) {
        $existing_user = $result_check_changes["data"][0];

        $sql = "UPDATE `users` SET fullName = ?, email = ?, roleId = ?, status = ? WHERE userId = ?";
        $params = [$fullName, $email, $roleId, $status, $userId];
        $update_result = $db->run($sql, $params);

        if ($update_result["status"] == "success") {
            $success_message = "Record has been updated successfully!";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1000);
            </script>';
        } else {
            $error_message = "Failed to update record details. Please try again.";
        }
    } else {
        $error_message = "Error fetching existing data.";
    }
}
?>

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

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

        <div class="page-headers">
            <h2 class="header-title">Update Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="userId" value="<?php echo isset($_GET['userId']) ? $_GET['userId'] : ''; ?>">
                                <input type="hidden" name="roleId" value="<?= $roleId ?? '' ?>">

                                <div class="mb-3">
                                    <label for="fullName" class="form-label">User Name</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName" value="<?= $fullName ?? '' ?>" placeholder="User Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?= $email ?? '' ?>" placeholder="Email Address" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="roleName" class="form-label">Role Name</label>
                                    <input type="text" class="form-control" id="roleName" value="<?= $roleName ?? '' ?>" placeholder="Role Name" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status">
                                        <option value="" <?= !isset($status) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="ACTIVE" <?= (isset($status) && $status == 'ACTIVE') ? 'selected' : '' ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?= (isset($status) && $status == 'INACTIVE') ? 'selected' : '' ?>>INACTIVE</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="index.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        <!-- Add your scripts here -->
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
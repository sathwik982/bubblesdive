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



$error_message = '';
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;

if ($userId !== null) {
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
        $roleName = htmlspecialchars($users['roleName']);
        $status = htmlspecialchars($users['status']);
    } else {
        $error_message = "Record not found.";
    }
} else {
    $error_message = "User ID not provided.";
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="fullName" value="<?= $fullName ?? '' ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="<?= $email ?? '' ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="roleName" value="<?= $roleName ?? '' ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" value="<?= $status ?? '' ?>" readonly>
                            </div>
                            <a href="index.php" class="btn btn-success">Back</a>
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
                <?php if (!empty($error_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
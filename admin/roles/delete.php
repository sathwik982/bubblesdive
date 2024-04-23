<?php
session_start();
require_once '../app/database/Connection.php';

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

$userData = $_SESSION["auth"];

$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

?>

<?php include '../layout/_assign.php';


$error_message = '';
$success_message = '';


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['roleId'])) {
    $roleId = $_GET['roleId'];
    $sql = "SELECT * FROM `roles` WHERE roleId = ?";
    $params = [$roleId];
    $result = $db->run($sql, $params);

    if ($result["status"] === "success" && !empty($result["data"])) {
        $roleData = $result["data"][0];
        $confirmation_message = "<h4>Are you sure you want to delete '{$roleData['roleName']}'?</h4>";
    } else {
        $error_message = "No records found or invalid ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['csrf_token'], $_POST['confirm_delete'], $_POST['roleId']) && $_POST['confirm_delete'] === 'yes') {
    if (!hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
        $error_message = "CSRF Token Verification Failed.";
    } else {
        $roleId = $_POST['roleId'];
        $deleteAssignSql = "DELETE FROM `assign_roles` WHERE `roleId` = ?";
        $deleteAssignResult = $db->run($deleteAssignSql, [$roleId]);

        if ($deleteAssignResult["status"] === "success") {
            $deleteRoleSql = "DELETE FROM `roles` WHERE `roleId` = ?";
            $deleteRoleResult = $db->run($deleteRoleSql, [$roleId]);

            if ($deleteRoleResult["status"] === "success") {
                $success_message = "Record has been deleted successfully!";
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "index.php";
                        }, 1000); 
                    </script>';
            } else {
                $error_message = "Failed to delete role. Please try again.";
            }
        } else {
            $error_message = "No records found or invalid ID.";
        }
    }
}

$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

require_once '../layout/_header.php';
?>

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
            <h2 class="header-title">Delete Record</h2>
        </div>

        <div class="container">
            <?php if (isset($confirmation_message)) : ?>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="alert alert-dark" role="alert"><?= $confirmation_message ?></div>
                        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="hidden" name="roleId" value="<?= $roleId ?>">
                            <input type="hidden" name="confirm_delete" value="yes">
                            <button type="submit" class="btn btn-danger">Yes, Delete</button> &nbsp;
                            <a href="index.php" class="btn btn-success">Cancel</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        require_once '../layout/_footer.php';
        require_once '../layout/_scripts.php';
        ?>
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>
<?php
session_start();
include '../app/database/Connection.php';

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






if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `faq` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] === "success" && !empty($result["data"])) {
        $faq = $result["data"][0];
        $confirmation_message = "<h4>Are you sure you want to delete '{$faq['question']}' ?</h4>";
    } else {
        $error_message = "No records found or invalid ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['csrf_token'], $_POST['confirm_delete'], $_POST['id']) && $_POST['confirm_delete'] === 'yes') {
    $id = $_POST['id'];
    $check_sql = "SELECT * FROM `faq` WHERE id = ?";
    $check_params = [$id];
    $check_result = $db->run($check_sql, $check_params);

    if ($check_result["status"] === "success" && !empty($check_result["data"])) {
        $sql = "DELETE FROM `faq` WHERE id = ?";
        $params = [$id];
        $result = $db->run($sql, $params);

        if ($result["status"] === "success") {
            $success_message = "Record has been deleted successfully!";
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "index.php";
                        }, 1000); 
                    </script>';
        } else {
            $error_message = "Failed to delete record. Please try again.";
        }
    } else {
        $error_message = "No records found or invalid ID.";
    }
}

include '../layout/_header.php';
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

        <div class="container">
            <?php if (isset($confirmation_message)) : ?>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="alert alert-dark" role="alert"><?= $confirmation_message ?></div>
                        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="csrf_token_here">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="confirm_delete" value="yes">
                            <button type="submit" class="btn btn-danger">Yes, Delete</button> &nbsp;
                            <a href="index.php" class="btn btn-success">Cancel</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        include '../layout/_footer.php';
        include '../layout/_scripts.php';
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
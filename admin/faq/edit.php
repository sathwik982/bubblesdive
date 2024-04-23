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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `faq` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $faq = $result["data"][0];

        $question = htmlspecialchars($faq['question']);
        $answer = htmlspecialchars($faq['answer']);
        $status = htmlspecialchars($faq['status']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $question = htmlspecialchars($_POST['question']);
    $answer = htmlspecialchars($_POST['answer']);
    $status = htmlspecialchars($_POST['status']);

    $sql_check_changes = "SELECT * FROM `faq` WHERE id = ?";
    $params_check_changes = [$id];
    $result_check_changes = $db->run($sql_check_changes, $params_check_changes);

    if ($result_check_changes["status"] == "success" && !empty($result_check_changes["data"])) {
        $existing_tc = $result_check_changes["data"][0];

        if (
            $existing_tc['question'] == $question &&
            $existing_tc['answer'] == $answer &&
            $existing_tc['status'] == $status
        ) {
            $no_changes_message = "No changes were made.";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1000);
            </script>';
        } else {
            $sql = "UPDATE `faq` SET question = ?, answer = ?, status = ? WHERE id = ?";
            $params = [$question, $answer, $status, $id];
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
                        <?php elseif (!empty($no_changes_message)) : ?>
                            <div class="alert alert-info"><?= $no_changes_message ?></div>
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
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question" id="question" value="<?= $question ?? '' ?>" placeholder="Title" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="answer">Answer</label>
                                    <textarea class="form-control z-depth-1" id="answer" name="answer" rows="5" placeholder="Write Something here" required><?= $answer ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status" required>
                                        <option value="" <?= !isset($status) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="PUBLISH" <?= (isset($status) && $status == 'PUBLISH') ? 'selected' : '' ?>>PUBLISH</option>
                                        <option value="UNPUBLISH" <?= (isset($status) && $status == 'UNPUBLISH') ? 'selected' : '' ?>>UNPUBLISH</option>
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
                <?php if (!empty($error_message) || !empty($success_message) || !empty($no_changes_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>

        </body>

        </html>
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
$no_changes_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `terms_conditions` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $terms_conditions = $result["data"][0];

        $title = htmlspecialchars($terms_conditions['title']);
        $content = htmlspecialchars($terms_conditions['content']);
        $cancellationPolicy = htmlspecialchars($terms_conditions['cancellationPolicy']);
        $refundPolicy = htmlspecialchars($terms_conditions['refundPolicy']);
        $liabilityDisclaimer = htmlspecialchars($terms_conditions['liabilityDisclaimer']);
        $status = htmlspecialchars($terms_conditions['status']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $cancellationPolicy = htmlspecialchars($_POST['cancellationPolicy']);
    $refundPolicy = htmlspecialchars($_POST['refundPolicy']);
    $liabilityDisclaimer = htmlspecialchars($_POST['liabilityDisclaimer']);
    $status = htmlspecialchars($_POST['status']);

    $sql_check_changes = "SELECT * FROM `terms_conditions` WHERE id = ?";
    $params_check_changes = [$id];
    $result_check_changes = $db->run($sql_check_changes, $params_check_changes);

    if ($result_check_changes["status"] == "success" && !empty($result_check_changes["data"])) {
        $existing_tc = $result_check_changes["data"][0];

        if (
            $existing_tc['title'] == $title &&
            $existing_tc['content'] == $content &&
            $existing_tc['cancellationPolicy'] == $cancellationPolicy &&
            $existing_tc['refundPolicy'] == $refundPolicy &&
            $existing_tc['liabilityDisclaimer'] == $liabilityDisclaimer &&
            $existing_tc['status'] == $status
        ) {
            $no_changes_message = "No changes were made.";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1000);
            </script>';
        } else {
            $sql = "UPDATE `terms_conditions` SET title = ?, content = ?, cancellationPolicy = ?, refundPolicy = ?, liabilityDisclaimer = ?, status = ? WHERE id = ?";
            $params = [$title, $content, $cancellationPolicy, $refundPolicy, $liabilityDisclaimer, $status, $id];
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
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?= $title ?? '' ?>" placeholder="Title" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="content">Content</label>
                                    <textarea class="form-control z-depth-1" id="content" name="content" rows="5" placeholder="Write Something here" required><?= $content ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="cancellationPolicy">Cancellation Policy</label>
                                    <textarea class="form-control z-depth-1" id="cancellationPolicy" name="cancellationPolicy" rows="5" placeholder="Write Something here" required><?= $cancellationPolicy ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="refundPolicy">Refund Policy</label>
                                    <textarea class="form-control z-depth-1" id="refundPolicy" name="refundPolicy" rows="5" placeholder="Write Something here" required><?= $refundPolicy ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="liabilityDisclaimer">Liability Disclaimer</label>
                                    <textarea class="form-control z-depth-1" id="liabilityDisclaimer" name="liabilityDisclaimer" rows="5" placeholder="Write Something here" required><?= $liabilityDisclaimer ?? '' ?></textarea>
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
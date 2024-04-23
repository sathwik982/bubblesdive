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

    $sql = "SELECT * FROM `gallery` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $gallery = $result["data"][0];

        $mediaType = htmlspecialchars($gallery['mediaType']);
        $status = htmlspecialchars($gallery['status']);
        $mediaUrlPath = htmlspecialchars($gallery['mediaUrl']);
    } else {
        $error_message = "Record not found.";
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
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                <input type="hidden" name="currentMediaUrl" value="<?= isset($mediaUrlPath) ? htmlspecialchars($mediaUrlPath) : ''; ?>">
                                <div class="mb-3">
                                    <label for="mediaType" class="form-label">Media Type</label>
                                    <select class="form-control" name="mediaType" disabled>
                                        <option value="" <?= !isset($mediaType) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="IMAGE" <?= (isset($mediaType) && $mediaType == 'IMAGE') ? 'selected' : '' ?>>IMAGE</option>
                                        <option value="VIDEO" <?= (isset($mediaType) && $mediaType == 'VIDEO') ? 'selected' : '' ?>>VIDEO</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mediaUrl" class="form-label">Media (Image or Video)</label>
                                    <br>
                                    <?php if ($mediaType == 'IMAGE') : ?>
                                        <img src="<?= $mediaUrlPath ?>" alt="Current Media" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php elseif ($mediaType == 'VIDEO') : ?>
                                        <video width="200" height="200" controls>
                                            <source src="<?= $mediaUrlPath ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status" disabled>
                                        <option value="" <?= !isset($status) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="PUBLISH" <?= (isset($status) && $status == 'PUBLISH') ? 'selected' : '' ?>>PUBLISH</option>
                                        <option value="UNPUBLISH" <?= (isset($status) && $status == 'UNPUBLISH') ? 'selected' : '' ?>>UNPUBLISH</option>
                                    </select>
                                </div>
                                <a href="index.php" class="btn btn-success">Back</a>
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
        </body>

        </html>
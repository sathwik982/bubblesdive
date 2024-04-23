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
        $mediaUrl = htmlspecialchars($gallery['mediaUrl']);
        $status = htmlspecialchars($gallery['status']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $mediaType = htmlspecialchars($_POST['mediaType']);
    $status = htmlspecialchars($_POST['status']);

    $currentMediaUrl = htmlspecialchars($_POST['currentMediaUrl']);

    if (!empty($_FILES["mediaUrl"]["name"])) {
        $targetDirectory = "../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["mediaUrl"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($mediaType == "IMAGE" && !in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
            $error_message = "For image media type, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        } elseif ($mediaType == "VIDEO" && !in_array($fileType, ["mp4", "avi", "mkv", "mov"])) {
            $error_message = "For video media type, only MP4, AVI, MKV, and MOV files are allowed.";
            $uploadOk = 0;
        }

        if ($_FILES["mediaUrl"]["size"] > 10000000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $error_message .= " Your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["mediaUrl"]["tmp_name"], $targetFile)) {
                $mediaUrl = basename($_FILES["mediaUrl"]["name"]);
                $mediaUrlPath = "../uploads/" . $mediaUrl;

                $sql = "UPDATE `gallery` SET mediaType = ?, mediaUrl = ?, status = ? WHERE id = ?";
                $params = [$mediaType, $mediaUrlPath, $status, $id];
                $update_result = $db->run($sql, $params);

                if ($update_result["status"] == "success") {
                    $success_message = "Record has been updated successfully!";
                    echo '<script>
                            setTimeout(function() {
                                window.location.href = "index.php";
                            }, 1000); 
                        </script>';
                    $mediaUrl = $mediaUrlPath;
                } else {
                    $error_message = "Failed to update record details. Please try again.";
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $sql = "UPDATE `gallery` SET mediaType = ?, status = ? WHERE id = ?";
        $params = [$mediaType, $status, $id];
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
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                <input type="hidden" name="currentMediaUrl" value="<?= isset($mediaUrl) ? htmlspecialchars($mediaUrl) : ''; ?>">
                                <div class="mb-3">
                                    <label for="mediaType" class="form-label">Media Type</label>
                                    <select class="form-control" name="mediaType" required>
                                        <option value="" <?= !isset($mediaType) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="IMAGE" <?= (isset($mediaType) && $mediaType == 'IMAGE') ? 'selected' : '' ?>>IMAGE</option>
                                        <option value="VIDEO" <?= (isset($mediaType) && $mediaType == 'VIDEO') ? 'selected' : '' ?>>VIDEO</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mediaUrl" class="form-label">Media (Image or Video)</label>
                                    <input class="form-control form-control-sm" id="mediaUrl" name="mediaUrl" type="file" accept=".jpeg, .png, .jpg, .mp4, .avi, .mov, image/jpeg, image/png, video/mp4, video/avi, video/quicktime">
                                </div>
                                <div class="mb-3">
                                    <?php if (!empty($mediaUrl) && file_exists($mediaUrl)) : ?>
                                        <?php if ($mediaType == 'IMAGE') : ?>
                                            <img src="<?= $mediaUrl ?>" alt="Current Media" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        <?php elseif ($mediaType == 'VIDEO') : ?>
                                            <video width="320" height="240" controls>
                                                <source src="<?= $mediaUrl ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <p>No Media available</p>
                                    <?php endif; ?>
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
                                <a href="index.php" class="btn btn-danger">Back</a>
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
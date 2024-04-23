<?php
session_start();

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

$userData = $_SESSION["auth"];

include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}



?>

<?php include '../layout/_assign.php';






$error_message = '';
$success_message = '';
$no_changes_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `blogs` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $about = $result["data"][0];

        $blogHeading = htmlspecialchars($about['blogHeading']);
        $subHeading = htmlspecialchars($about['subHeading']);
        $comments = htmlspecialchars($about['comments']);
        $status = htmlspecialchars($about['status']);
        $blogImagePath = htmlspecialchars($about['blogImage']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $blogHeading = htmlspecialchars($_POST['blogHeading']);
    $subHeading = htmlspecialchars($_POST['subHeading']);
    $comments = htmlspecialchars($_POST['comments']);
    $status = htmlspecialchars($_POST['status']);

    if (!empty($_FILES["bannerImage"]["name"])) {
        $targetDirectory = "../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["bannerImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["bannerImage"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["bannerImage"]["size"] > 5000000) {
                $error_message = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $error_message .= " Your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["bannerImage"]["tmp_name"], $targetFile)) {
                $blogImage = basename($_FILES["bannerImage"]["name"]);
                $blogImagePath = "../uploads/" . $blogImage;

                $sql = "UPDATE `blogs` SET blogHeading = ?, subHeading = ?, comments = ?, status = ?, blogImage = ? WHERE id = ?";
                $params = [$blogHeading, $subHeading, $comments, $status, $blogImagePath, $id];
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
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {

        $sql = "UPDATE `blogs` SET blogHeading = ?, subHeading = ?, comments = ?, status = ? WHERE id = ?";
        $params = [$blogHeading, $subHeading, $comments, $status, $id];
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
                                    <label for="blogHeading" class="form-label">Article Heading</label>
                                    <input type="text" class="form-control" name="blogHeading" id="blogHeading" value="<?= $blogHeading ?? '' ?>" placeholder="Article Heading" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="subHeading">Sub-Heading</label>
                                    <textarea class="form-control z-depth-1" id="subHeading" name="subHeading" rows="5" placeholder="Write Something here" required><?= $subHeading ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="comments">Article Content</label>
                                    <textarea class="form-control z-depth-1" id="comments" name="comments" rows="5" placeholder="Write Something here" required><?= $comments ?? '' ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="bannerImage" class="form-label">Article Image</label>
                                    <input class="form-control form-control-sm" id="bannerImage" name="bannerImage" type="file" accept=".jpeg, .png, .jpg, image/jpeg, image/png">
                                </div>
                                <div class="mb-3">
                                    <?php if (!empty($blogImagePath) && file_exists($blogImagePath)) : ?>
                                        <img src="<?= $blogImagePath ?>" alt="Current Banner Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No banner image available</p>
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
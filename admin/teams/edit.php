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

    $sql = "SELECT * FROM `teams` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $teams = $result["data"][0];

        $name = htmlspecialchars($teams['name']);
        $mobileNumber = htmlspecialchars($teams['mobileNumber']);
        $hireDate = htmlspecialchars($teams['hireDate']);
        $description = htmlspecialchars($teams['description']);
        $status = htmlspecialchars($teams['status']);
        $facebook = htmlspecialchars($teams['facebook']);
        $instagram = htmlspecialchars($teams['instagram']);
        $twitter = htmlspecialchars($teams['twitter']);
        $email = htmlspecialchars($teams['email']);
        $photo = htmlspecialchars($teams['photo']);
    } else {
        $error_message = "Record not found or error fetching data.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);
    $hireDate = htmlspecialchars($_POST['hireDate']);
    $description = htmlspecialchars($_POST['description']);
    $status = htmlspecialchars($_POST['status']);
    $facebook = htmlspecialchars($_POST['facebook']);
    $instagram = htmlspecialchars($_POST['instagram']);
    $twitter = htmlspecialchars($_POST['twitter']);
    $email = htmlspecialchars($_POST['email']);

    if (!empty($_FILES["photo"]["name"])) {
        $targetDirectory = "../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["photo"]["size"] > 5000000) {
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
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                $photo = basename($_FILES["photo"]["name"]);
                $photoImagePath = "../uploads/" . $photo;



                $sql = "UPDATE `teams` SET name = ?, mobileNumber = ?, hireDate = ?, description = ?, photo = ?, facebook = ?, instagram = ?, twitter = ?, email = ? WHERE id = ?";
                $params = [$name, $mobileNumber, $hireDate, $description, $photoImagePath, $facebook, $instagram, $twitter, $email, $id];
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
        $sql = "UPDATE `teams` SET name = ?, mobileNumber = ?, hireDate = ?, description = ?, facebook = ?, instagram = ?, twitter = ?, email = ? WHERE id = ?";
        $params = [$name, $mobileNumber, $hireDate, $description, $facebook, $instagram, $twitter, $email, $id];
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
                                    <label for="name" class="form-label">Staff Name</label>
                                    <input type="text" class="form-control" name="name" id="blogHeading" value="<?= $name ?? '' ?>" placeholder="Staff Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" value="<?= $mobileNumber ?? '' ?>" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>

                                <div class="mb-3">
                                    <label for="hireDate" class="form-label">Hire Date</label>
                                    <input type="date" class="form-control" name="hireDate" id="hireDate" value="<?= $hireDate ?? '' ?>" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="description">Description</label>
                                    <textarea class="form-control z-depth-1" id="description" name="description" rows="5" placeholder="Write Something here" required><?= $description ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook" value="<?= $facebook ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Instagram" value="<?= $instagram ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter" value="<?= $twitter ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email ?? '' ?>">
                                </div>


                                <div class="mb-3">
                                    <label for="photo" class="form-label">Staff Photo</label>
                                    <input class="form-control form-control-sm" id="photo" name="photo" type="file" accept=".jpeg, .png, .jpg, image/jpeg, image/png">
                                </div>
                                <div class="mb-3">
                                    <?php if (!empty($photo) && file_exists("../uploads/" . $photo)) : ?>
                                        <img src="<?= "../uploads/" . $photo ?>" alt="Current Staff Photo" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No Image available</p>
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
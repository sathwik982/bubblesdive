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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $establishedDate = htmlspecialchars($_POST['establishedDate']);
    $servicesOffered = htmlspecialchars($_POST['servicesOffered']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $status = htmlspecialchars($_POST['status']);

    $uploadsDirectory = "../uploads/";

    $targetFile = $uploadsDirectory . basename($_FILES["bannerImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["bannerImage"]["tmp_name"], $targetFile)) {
        if ($_FILES["bannerImage"]["size"] > 5000000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $error_message = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $bannerImage = basename($_FILES["bannerImage"]["name"]);
            $uploadsDirectory = str_replace(".", "", $uploadsDirectory);
            $bannerImagePath = "../uploads/" . $bannerImage;

            if (!empty($status)) {
                $sql = "INSERT INTO `about` (name, establishedDate, servicesOffered, location, description, status, bannerImage) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $params = [$name, $establishedDate, $servicesOffered, $location, $description, $status, $bannerImagePath];
                $result = $db->run($sql, $params);

                if ($result["status"] == "success") {
                    $success_message = "Record has been added successfully! Redirecting...";
                    echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 1000);
</script>';
                } else {
                    $error_message = "Failed to add record details. Please try again.";
                }
            }
        }
    } else {
        $error_message = "Sorry, there was an error uploading your file.";
    }
}

$sql = "SELECT *, DATE_FORMAT(createdDate, '%d-%b-%Y') as `cdate` FROM `about`";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $about = $result["data"];
}
?>

<!-- TEMPLATE STARTS -->

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
            <h2 class="header-title">Add Record</h2>
            <div class="header-sub-title"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="establishedDate" class="form-label">Established Date</label>
                                        <input type="date" class="form-control" name="establishedDate" id="establishedDate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Location" required>
                                    </div>
                                    <div class="form-group shadow-textarea">
                                        <label for="servicesOffered">Services Offered</label>
                                        <textarea class="form-control z-depth-1" id="servicesOffered" name="servicesOffered" rows="5" placeholder="Write Something here" required></textarea>
                                    </div>

                                    <div class="form-group shadow-textarea">
                                        <label for="description">Description</label>
                                        <textarea class="form-control z-depth-1" id="description" name="description" rows="5" placeholder="Write Something here" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bannerImage" class="form-label">Banner Image</label>
                                        <input class="form-control form-control-sm" id="bannerImage" name="bannerImage" type="file" accept=".jpeg, .png, .jpg, image/jpeg, image/png" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label><br>
                                        <select class="form-control" name="status" required>
                                            <option value="" selected>Please Select</option>
                                            <option value="PUBLISH">PUBLISH</option>
                                            <option value="UNPUBLISH">UNPUBLISH</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>

        <?php include '../layout/_scripts.php'; ?>
        <!-- Custom script to display success or error messages in modal -->
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        <!-- End custom script -->

        </body>

        </html>
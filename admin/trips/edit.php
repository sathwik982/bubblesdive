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

if (isset($_GET['tripId'])) {
    $tripId = intval($_GET['tripId']);

    $sql = "SELECT * FROM `trips` WHERE tripId = ?";
    $params = [$tripId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $trips = $result["data"][0];

        $tripName = htmlspecialchars($trips['tripName']);
        $tripType = htmlspecialchars($trips['tripType']);
        $price = floatval($trips['price']);
        $tripDate = htmlspecialchars($trips['tripDate']);
        $tripDuration = htmlspecialchars($trips['tripDuration']);
        $tripIncluded = htmlspecialchars($trips['tripIncluded']);
        $locations = htmlspecialchars($trips['locations']);
        $tripDescription = htmlspecialchars($trips['tripDescription']);
        $status = htmlspecialchars($trips['status']);
        $tripPicturePath = htmlspecialchars($trips['tripPicture']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tripId = intval($_POST['tripId']);
    $tripName = htmlspecialchars($_POST['tripName']);
    $tripType = htmlspecialchars($_POST['tripType']);
    $price = htmlspecialchars($_POST['price']);
    $tripDate = htmlspecialchars($_POST['tripDate']);
    $tripDuration = htmlspecialchars($_POST['tripDuration']);
    $tripIncluded = htmlspecialchars($_POST['tripIncluded']);
    $locations = htmlspecialchars($_POST['locations']);
    $tripDescription = htmlspecialchars($_POST['tripDescription']);
    $status = htmlspecialchars($_POST['status']);

    if (!empty($_FILES["tripPicture"]["name"])) {
        $targetDirectory = "../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["tripPicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["tripPicture"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["tripPicture"]["size"] > 5000000) {
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
            if (move_uploaded_file($_FILES["tripPicture"]["tmp_name"], $targetFile)) {
                $tripPicture = basename($_FILES["tripPicture"]["name"]);
                $tripPicturePath = "../uploads/" . $tripPicture;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    $sql = "UPDATE `trips` SET tripName = ?, tripType = ?, price = ?, tripDate = ?, tripDuration = ?, tripIncluded = ?, locations = ?, tripDescription = ?";
    $params = [$tripName, $tripType, $price, $tripDate, $tripDuration, $tripIncluded, $locations, $tripDescription];

    if (!empty($_FILES["tripPicture"]["name"])) {
        $sql .= ", tripPicture = ?";
        $params[] = $tripPicturePath;
    }

    $sql .= ", status = ? WHERE tripId = ?";
    $params[] = $status;
    $params[] = $tripId;

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

?>


<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<div class="page-container">
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
                                <input type="hidden" name="tripId" value="<?php echo isset($_GET['tripId']) ? $_GET['tripId'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="tripName" class="form-label">Trip Name</label>
                                    <input type="text" class="form-control" name="tripName" id="tripName" value="<?= $tripName ?? '' ?>" placeholder="Trip Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripType" class="form-label">Trip Type</label>
                                    <input type="text" class="form-control" name="tripType" id="tripType" value="<?= $tripType ?? '' ?>" placeholder="Trip Type" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" value="<?= $price ?? '' ?>" placeholder="Price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripDate" class="form-label">Trip Date</label>
                                    <input type="text" class="form-control" name="tripDate" id="tripDate" value="<?= $tripDate ?? '' ?>" placeholder="Trip Date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripDuration" class="form-label">Trip Duration</label>
                                    <input type="text" class="form-control" name="tripDuration" id="tripDuration" value="<?= $tripDuration ?? '' ?>" placeholder="Trip Duration" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripIncluded" class="form-label">Trip Included</label>
                                    <textarea class="form-control" name="tripIncluded" id="tripIncluded" rows="3" placeholder="Trip Included" required><?= $tripIncluded ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="locations" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="locations" id="locations" placeholder="Location" value="<?= $locations ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripDescription" class="form-label">Trip Description</label>
                                    <textarea class="form-control" name="tripDescription" id="tripDescription" rows="5" placeholder="Trip Description" required><?= $tripDescription ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tripPicture" class="form-label">Trip Picture</label>
                                    <input type="file" class="form-control" name="tripPicture" id="tripPicture">
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
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>

        </body>

        </html>
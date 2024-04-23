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

<?php include '../layout/_assign.php'; ?>

<?php
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["tripPicture"]["name"])) {
        $uploadsDirectory = "../uploads/";
        $targetFile = $uploadsDirectory . basename($_FILES["tripPicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["tripPicture"]["tmp_name"], $targetFile)) {

            $tripName = htmlspecialchars($_POST['tripName']);
            $tripType = htmlspecialchars($_POST['tripType']);
            $price = htmlspecialchars($_POST['price']);
            $tripDuration = htmlspecialchars($_POST['tripDuration']);
            $tripDate = htmlspecialchars($_POST['tripDate']);
            $tripIncluded = htmlspecialchars($_POST['tripIncluded']);
            $locations = htmlspecialchars($_POST['locations']);
            $tripDescription = htmlspecialchars($_POST['tripDescription']);
            $status = htmlspecialchars($_POST['status']);

            $tripPicture = basename($_FILES["tripPicture"]["name"]);
            $tripPicturePath = "../uploads/" . $tripPicture;

            $sql = "INSERT INTO `trips` (tripName, tripType, price, tripDuration, tripDate, tripIncluded, locations, tripDescription, tripPicture, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = [$tripName, $tripType, $price, $tripDuration, $tripDate, $tripIncluded, $locations, $tripDescription, $tripPicturePath, $status];
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
        } else {

            $error_message = "Sorry, there was an error uploading your file.";
        }
    } else {

        $error_message = "Please select a file.";
    }
}

$sql = "SELECT *, DATE_FORMAT(createdDate, '%d-%b-%Y') as `cdate` FROM `trips`";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $trips = $result["data"];
}
?>


<!-- TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">Add Record</h2>
            <div class="header-sub-title">
            </div>
        </div>

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
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="tripName" class="form-label">Trip Name</label>
                                    <input type="text" class="form-control" name="tripName" id="tripName" placeholder="Trip Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripType" class="form-label">Trip Type</label>
                                    <input type="text" class="form-control" name="tripType" id="tripType" placeholder="Trip Type" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="tripDuration" class="form-label">Trip Duration</label>
                                    <input type="text" class="form-control" name="tripDuration" id="tripDuration" placeholder="Trip Duration" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripDate" class="form-label">Trip Date</label>
                                    <input type="date" class="form-control" name="tripDate" id="tripDate" placeholder="Trip Date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tripIncluded" class="form-label">Trip Included</label>
                                    <textarea class="form-control" name="tripIncluded" id="tripIncluded" rows="3" placeholder="Write Something here.." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="locations" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="locations" id="locations" placeholder="Location" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="tripDescription">Trip Description</label>
                                    <textarea class="form-control z-depth-1" id="tripDescription" name="tripDescription" rows="5" placeholder="Write Something here.." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tripPicture" class="form-label">Trip Picture</label>
                                    <input class="form-control form-control-sm" id="tripPicture" name="tripPicture" type="file" accept=".jpeg, .png, .jpg, image/jpeg, image/png" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-select" name="status" required>
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

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>

        <?php include '../layout/_scripts.php'; ?>
        <!-- scripts -->
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>

        </body>

        </html>
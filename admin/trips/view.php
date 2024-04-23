<?php
session_start();

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

include '../app/database/Connection.php';
$db = new Connection();

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
        $trip = $result["data"][0];

        $tripName = $trip['tripName'];
        $tripType = $trip['tripType'];
        $price = $trip['price'];
        $tripDuration = $trip['tripDuration'];
        $tripDate = $trip['tripDate'];
        $tripIncluded = $trip['tripIncluded'];
        $locations = $trip['locations'];
        $tripDescription = $trip['tripDescription'];
        $status = $trip['status'];
        $tripPicture = $trip['tripPicture'];
    } else {
        $error_message = "Record not found.";
    }
}

?>

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>

<div class="page-container">
    <div class="main-content">
        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger"><?= $error_message ?></div>
                                <?php else : ?>
                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="tripId" value="<?= $tripId ?? ''; ?>">
                                        <div class="mb-3">
                                            <label for="tripName" class="form-label">Trip Name</label>
                                            <input type="text" class="form-control" id="tripName" value="<?= $tripName ?? '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tripType" class="form-label">Trip Type</label>
                                            <input type="text" class="form-control" value="<?= $tripType ?? '' ?>" id="tripType" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" value="<?= $price ?? '' ?>" id="price" disabled>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tripDuration" class="form-label">Trip Duration</label>
                                            <input type="text" class="form-control" name="tripDuration" id="tripDuration" placeholder="Trip Duration" value="<?= $tripDuration ?? '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tripDate" class="form-label">Trip Date</label>
                                            <input type="date" class="form-control" name="tripDate" id="tripDate" placeholder="Trip Date" value="<?= $tripDate ?? '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tripIncluded" class="form-label">Trip Included</label>
                                            <textarea class="form-control" name="tripIncluded" id="tripIncluded" rows="3" placeholder="Trip Included" disabled><?= $tripIncluded ?? '' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="locations" class="form-label">Location</label>
                                            <input type="text" class="form-control" name="locations" id="locations" placeholder="Location" value="<?= $locations ?? '' ?>" disabled>
                                        </div>
                                        <div class="form-group shadow-textarea">
                                            <label for="tripDescription">Trip Description</label>
                                            <textarea class="form-control z-depth-1" id="tripDescription" name="tripDescription" rows="5" placeholder="Write Something here.." readonly><?= $tripDescription ?? '' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tripPicture" class="form-label">Trip Picture</label>
                                            <br>
                                            <?php if (!empty($tripPicture) && file_exists("../uploads/" . $tripPicture)) : ?>
                                                <img src="<?= "../uploads/" . $tripPicture ?>" alt="Trip Picture" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            <?php else : ?>
                                                <p>No Image available</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label><br>
                                            <input type="text" class="form-control" value="<?= $status ?? '' ?>" disabled>
                                        </div>
                                        <a href="index.php" class="btn btn-success">Back</a>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
    </div>
</div>
</body>

</html>
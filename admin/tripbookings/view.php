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

if (isset($_GET['bookingId'])) {
    $bookingId = intval($_GET['bookingId']);

    $sql = "SELECT cb.*, DATE_FORMAT(cb.createdDate,'%d-%b-%Y') as `cdate`, c.customerFullName, co.tripName, l.languageName 
            FROM `trip_bookings` cb
            JOIN `customers` c ON cb.customerId = c.customerId 
            JOIN `trips` co ON cb.tripId = co.tripId 
            JOIN `languages` l ON cb.languageId = l.languageId 
            WHERE cb.bookingId = ?";
    $params = [$bookingId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $trip_bookings = $result["data"][0];

        $customerId = htmlspecialchars($trip_bookings['customerId']);
        $customerFullName = htmlspecialchars($trip_bookings['customerFullName']);
        $tripId = htmlspecialchars($trip_bookings['tripId']);
        $tripName = htmlspecialchars($trip_bookings['tripName']);
        $languageId = htmlspecialchars($trip_bookings['languageId']);
        $languageName = htmlspecialchars($trip_bookings['languageName']);
        $email = htmlspecialchars($trip_bookings['email']);
        $customerMobile = htmlspecialchars($trip_bookings['mobileNumber']);
        $gears = htmlspecialchars($trip_bookings['gears']);
        $shoeSize = htmlspecialchars($trip_bookings['shoeSize']);
        $tshirtSize = htmlspecialchars($trip_bookings['tshirtSize']);
        $passportNumber = htmlspecialchars($trip_bookings['passportNumber']);
        $padiCertificateNumber = htmlspecialchars($trip_bookings['padiCertificateNumber']);
        $certificateDocument = htmlspecialchars($trip_bookings['certificateDocument']);
        $bookingDate = htmlspecialchars($trip_bookings['bookingDate']);
        $total_price = floatval($trip_bookings['total_price']);
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
                                <input type="hidden" name="bookingId" value="<?php echo isset($_GET['bookingId']) ? $_GET['bookingId'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="customerFullName" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="customerFullName" id="customerFullName" value="<?= $customerFullName ?? '' ?>" placeholder="Customer Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="tripName" class="form-label">Trip Name</label>
                                    <input type="text" class="form-control" name="courseName" id="tripName" value="<?= $tripName ?? '' ?>" placeholder="Trip Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="languageName" class="form-label">Language</label>
                                    <input type="text" class="form-control" name="languageName" id="languageName" value="<?= $languageName ?? '' ?>" placeholder="Language" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerEmail" class="form-label">Customer Email</label>
                                    <input type="email" class="form-control" name="customerEmail" id="customerEmail" value="<?= $email ?? '' ?>" placeholder="Customer Email" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerMobile" class="form-label">Customer Mobile Number</label>
                                    <input type="number" class="form-control" name="customerMobile" id="customerMobile" value="<?= $customerMobile ?? '' ?>" placeholder="Customer Mobile Number" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="tshirtSize" class="form-label">Tshirt Size</label>
                                    <input type="text" class="form-control" name="tshirtSize" id="tshirtSize" value="<?= $tshirtSize ?? '' ?>" placeholder="Tshirt Size" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="gears" class="form-label">Gears</label>
                                    <input type="text" class="form-control" name="gears" id="gears" value="<?= $gears ?? '' ?>" placeholder="Gears" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="shoeSize" class="form-label">Shoe Size</label>
                                    <input type="text" class="form-control" name="shoeSize" id="shoeSize" value="<?= $shoeSize ?? '' ?>" placeholder="Shoe Size" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="padiCertificateNumber" class="form-label">Padi Certificate Number</label>
                                    <input type="text" class="form-control" name="padiCertificateNumber" id="padiCertificateNumber" value="<?= $padiCertificateNumber ?? '' ?>" placeholder="Padi Certificate Number" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="certificateDocument" class="form-label">Padi Certificate Document</label>
                                    <br>
                                    <?php if (!empty($certificateDocument) && file_exists("../uploads/" . $certificateDocument)) : ?>
                                        <embed src="<?= "../uploads/" . $certificateDocument ?>" type="application/pdf" style="width: 100%; height: 600px;" />
                                    <?php else : ?>
                                        <p>No Document available</p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="bookingDate" class="form-label">Booking Date</label>
                                    <input type="date" class="form-control" name="bookingDate" id="bookingDate" value="<?= $bookingDate ?? '' ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="totalPrice" class="form-label">Total Price</label>
                                    <input type="number" class="form-control" name="totalPrice" id="totalPrice" value="<?= $total_price ?? '' ?>" placeholder="Total Price" readonly>
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
        </body>

        </html>
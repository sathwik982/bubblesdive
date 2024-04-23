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

    $sql = "SELECT cb.*, DATE_FORMAT(cb.createdDate,'%d-%b-%Y') as `cdate`, c.customerFullName, co.courseName, l.languageName 
            FROM `course_bookings` cb
            JOIN `customers` c ON cb.customerId = c.customerId 
            JOIN `courses` co ON cb.courseId = co.courseId 
            JOIN `languages` l ON cb.languageId = l.languageId 
            WHERE cb.bookingId = ?";
    $params = [$bookingId];
    $result = $db->run($sql, $params);


    if ($result["status"] == "success" && !empty($result["data"])) {
        $course_bookings = $result["data"][0];

        $customerId = htmlspecialchars($course_bookings['customerId']);
        $customerFullName = htmlspecialchars($course_bookings['customerFullName']);
        $courseId = htmlspecialchars($course_bookings['courseId']);
        $courseName = htmlspecialchars($course_bookings['courseName']);
        $languageId = htmlspecialchars($course_bookings['languageId']);
        $languageName = htmlspecialchars($course_bookings['languageName']);
        $email = htmlspecialchars($course_bookings['email']);
        $customerMobile = htmlspecialchars($course_bookings['mobileNumber']);
        $diverStatus = htmlspecialchars($course_bookings['diverStatus']);
        $passportNumber = htmlspecialchars($course_bookings['passportNumber']);
        $padicertificateNumber = htmlspecialchars($course_bookings['padicertificateNumber']);
        $certificateDocument = htmlspecialchars($course_bookings['certificateDocument']);
        $bookingDate = htmlspecialchars($course_bookings['bookingDate']);
        $total_price = floatval($course_bookings['total_price']);
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
                                    <label for="courseName" class="form-label">Course Name</label>
                                    <input type="text" class="form-control" name="courseName" id="courseName" value="<?= $courseName ?? '' ?>" placeholder="Course Name" readonly>
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
                                    <label for="diverStatus" class="form-label">Diver Status</label>
                                    <input type="text" class="form-control" name="diverStatus" id="diverStatus" value="<?= $diverStatus ?? '' ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="passportNumber" class="form-label">Passport Number</label>
                                    <input type="text" class="form-control" name="passportNumber" id="passportNumber" value="<?= $passportNumber ?? '' ?>" placeholder="Passport Number" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="padiCertificateNumber" class="form-label">Padi Certificate Number</label>
                                    <input type="text" class="form-control" name="padiCertificateNumber" id="padiCertificateNumber" value="<?= $padicertificateNumber ?? '' ?>" placeholder="Padi Certificate Number" readonly>
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
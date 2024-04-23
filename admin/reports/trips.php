<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$userData = $_SESSION["auth"];

include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

?>

<?php include '../layout/_assign.php';

$reportData = [];


$sqlTripTypes = "SELECT tripId, tripName FROM trips";
$stmtTripTypes = $db->getConnection()->prepare($sqlTripTypes);
$stmtTripTypes->execute();
$tripTypes = $stmtTripTypes->fetchAll(PDO::FETCH_ASSOC);

$sqllanguageName = "SELECT languageId, languageName FROM languages";
$stmtlanguageName = $db->getConnection()->prepare($sqllanguageName);
$stmtlanguageName->execute();
$languageName = $stmtlanguageName->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $fromDate = htmlspecialchars($_POST['fromDate']);
    $toDate = htmlspecialchars($_POST['toDate']);
    $tripId = htmlspecialchars($_POST['tripId']);
    $languageId = htmlspecialchars($_POST['languageId']);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Customer Name');
    $sheet->setCellValue('B1', 'Mobile Number');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Trip Name');
    $sheet->setCellValue('E1', 'Language');
    $sheet->setCellValue('F1', 'TshirtSize');
    $sheet->setCellValue('G1', 'Gears');
    $sheet->setCellValue('H1', 'Shoe Size');
    $sheet->setCellValue('I1', 'Passport Number');
    $sheet->setCellValue('J1', 'Padi Certificate Number');
    $sheet->setCellValue('K1', 'Booking Date');
    $sheet->setCellValue('L1', 'Total Price');
    $sheet->setCellValue('M1', 'Created Date');

    $sql = "SELECT tb.*, 
       t.tripName, 
       l.languageName,
       DATE_FORMAT(tb.createdDate,'%d-%b-%Y') as `cdate`
        FROM trip_bookings tb
        JOIN trips t ON tb.tripId = t.tripId
        JOIN languages l ON tb.languageId = l.languageId
        WHERE tb.createdDate BETWEEN :fromDate AND :toDate";

    if (!empty($tripId)) {
        $sql .= " AND tb.tripId = :tripId";
    }

    if (!empty($languageId)) {
        $sql .= " AND l.languageId = :languageId";
    }

    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);

    if (!empty($tripId)) {
        $stmt->bindValue(':tripId', $tripId);
    }

    if (!empty($languageId)) {
        $stmt->bindValue(':languageId', $languageId);
    }

    $stmt->execute();
    $trip_bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $row = 2;
    foreach ($trip_bookings as $trip_booking) {
        $sheet->setCellValue('A' . $row, $trip_booking['fullName']);
        $sheet->setCellValue('B' . $row, $trip_booking['mobileNumber']);
        $sheet->setCellValue('C' . $row, $trip_booking['email']);
        $sheet->setCellValue('D' . $row, $trip_booking['tripName']);
        $sheet->setCellValue('E' . $row, $trip_booking['languageName']);
        $sheet->setCellValue('F' . $row, $trip_booking['tshirtSize']);
        $sheet->setCellValue('G' . $row, $trip_booking['gears']);
        $sheet->setCellValue('H' . $row, $trip_booking['shoeSize']);
        $sheet->setCellValue('I' . $row, $trip_booking['passportNumber']);
        $sheet->setCellValue('J' . $row, $trip_booking['padiCertificateNumber']);
        $sheet->setCellValue('K' . $row, $trip_booking['bookingDate']);
        $sheet->setCellValue('L' . $row, $trip_booking['total_price']);
        $sheet->setCellValue('M' . $row, $trip_booking['createdDate']);



        $reportData[] = [
            'fullName' => $trip_booking['fullName'],
            'mobileNumber' => $trip_booking['mobileNumber'],
            'email' => $trip_booking['email'],
            'tripName' => $trip_booking['tripName'],
            'languageName' => $trip_booking['languageName'],
            'tshirtSize' => $trip_booking['tshirtSize'],
            'gears' => $trip_booking['gears'],
            'shoeSize' => $trip_booking['shoeSize'],
            'passportNumber' => $trip_booking['passportNumber'],
            'padiCertificateNumber' => $trip_booking['padiCertificateNumber'],
            'bookingDate' => $trip_booking['bookingDate'],
            'total_price' => $trip_booking['total_price'],
            'createdDate' => $trip_booking['createdDate']
        ];

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'trip_report_' . date('Ymd') . '.xlsx';
    $writer->save($filename);
}

?>


<!-- TEMPLATE STARTS -->

<!-- TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">Trip Bookings Orders</h2>
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
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-2">
                            <form method="POST" action="">
                                <label>From Date</label>
                                <input type="date" class="form-control" id="fromDate" name="fromDate" placeholder="From Date" required value="<?= isset($_POST['fromDate']) ? $_POST['fromDate'] : '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label>To Date</label>
                            <input type="date" class="form-control" id="toDate" name="toDate" placeholder="To Date" value="<?= isset($_POST['toDate']) ? $_POST['toDate'] : '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="tripId" class="form-label">Trip Name</label>
                            <select name="tripId" id="tripId" class="form-select">
                                <option value="">Show All</option>
                                <?php foreach ($tripTypes as $trip) : ?>
                                    <?php $selected = ($trip['tripId'] == $tripId) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($trip['tripId']) ?>" <?= $selected ?>><?= htmlspecialchars($trip['tripName']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="languageId" class="form-label">Language</label>
                            <select name="languageId" id="languageId" class="form-select">
                                <option value="">Show All</option>
                                <?php foreach ($languageName as $language) : ?>
                                    <?php $selected = ($language['languageId'] == $languageId) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($language['languageId']) ?>" <?= $selected ?>><?= htmlspecialchars($language['languageName']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2" style="text-align: left; padding-top: 24px;">
                            <button type="submit" name="generate_report" class="btn btn-success waves-effect btn-label waves-light">
                                <i class="bx bx-plus-medical label-icon"></i> Generate
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if (!empty($reportData)) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card mt-5">
                            <div class="card-body">
                                <a href="<?= $filename ?>" class="btn btn-success btn-sm" style="margin-left: 950px;">
                                    <i class="bx bx-download"></i> Download
                                </a>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                                <th>Trip Name</th>
                                                <th>Language</th>
                                                <th>Tshirt Size</th>
                                                <th>Gears</th>
                                                <th>Shoe Size</th>
                                                <th>Passport Number</th>
                                                <th>Padi Certificate Number</th>
                                                <th>Booking Date</th>
                                                <th>Total Price</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData as $trip_booking) : ?>
                                                <tr>
                                                    <td><?= $trip_booking['fullName']; ?></td>
                                                    <td><?= $trip_booking['mobileNumber']; ?></td>
                                                    <td><?= $trip_booking['email']; ?></td>
                                                    <td><?= $trip_booking['tripName']; ?></td>
                                                    <td><?= $trip_booking['languageName']; ?></td>
                                                    <td><?= $trip_booking['tshirtSize']; ?></td>
                                                    <td><?= $trip_booking['gears']; ?></td>
                                                    <td><?= $trip_booking['shoeSize']; ?></td>
                                                    <td><?= $trip_booking['passportNumber']; ?></td>
                                                    <td><?= $trip_booking['padiCertificateNumber']; ?></td>
                                                    <td><?= $trip_booking['bookingDate']; ?></td>
                                                    <td><?= $trip_booking['total_price']; ?></td>
                                                    <td><?= $trip_booking['createdDate']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($reportData) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) : ?>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="alert alert-danger" role="alert">
                            No orders found for the selected criteria.
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


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
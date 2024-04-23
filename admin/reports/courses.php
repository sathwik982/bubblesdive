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

$sqlCourseTypes = "SELECT courseId, courseName FROM courses";
$stmtCourseTypes = $db->getConnection()->prepare($sqlCourseTypes);
$stmtCourseTypes->execute();
$CourseTypes = $stmtCourseTypes->fetchAll(PDO::FETCH_ASSOC);

$sqllanguageName = "SELECT languageId, languageName FROM languages";
$stmtlanguageName = $db->getConnection()->prepare($sqllanguageName);
$stmtlanguageName->execute();
$languageName = $stmtlanguageName->fetchAll(PDO::FETCH_ASSOC);

// $sqllanguageName = "SELECT languageId, languageName FROM languages";
// $stmtlanguageName = $db->getConnection()->prepare($sqllanguageName);
// $stmtlanguageName->execute();
// $languageName = $stmtlanguageName->fetchAll(PDO::FETCH_ASSOC);



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $fromDate = htmlspecialchars($_POST['fromDate']);
    $toDate = htmlspecialchars($_POST['toDate']);
    $courseId = htmlspecialchars($_POST['courseId']);
    $languageId = htmlspecialchars($_POST['languageId']);


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Customer Name');
    $sheet->setCellValue('B1', 'Mobile Number');
    $sheet->setCellValue('C1', 'Email Address');
    $sheet->setCellValue('D1', 'Course Name');
    $sheet->setCellValue('E1', 'Language');
    $sheet->setCellValue('F1', 'Diver Status');
    $sheet->setCellValue('G1', 'Passport Number');
    $sheet->setCellValue('H1', 'Padi Certificate Number');
    $sheet->setCellValue('I1', 'Booking Date');
    $sheet->setCellValue('J1', 'Total Price');
    $sheet->setCellValue('K1', 'Created Date');

    $sql =
        "SELECT cb.*, 
       c.courseName, 
       l.languageName,
       DATE_FORMAT(cb.createdDate,'%d-%b-%Y') as `cdate`
        FROM course_bookings cb
        JOIN courses c ON cb.courseId = c.courseId
        JOIN languages l ON cb.languageId = l.languageId
        WHERE cb.createdDate BETWEEN :fromDate AND :toDate";

    if (!empty($courseId)) {
        $sql .= " AND cb.courseId = :courseId";
    }

    if (!empty($languageId)) {
        $sql .= " AND cb.languageId = :languageId";
    }


    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);


    if (!empty($courseId)) {
        $stmt->bindValue(':courseId', $courseId);
    }

    if (!empty($languageId)) {
        $stmt->bindValue(':languageId', $languageId);
    }

    $stmt->execute();
    $course_bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $row = 2;
    foreach ($course_bookings as $course_booking) {
        $sheet->setCellValue('A' . $row, $course_booking['fullName']);
        $sheet->setCellValue('B' . $row, $course_booking['mobileNumber']);
        $sheet->setCellValue('C' . $row, $course_booking['email']);
        $sheet->setCellValue('D' . $row, $course_booking['courseName']);
        $sheet->setCellValue('E' . $row, $course_booking['languageName']);
        $sheet->setCellValue('F' . $row, $course_booking['diverStatus']);
        $sheet->setCellValue('G' . $row, $course_booking['passportNumber']);
        $sheet->setCellValue('H' . $row, $course_booking['padicertificateNumber']);
        $sheet->setCellValue('I' . $row, $course_booking['bookingDate']);
        $sheet->setCellValue('J' . $row, $course_booking['total_price']);
        $sheet->setCellValue('K' . $row, $course_booking['createdDate']);

        $reportData[] = [
            'fullName' => $course_booking['fullName'],
            'mobileNumber' => $course_booking['mobileNumber'],
            'email' => $course_booking['email'],
            'courseName' => $course_booking['courseName'],
            'languageName' => $course_booking['languageName'],
            'diverStatus' => $course_booking['diverStatus'],
            'passportNumber' => $course_booking['passportNumber'],
            'padicertificateNumber' => $course_booking['padicertificateNumber'],
            'bookingDate' => $course_booking['bookingDate'],
            'total_price' => $course_booking['total_price'],
            'createdDate' => $course_booking['createdDate']
        ];

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'course_report_' . date('Ymd') . '.xlsx';
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
            <h2 class="header-title">Course Bookings Orders</h2>
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
                            <label for="courseId" class="form-label">Course Name</label>
                            <select name="courseId" id="courseId" class="form-select">
                                <option value="">Show All</option>
                                <?php foreach ($CourseTypes as $course) : ?>
                                    <?php $selected = ($course['courseId'] == $courseId) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($course['courseId']) ?>" <?= $selected ?>><?= htmlspecialchars($course['courseName']) ?></option>
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
                        <div class="col-md-2" style="text-align: left; padding-top: 25px;">
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
                                                <th>Customer Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                                <th>Course Name</th>
                                                <th>Language</th>
                                                <th>Diver Status</th>
                                                <th>Passport Number</th>
                                                <th>Padi Certificate Number</th>
                                                <th>Booking Date</th>
                                                <th>Total Price</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData as $course_booking) : ?>
                                                <tr>
                                                    <td><?= $course_booking['fullName']; ?></td>
                                                    <td><?= $course_booking['mobileNumber']; ?></td>
                                                    <td><?= $course_booking['email']; ?></td>
                                                    <td><?= $course_booking['courseName']; ?></td>
                                                    <td><?= $course_booking['languageName']; ?></td>
                                                    <td><?= $course_booking['diverStatus']; ?></td>
                                                    <td><?= $course_booking['passportNumber']; ?></td>
                                                    <td><?= $course_booking['padicertificateNumber']; ?></td>
                                                    <td><?= $course_booking['bookingDate']; ?></td>
                                                    <td><?= $course_booking['total_price']; ?></td>
                                                    <td><?= $course_booking['createdDate']; ?></td>
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
                            No Course Bookings found for the selected criteria.
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
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
$customerStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $fromDate = htmlspecialchars($_POST['fromDate']);
    $toDate = htmlspecialchars($_POST['toDate']);
    $customerStatus = htmlspecialchars($_POST['customerStatus']);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Customer Name');
    $sheet->setCellValue('B1', 'Mobile Number');
    $sheet->setCellValue('C1', 'Email Address');
    $sheet->setCellValue('D1', 'Address');
    $sheet->setCellValue('H1', 'Customer Status');
    $sheet->setCellValue('I1', 'Created Date');

    $sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` 
            FROM `customers` 
            WHERE createdDate BETWEEN :fromDate AND :toDate 
            AND (:customerStatus = '' OR customerStatus = UPPER(:customerStatus)) 
            ORDER BY createdDate DESC
            ";

    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);
    $stmt->bindValue(':customerStatus', $customerStatus);

    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $row = 2;
    foreach ($customers as $customer) {
        $sheet->setCellValue('A' . $row, $customer['customerFullName']);
        $sheet->setCellValue('B' . $row, $customer['customerMobileNumber']);
        $sheet->setCellValue('C' . $row, $customer['customerEmailAddress']);
        $sheet->setCellValue('D' . $row, $customer['address']);
        $sheet->setCellValue('E' . $row, $customer['customerStatus']);
        $sheet->setCellValue('I' . $row, $customer['createdDate']);

        $reportData[] = [
            'customerFullName' => $customer['customerFullName'],
            'customerMobileNumber' => $customer['customerMobileNumber'],
            'customerEmailAddress' => $customer['customerEmailAddress'],
            'address' => $customer['address'],
            'customerStatus' => $customer['customerStatus'],
            'createdDate' => $customer['createdDate']
        ];

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'customer_report_' . date('Ymd') . '.xlsx';
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
            <h2 class="header-title">Customers</h2>
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
                        <div class="col-md-3">
                            <form method="POST" action="">
                                <label>From Date</label>
                                <input type="date" class="form-control" id="fromDate" name="fromDate" placeholder="From Date" required value="<?= isset($_POST['fromDate']) ? $_POST['fromDate'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label>To Date</label>
                            <input type="date" class="form-control" id="toDate" name="toDate" placeholder="To Date" value="<?= isset($_POST['toDate']) ? $_POST['toDate'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="customerStatus" class="form-label">Status</label>
                            <select name="customerStatus" id="customerStatus" class="form-select">
                                <option value="">Show All</option>
                                <option value="ACTIVE" <?php if ($customerStatus === 'ACTIVE') echo 'selected'; ?>>ACTIVE</option>
                                <option value="INACTIVE" <?php if ($customerStatus === 'INACTIVE') echo 'selected'; ?>>INACTIVE</option>
                            </select>
                        </div>

                        <div class="col-md-3" style="text-align: left; padding-top: 24px;">
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
                                <a href="<?= $filename ?>" class="btn btn-success btn-sm" style="margin-left: 900px;">
                                    <i class="bx bx-download"></i> Download
                                </a>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                                <th>Address</th>
                                                <th>Customer Status</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData as $customer) : ?>
                                                <tr>
                                                    <td><?= $customer['customerFullName']; ?></td>
                                                    <td><?= $customer['customerMobileNumber']; ?></td>
                                                    <td><?= $customer['customerEmailAddress']; ?></td>
                                                    <td><?= $customer['address']; ?></td>
                                                    <td><?= $customer['customerStatus']; ?></td>
                                                    <td><?= $customer['createdDate']; ?></td>
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
                            No Customers found for the selected criteria.
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
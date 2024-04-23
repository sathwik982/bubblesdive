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

<?php include '../layout/_assign.php'; ?>

<?php

require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `testimonials` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $testimonials = $result["data"];
} else {
    $testimonials = [];
}

if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    $sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `testimonials` ORDER BY createdDate DESC";
    $result = $db->run($sql);

    if ($result["status"] == "success") {
        $testimonials = $result["data"];
    } else {
        $testimonials = [];
    }

    $spreadsheet = new Spreadsheet();

    $spreadsheet->getProperties()->setCreator("Your Name")
        ->setLastModifiedBy("Your Name")
        ->setTitle("Testimonials")
        ->setSubject("Testimonials Data")
        ->setDescription("Testimonials Data")
        ->setKeywords("testimonials")
        ->setCategory("Testimonials");

    $spreadsheet->setActiveSheetIndex(0);

    $spreadsheet->getActiveSheet()->setCellValue('A1', 'Author Name');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'Status');

    $row = 2;
    foreach ($testimonials as $testimonial) {
        $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $testimonial['authorName']);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $testimonial['status']);
        $row++;
    }

    while (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="testimonials.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>



<!--TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<!-- //styles -->
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-headers">
            <h2 class="header-title">Testimonials</h2>
            <div class="header-sub-title">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="card-title" style="margin-bottom:10px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start accordion -->
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="padding-top:5px; padding-bottom:5px;">
                                            <i class="fa fa-filter" style="font-size:20px;"></i> &nbsp; Filters
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                        <!-- Data Filter -->
                                        <div class="row" style="padding-top:10px;">
                                            <div class="col-md-2">
                                                <label style="color:#000000; font-size:12px;" for="fromDate">From Date</label>
                                                <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?= date("Y-m-d") ?>" placeholder="From Date" max="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label style="color:#000000; font-size:12px;" for="toDate">To Date</label>
                                                <input type="date" class="form-control" id="toDate" name="toDate" value="<?= date("Y-m-d") ?>" placeholder="To Date" max="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label style="color:#000000; font-size:12px;" for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">Show All</option>
                                                    <option value="UNPUBLISH">UNPUBLISH</option>
                                                    <option value="PUBLISH">PUBLISH</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Data Filter -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion accordion-flush" id="accordionFlushSorting">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingSorting">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSorting" aria-expanded="false" aria-controls="flush-collapseSorting" style="padding-top:5px; padding-bottom:5px;">
                                            <i class="fa fa-sort" style="font-size:20px;"></i> &nbsp; Sorting
                                        </button>
                                    </h2>
                                    <div id="flush-collapseSorting" class="accordion-collapse collapse" aria-labelledby="flush-headingSorting" data-bs-parent="#accordionFlushSorting" style="">
                                        <!-- Sorting Options -->
                                        <div class="row" style="padding-top:10px;">
                                            <div class="col-md-2">
                                                <label style="color:#000000; font-size:12px;" for="sortBy">Sort By</label>
                                                <select class="form-control" id="sortBy" name="sortBy">
                                                    <option value="tripName">Trip Name</option>
                                                    <option value="price">Price</option>
                                                    <!-- Add more sorting options as needed -->
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="color:#000000; font-size:12px;" for="sortOrder">Sort Order</label>
                                                <select class="form-control" id="sortOrder" name="sortOrder">
                                                    <option value="asc">Ascending</option>
                                                    <option value="desc">Descending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Sorting Options -->
                                    </div>
                                </div>
                            </div>

                            <!-- end accordion -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if ($displayTestimonialsAdd) : ?>
                <a href="add.php" class="btn btn-success mb-3">Add</a>
            <?php endif; ?>
            <a href="?export=excel" class="btn btn-success mb-3" id="exportExcelBtn">Export to Excel</a>
            <div class="table-responsive">
                <?php if (empty($testimonials)) : ?>
                    <h5>No data found</h5>
                <?php else : ?>
                    <table id="usersTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Author Name</th>
                                <th>Status</th>
                                <?php if ($displayTestimonialsEdit || $displayTestimonialsView || $displayTestimonialsDelete) : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($testimonials as $testimonial) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $testimonial["authorName"] ?></td>
                                    <td><?php
                                        $status = $testimonial["status"];
                                        if ($status == "PUBLISH") {
                                            echo '<span class="badge badge-success">PUBLISH</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">UNPUBLISH</span>';
                                        }
                                        ?></td>
                                    <td>
                                        <?php if ($displayTestimonialsEdit) : ?>
                                            <a href="edit.php?id=<?= $testimonial['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <?php endif; ?>
                                        <?php if ($displayTestimonialsView) : ?>
                                            <a href="view.php?id=<?= $testimonial['id'] ?>" class="btn btn-sm btn-info">View</a>
                                        <?php endif; ?>
                                        <?php if ($displayTestimonialsDelete) : ?>
                                            <a href="delete.php?id=<?= $testimonial['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable();
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
        </body>

        </html>
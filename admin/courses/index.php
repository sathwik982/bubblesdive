<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
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






$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `courses` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $courses = $result["data"];
}

?>
<!--TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>
<!-- styles -->
<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">Courses</h2>
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
            <?php if ($displayCoursesAdd) : ?>
                <a href="add.php" class="btn btn-success mb-3">Add</a>
            <?php endif; ?>
            <a href="#" class="btn btn-success mb-3" id="printBtn">Export to Excel</a>
            <div class="table-responsive">
                <?php if (empty($courses)) : ?>
                    <h5>No data found</h5>
                <?php else : ?>
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Course Type</th>
                                <th>Course Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <?php if ($displayCoursesEdit || $displayCoursesView || $displayCoursesDelete) : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($courses as $course) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $course["courseName"] ?></td>
                                    <td><?= $course["courseType"] ?></td>
                                    <td><?= $course["price"] ?></td>
                                    <td><?php
                                        $status = $course["status"];
                                        if ($status == "PUBLISH") {
                                            echo '<span class="badge badge-success">PUBLISH</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">UNPUBLISH</span>';
                                        }
                                        ?></td>
                                    <td>
                                        <?php if ($displayCoursesEdit) : ?>
                                            <a href="edit.php?courseId=<?= $course['courseId'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <?php endif; ?>
                                        <?php if ($displayCoursesView) : ?>
                                            <a href="view.php?courseId=<?= $course['courseId'] ?>" class="btn btn-sm btn-info">View</a>
                                        <?php endif; ?>
                                        <?php if ($displayCoursesDelete) : ?>
                                            <a href="delete.php?courseId=<?= $course['courseId'] ?>" class="btn btn-sm btn-danger">Delete</a>
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
                $('#dataTable').DataTable();
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#printBtn').on('click', function() {
                    if ($('#ordersTable tbody tr').length > 0) {
                        var wb = XLSX.utils.book_new();
                        var ws = XLSX.utils.table_to_sheet(document.getElementById('ordersTable'));
                        XLSX.utils.book_append_sheet(wb, ws, 'Data');
                        XLSX.writeFile(wb, 'data.xlsx');
                    } else {
                        alert('No data available to export.');
                    }
                });
            });
        </script>
        </body>

        </html>
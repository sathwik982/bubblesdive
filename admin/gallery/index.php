<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit;
}

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

include '../app/database/Connection.php';
$db = new Connection();

$userData = $_SESSION["auth"];
?>

<?php include '../layout/_assign.php';





$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `gallery` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $gallery = $result["data"];
}
?>

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>

<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <!-- <div class="page-header">
      <h2 class="header-title">Invoice</h2>
      <div class="header-sub-title">
          <nav class="breadcrumb breadcrumb-dash">
          <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
          <a class="breadcrumb-item" href="#">Pages</a>
          <span class="breadcrumb-item active">Invoice</span>
          </nav>
      </div>
      </div> -->
        <div class="page-headers">
            <h2 class="header-title">Gallery</h2>
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
            <?php if ($displayGalleryAdd) : ?>
                <a href="add.php" class="btn btn-success mb-3">Add</a>
            <?php endif; ?>
            <a href="?export=excel" class="btn btn-success mb-3" id="exportExcelBtn">Export to Excel</a>
            <div class="table-responsive">
                <?php if (empty($gallery)) : ?>
                    <h5>No data found</h5>
                <?php else : ?>
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Media Type</th>
                                <th>Media</th>
                                <th>Status</th>
                                <?php if ($displayGalleryEdit || $displayGalleryView || $displayGalleryDelete) : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($gallery as $media) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $media["mediaType"] ?></td>
                                    <td>
                                        <?php if (!empty($media["mediaUrl"])) : ?>
                                            <a href="<?= $media["mediaUrl"] ?>" target="_blank" style="text-decoration:none;">Click me</a>
                                        <?php else : ?>
                                            <span class="-">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $media["status"];
                                        if ($status == "PUBLISH") {
                                            echo '<span class="badge badge-success">PUBLISH</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">UNPUBLISH</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($displayGalleryEdit) : ?>
                                            <a href="edit.php?id=<?= $media['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <?php endif; ?>
                                        <?php if ($displayGalleryView) : ?>
                                            <a href="view.php?id=<?= $media['id'] ?>" class="btn btn-sm btn-info">View</a>
                                        <?php endif; ?>
                                        <?php if ($displayGalleryDelete) : ?>
                                            <a href="delete.php?id=<?= $media['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>
        </body>

        </html>
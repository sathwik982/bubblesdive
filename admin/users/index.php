<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
}

include '../app/database/Connection.php';
$db = new Connection();

$userData = $_SESSION["auth"];

?>

<?php include '../layout/_assign.php';





if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}


$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `users` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $users = $result["data"];
}
?>
<!--TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<!-- styles -->
<?php include '../layout/_style.header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">Users</h2>
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
            <?php if ($displayUsersRegister) : ?>
                <a href="register.php" class="btn btn-success mb-3">Register</a>
            <?php endif; ?>
            <a href="#" class="btn btn-success mb-3" id="printBtn">Export to Excel</a>
            <div class="table-responsive">
                <?php if (empty($users)) : ?>
                    <h5>No data found</h5>
                <?php else : ?>
                    <table id="usersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <?php if ($displayUsersEdit || $displayUsersView || $displayUsersDelete) : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $user["fullName"] ?></td>
                                    <td><?= $user["email"] ?></td>
                                    <td><?php
                                        $roleId = $user["roleId"];
                                        $roleSql = "SELECT * FROM `roles` WHERE `roleId` = '$roleId'";
                                        $roleResult = $db->run($roleSql);
                                        if ($roleResult["status"] == "success" && !empty($roleResult["data"])) {
                                            $role = $roleResult["data"][0];
                                            echo $role["roleName"];
                                        } else {
                                            echo "Unknown Role";
                                        }
                                        ?></td>
                                    <td><?php
                                        $status = $user["status"];
                                        if ($status == "ACTIVE") {
                                            echo '<span class="badge badge-success">ACTIVE</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">INACTIVE</span>';
                                        }
                                        ?></td>
                                    <td>
                                        <?php if ($displayUsersEdit) : ?>
                                            <a href="edit.php?userId=<?= $user['userId'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <?php endif; ?>
                                        <?php if ($displayUsersView) : ?>
                                            <a href="view.php?userId=<?= $user['userId'] ?>" class="btn btn-sm btn-info">View</a>
                                        <?php endif; ?>
                                        <?php if ($displayUsersDelete) : ?>
                                            <a href="delete.php?userId=<?= $user['userId'] ?>" class="btn btn-sm btn-danger">Delete</a>
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
        <script>
            $(document).ready(function() {
                $('#printBtn').on('click', function() {
                    if ($('#usersTable tbody tr').length > 0) {
                        var wb = XLSX.utils.book_new();
                        var ws = XLSX.utils.table_to_sheet(document.getElementById('usersTable'));
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
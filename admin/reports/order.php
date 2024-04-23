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

$sqlProductTypes = "SELECT productTypeId, productType FROM producttype";
$stmtProductTypes = $db->getConnection()->prepare($sqlProductTypes);
$stmtProductTypes->execute();
$productTypes = $stmtProductTypes->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $fromDate = htmlspecialchars($_POST['fromDate']);
    $toDate = htmlspecialchars($_POST['toDate']);
    $productTypeId = htmlspecialchars($_POST['productTypeId']);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Customer Name');
    $sheet->setCellValue('B1', 'Product Type');
    $sheet->setCellValue('C1', 'Quantity Ordered');
    $sheet->setCellValue('D1', 'Order Date');
    $sheet->setCellValue('E1', 'Total Price');
    $sheet->setCellValue('F1', 'Color');
    $sheet->setCellValue('G1', 'Size');
    $sheet->setCellValue('H1', 'Status');
    $sheet->setCellValue('I1', 'Created Date');

    $sql = "SELECT o.*, c.customerFullName, pt.productType
            FROM `orders` o
            LEFT JOIN `customers` c ON o.customerId = c.customerId
            LEFT JOIN `products` p ON o.productId = p.productId
            LEFT JOIN `producttype` pt ON p.productTypeId = pt.productTypeId
            WHERE o.createdDate BETWEEN :fromDate AND :toDate";

    if (!empty($productTypeId)) {
        $sql .= " AND pt.productTypeId = :productTypeId";
    }

    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);

    if (!empty($productTypeId)) {
        $stmt->bindValue(':productTypeId', $productTypeId);
    }

    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $row = 2;
    foreach ($orders as $order) {
        $sheet->setCellValue('A' . $row, $order['customerFullName']);
        $sheet->setCellValue('B' . $row, $order['productType']);
        $sheet->setCellValue('C' . $row, $order['quantity_ordered']);
        $sheet->setCellValue('D' . $row, $order['orderDate']);
        $sheet->setCellValue('E' . $row, $order['total_price']);
        $sheet->setCellValue('I' . $row, $order['createdDate']);

        $reportData[] = [
            'customerFullName' => $order['customerFullName'],
            'productType' => $order['productType'],
            'quantity_ordered' => $order['quantity_ordered'],
            'orderDate' => $order['orderDate'],
            'total_price' => $order['total_price'],
            'createdDate' => $order['createdDate']
        ];

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'order_report_' . date('Ymd') . '.xlsx';
    $writer->save($filename);
}

?>


<!-- TEMPLATE STARTS -->

<!-- TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>

<body>
    <div class="app">
        <div class="layout is-side-nav-dark">
            <div class="header">
                <div class="logo logo-dark ">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <a href="index.html">

                            <img src="../assets//images//logo//Bubbles.png" alt="Logo" style="width:80px">
                            <img class="logo-fold" src="../assets//images//logo//Bubbles.png" alt="Bubbles Dive Logo" style="width:40px">
                        </a>
                    </div>


                </div>
                <div class="logo logo-white">
                    <a href="index.html">
                        <img src="../assets//images//logo//Bubbles.png" alt="Logo">
                        <img class="logo-fold" src="../assets//images//logo//Bubbles.png" alt="Bubbles Dive Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav-right">

                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <!-- <img src="assets/images/avatars/thumb-3.jpg" alt=""> -->

                                    <div class="avatar avatar-icon avatar-blue">
                                        <i class="anticon anticon-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold"><?= $_SESSION["auth"]->fullName ?></p>
                                            <p class="m-b-0 opacity-07"><?= $_SESSION["auth"]->email ?></p>
                                        </div>
                                    </div>
                                </div>
                                <form action="../editprofile.php" method="POST">
                                    <input type="hidden" name="action" value="editprofile">
                                    <button type="submit" class="dropdown-item d-block p-h-15 p-v-10">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="anticon opacity-04 font-size-16 anticon-edit"></i>
                                                <span class="m-l-10">Edit Profile</span>
                                            </div>
                                            <i class="anticon font-size-10 anticon-right"></i>
                                        </div>
                                    </button>
                                </form>

                                <form action="../action/action.php" method="POST">
                                    <input type="hidden" name="action" value="logout">
                                    <button type="submit" class="dropdown-item d-block p-h-15 p-v-10">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                                <span class="m-l-10">Logout</span>
                                            </div>
                                            <i class="anticon font-size-10 anticon-right"></i>
                                        </div>
                                    </button>
                                </form>
                                <!-- <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">


                                </a> -->
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="side-nav" style="background-color:#151e29">
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">

                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="../index.php" style="text-decoration: none;">
                                <span class="icon-holder">
                                    <i class="fa-solid fa-tachometer-alt"></i>
                                </span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <?php if ($displayAbout) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../about/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-regular fa-address-card"></i>
                                    </span>
                                    <span class="title">About</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayGallery) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../gallery/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <span class="title">Gallery</span>
                                </a>

                            </li>
                        <?php endif; ?>

                        <?php if ($displaySites) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../sites/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-water"></i>
                                    </span>
                                    <span class="title">Diving Sites</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayTravel) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../trips/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-plane-departure"></i>
                                    </span>
                                    <span class=" title">Trips</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($displayBooking) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../tripbookings/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </span>
                                    <span class="title">Trip Bookings</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($displayCourses) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../courses/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-book-open"></i>
                                    </span>
                                    <span class="title">Courses</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($displayCourseBookings) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../coursebooking/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fas fa-file-signature"></i>
                                    </span>
                                    <span class="title">Course Bookings</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($displayProducts) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-shopping-bag"></i>
                                    </span>
                                    <span class="title">Products</span>
                                    <ul class="dropdown-menu">
                                        <li><a href="../producttype/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-cubes"></i></span> Product Type</a></li>

                                        <li><a href="../products/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-shopping-cart"></i></span> All Products</a></li>

                                    </ul>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($displayOrders) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../orders/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                    <span class="title">Product Orders</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayTeam) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../teams/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-users"></i>
                                    </span>

                                    <span class="title">Team Management</span>
                                </a>

                            </li>
                        <?php endif; ?>

                        <?php if ($displayContact) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../contact/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <span class="title">Enquiries</span>
                                </a>

                            </li>
                        <?php endif; ?>


                        <?php if ($displayBlog) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../articles/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </span>
                                    <span class="title">Articles</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayTC) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../terms-conditions/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-file-contract"></i>
                                    </span>
                                    <span class="title">Terms & Conditions</span>
                                </a>

                            </li>
                        <?php endif; ?>

                        <?php if ($displayFAQ) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../faq/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-question-circle"></i>
                                    </span>
                                    <span class="title">FAQ</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayCustomers) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../customers/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="title">Customers</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayTestomonials) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="../testomonials/index.php" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-comment"></i>
                                    </span>
                                    <span class="title">Testomonials</span>
                                </a>

                            </li>
                        <?php endif; ?>
                        <?php if ($displayUsers) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <span class="title">User Management</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="../roles/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-id-badge"></i></span> Roles</a></li>
                                    <li><a href="../users/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-users"></i></span> Users</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>


                        <?php if ($displayReports) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" style="text-decoration: none;">
                                    <span class="icon-holder">
                                        <i class="fas fa-file-alt"></i>
                                    </span>
                                    <span class="title">Reports</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="../reports/order.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-file-alt"></i></span> Product Order Reports</a></li>
                                    <li><a href="../reports/courses.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-file-alt"></i></span> Course Bookings Reports</a></li>
                                    <li><a href="../reports/trips.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-file-alt"></i></span> Trip Bookings Reports</a></li>
                                    <li><a href="../reports/customers.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-file-alt"></i></span> Customers Reports</a></li>

                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Page Container START -->
            <div class="page-container">
                <!-- Content Wrapper START -->
                <div class="main-content">

                    <div class="page-headers">
                        <h2 class="header-title">Product Orders</h2>
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
                                        <label for="productTypeId" class="form-label">Product Type</label>
                                        <select name="productTypeId" id="productTypeId" class="form-select">
                                            <option value="">Show All</option>
                                            <?php foreach ($productTypes as $product) : ?>
                                                <?php $selected = ($product['productTypeId'] == $productTypeId) ? 'selected' : ''; ?>
                                                <option value="<?= htmlspecialchars($product['productTypeId']) ?>" <?= $selected ?>><?= htmlspecialchars($product['productType']) ?></option>
                                            <?php endforeach; ?>
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
                                        <div class="card-body pt-xl-1">
                                            <a href="<?= $filename ?>" class="btn btn-success btn-sm" style="margin-left: 1150px;">
                                                <i class="bx bx-download"></i> Download
                                            </a>
                                            <div class="table-responsive">
                                                <table id="dataTable" class="table table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Customer Name</th>
                                                            <th>Product</th>
                                                            <th>Quantity Ordered</th>
                                                            <th>Order Date</th>
                                                            <th>Total Price</th>
                                                            <th>Created Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($reportData as $order) : ?>
                                                            <tr>
                                                                <td><?= $order['customerFullName']; ?></td>
                                                                <td><?= $order['productType']; ?></td>
                                                                <td><?= $order['quantity_ordered']; ?></td>
                                                                <td><?= $order['orderDate']; ?></td>
                                                                <td><?= $order['total_price']; ?></td>
                                                                <td><?= $order['createdDate']; ?></td>
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
                                        No Product Orders found for the selected criteria.
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
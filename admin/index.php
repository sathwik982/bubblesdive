<?php
session_start();
if (!isset($_SESSION["auth"])) {
   header('Location: login.php');
}

$userData = $_SESSION["auth"];

include './app/database/Connection.php';
$db = new Connection();

$userData = $_SESSION["auth"];

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if (empty($_SERVER['HTTP_REFERER'])) {
   echo "You don't have access to this page directly.";
   exit;
}

?>

<?php include './layout/_assign.php';

$data = array();
$orderTrend = array();
$customerTrend = array();
$courseTrend = array();
$tripTrend = array();
$daysofMonth = date('t');

$Variable1 = strtotime(date("Y-m-01"));
$Variable2 = strtotime(date("Y-m-" . $daysofMonth));

for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
   $dateFormatted = date('Y-m-d', $currentDate);
   $sql = "SELECT 
            COUNT(o.id) AS total_orders,
            COUNT(DISTINCT c.customerId) AS total_customers,
            COUNT(DISTINCT cb.bookingId) AS total_courses,
            COUNT(DISTINCT tb.bookingId) AS total_trips
        FROM 
            orders o 
        JOIN 
            customers c ON o.customerId = c.customerId 
        LEFT JOIN 
            course_bookings cb ON cb.customerId = c.customerId
        LEFT JOIN 
            trip_bookings tb ON tb.customerId = c.customerId
        WHERE 
            DATE(o.createdDate) = :dateFormatted;";
   $stmt = $db->getConnection()->prepare($sql);
   $stmt->bindParam(':dateFormatted', $dateFormatted, PDO::PARAM_STR);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
   array_push($orderTrend, $result['total_orders']);
   array_push($customerTrend, $result['total_customers']);
   array_push($courseTrend, $result['total_courses']);
   array_push($tripTrend, $result['total_trips']);
}

$data = array(
   'orderTrend' => $orderTrend,
   'customerTrend' => $customerTrend,
   'courseTrend' => $courseTrend,
   'tripTrend' => $tripTrend,
);




?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Bubbles Dive Center</title>
   <!-- Favicon -->
   <link rel="shortcut icon" href="./assets/images/logo/fav.png">
   <!-- page css -->
   <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
   <!-- Core css -->
   <link href="./assets/css/material-dashboard.min.css" rel="stylesheet" />
   <link href="./assets/css/app.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <!-- //styles -->
</head>

<body>
   <div class="app">
      <div class="layout is-side-nav-dark">
         <div class="header">
            <div class="logo logo-dark ">
               <div class="d-flex align-items-center justify-content-center h-100">
                  <a href="index.html">
                     <img src="./assets/images/logo/Bubbles.png" alt="Logo" style="width:80px">
                     <img class="logo-fold" src="./assets/images/logo/Bubbles.png" alt="Bubbles Dive Logo" style="width:40px">
                  </a>
               </div>
            </div>
            <div class="logo logo-white">
               <a href="index.html">
                  <img src="./assets/images/logo/Bubbles.png" alt="Logo">
                  <img class="logo-fold" src="./assets/images/logo/Bubbles.png" alt="Bubbles Dive Logo">
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
                        <form action="editprofile.php" method="POST">
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
                        <form action="action/action.php" method="POST">
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
                     <a class="dropdown-toggle" href="index.php" style="text-decoration: none;">
                        <span class="icon-holder">
                           <i class="fa-solid fa-tachometer-alt"></i>
                        </span>
                        <span class="title">Dashboard</span>
                     </a>
                  </li>
                  <?php if ($displayAbout) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./about/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-regular fa-address-card"></i>
                           </span>
                           <span class="title">About</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayGallery) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./gallery/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fas fa-images"></i>
                           </span>
                           <span class="title">Gallery</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displaySites) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./sites/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-water"></i>
                           </span>
                           <span class="title">Diving Sites</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayTravel) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./trips/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-plane-departure"></i>
                           </span>
                           <span class=" title">Trips</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayBooking) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./tripbookings/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-calendar-check"></i>
                           </span>
                           <span class="title">Trip Bookings</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayCourses) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./courses/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-book-open"></i>
                           </span>
                           <span class="title">Courses</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayCourseBookings) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./coursebooking/index.php" style="text-decoration: none;">
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
                              <li>
                                 <a href="./producttype/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-cubes"></i></span> Product Type</a>
                              </li>
                              <li><a href="./products/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-shopping-cart"></i></span> All Products</a></li>
                           </ul>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayOrders) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./orders/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fas fa-shopping-cart"></i>
                           </span>
                           <span class="title">Product Orders</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayTeam) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./teams/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-users"></i>
                           </span>
                           <span class="title">Team Management</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayContact) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./contact/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-envelope"></i>
                           </span>
                           <span class="title">Enquiries</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayBlog) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./articles/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-newspaper"></i>
                           </span>
                           <span class="title">Articles</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayTC) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./terms-conditions/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-file-contract"></i>
                           </span>
                           <span class="title">Terms & Conditions</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayFAQ) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./faq/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-question-circle"></i>
                           </span>
                           <span class="title">FAQ</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayCustomers) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./customers/index.php" style="text-decoration: none;">
                           <span class="icon-holder">
                              <i class="fa-solid fa-check"></i>
                           </span>
                           <span class="title">Customers</span>
                        </a>
                     </li>
                  <?php endif; ?>
                  <?php if ($displayTestomonials) : ?>
                     <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="./testomonials/index.php" style="text-decoration: none;">
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
                           <li><a href="./roles/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-id-badge"></i></span> Roles</a></li>
                           <li><a href="./users/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-users"></i></span> Users</a></li>
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
                           <li><a href="./reports/order.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-shopping-cart"></i></span> Product Order Reports</a></li>
                           <li><a href="./reports/courses.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-book"></i></span> Course Bookings Reports</a></li>
                           <li><a href="./reports/trips.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-plane"></i></span> Trip Bookings Reports</a></li>
                           <li><a href="./reports/customers.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-users"></i></span> Customers Reports</a></li>

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
               <?php include './layout/_style.header.php'; ?>
               <!-- <div class="page-headers">
         <h2 class="header-title">Invoice</h2>
         <div class="header-sub-title">
           <nav class="breadcrumb breadcrumb-dash">
             <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
             <a class="breadcrumb-item" href="#">Pages</a>
             <span class="breadcrumb-item active">Invoice</span>
           </nav>
         </div>
         </div> -->
               <div class="row">
                  <div class="col-12">
                     <div class="card bg-info">
                        <div class="card-body">
                           <div class="text-center">
                              <div class="main-wid position-relative pt-2 pb-3">
                                 <h3 class="text-dark">Bubbles Dive Center</h3>
                                 <h3 class="text-dark mb-0"> Welcome Back, <?= $_SESSION['auth']->fullName ?>!</h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php if ($displayDashboard) : ?>
                  <!-- <div class="col-md-12 mt-1">
                     <a href="#" class="btn btn-success btn-sm">
                        <i class="bx bx-download"></i> Export to Excel
                     </a>
                  </div> -->
                  <div class="row">
                     <div class="col-sm-12 mt-0">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="card">
                                 <div class="card-body bg-info">
                                    <div class="row">
                                       <div class="col mt-0">
                                          <span class="card-title">Sales</span>
                                       </div>
                                       <div class="col-auto">
                                          <div class="stat text-primary">

                                             <svg fill="#000000" width="40" height="40" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M136.948 908.811c5.657 0 10.24-4.583 10.24-10.24V610.755c0-5.657-4.583-10.24-10.24-10.24h-81.92a10.238 10.238 0 00-10.24 10.24v287.816c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V610.755c0-28.278 22.922-51.2 51.2-51.2h81.92c28.278 0 51.2 22.922 51.2 51.2v287.816c0 28.278-22.922 51.2-51.2 51.2zm278.414-40.96c5.657 0 10.24-4.583 10.24-10.24V551.322c0-5.657-4.583-10.24-10.24-10.24h-81.92a10.238 10.238 0 00-10.24 10.24v347.249c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V551.322c0-28.278 22.922-51.2 51.2-51.2h81.92c28.278 0 51.2 22.922 51.2 51.2v347.249c0 28.278-22.922 51.2-51.2 51.2zm278.414-40.342c5.657 0 10.24-4.583 10.24-10.24V492.497c0-5.651-4.588-10.24-10.24-10.24h-81.92c-5.652 0-10.24 4.589-10.24 10.24v406.692c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V492.497c0-28.271 22.924-51.2 51.2-51.2h81.92c28.276 0 51.2 22.929 51.2 51.2v406.692c0 28.278-22.922 51.2-51.2 51.2zm278.414-40.958c5.657 0 10.24-4.583 10.24-10.24V441.299c0-5.657-4.583-10.24-10.24-10.24h-81.92a10.238 10.238 0 00-10.24 10.24v457.892c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V441.299c0-28.278 22.922-51.2 51.2-51.2h81.92c28.278 0 51.2 22.922 51.2 51.2v457.892c0 28.278-22.922 51.2-51.2 51.2zm-6.205-841.902C677.379 271.088 355.268 367.011 19.245 387.336c-11.29.683-19.889 10.389-19.206 21.679s10.389 19.889 21.679 19.206c342.256-20.702 670.39-118.419 964.372-284.046 9.854-5.552 13.342-18.041 7.79-27.896s-18.041-13.342-27.896-7.79z" />
                                                <path d="M901.21 112.64l102.39.154c11.311.017 20.494-9.138 20.511-20.449s-9.138-20.494-20.449-20.511l-102.39-.154c-11.311-.017-20.494 9.138-20.511 20.449s9.138 20.494 20.449 20.511z" />
                                                <path d="M983.151 92.251l-.307 101.827c-.034 11.311 9.107 20.508 20.418 20.542s20.508-9.107 20.542-20.418l.307-101.827c.034-11.311-9.107-20.508-20.418-20.542s-20.508 9.107-20.542 20.418z" />
                                             </svg>
                                          </div>
                                       </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">2.382</h1>
                                    <div class="mb-0">
                                       <span class="card-title">Since last week</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="card">
                                 <div class="card-body bg-info">
                                    <div class="row">
                                       <div class="col mt-0">
                                          <span class="card-title">Visitors</span>
                                       </div>
                                       <div class="col-auto">
                                          <div class="stat text-primary">
                                             <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 54.104 54.104" xml:space="preserve">
                                                <g>
                                                   <path d="M0,12.36v29.384c0,1.657,1.343,3,3,3h48.104c1.656,0,3-1.343,3-3V12.36c0-1.657-1.344-3-3-3H3C1.343,9.36,0,10.703,0,12.36
                                    z M20.332,35.108h-10.5c-1.657,0-3-1.343-3-3V21.021c0-1.657,1.343-3,3-3h10.5c1.657,0,3,1.343,3,3v11.087
                                    C23.332,33.765,21.989,35.108,20.332,35.108z M48.582,32.538H28.95c-0.829,0-1.5-0.673-1.5-1.5c0-0.828,0.671-1.5,1.5-1.5h19.632
                                    c0.829,0,1.5,0.672,1.5,1.5C50.082,31.865,49.411,32.538,48.582,32.538z M48.582,23.858H28.95c-0.829,0-1.5-0.672-1.5-1.5
                                    s0.671-1.5,1.5-1.5h19.632c0.829,0,1.5,0.672,1.5,1.5S49.411,23.858,48.582,23.858z" />
                                                </g>
                                             </svg>
                                          </div>
                                       </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">14.212</h1>
                                    <div class="mb-0">
                                       <span class="card-title">Since last week</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12" style="width: 100%;">
                        <div class="row">
                           <div class="col-md-3">
                              <div class="card">
                                 <a href="../admin/orders/index.php" style="text-decoration:none;">
                                    <div class="card-body bg-info">
                                       <div class="row">
                                          <div class="col mt-0">
                                             <span class="card-title">Product Orders</span>
                                          </div>
                                          <div class="col-auto">
                                             <div class="stat text-primary">
                                                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 100 100" xml:space="preserve">
                                                   <g>
                                                      <g>
                                                         <path d="M78.8,62.1l-3.6-1.7c-0.5-0.3-1.2-0.3-1.7,0L52,70.6c-1.2,0.6-2.7,0.6-3.9,0L26.5,60.4
                                             c-0.5-0.3-1.2-0.3-1.7,0l-3.6,1.7c-1.6,0.8-1.6,2.9,0,3.7L48,78.5c1.2,0.6,2.7,0.6,3.9,0l26.8-12.7C80.4,65,80.4,62.8,78.8,62.1z" />
                                                      </g>
                                                      <g>
                                                         <path d="M78.8,48.1l-3.7-1.7c-0.5-0.3-1.2-0.3-1.7,0L52,56.6c-1.2,0.6-2.7,0.6-3.9,0L26.6,46.4
                                             c-0.5-0.3-1.2-0.3-1.7,0l-3.7,1.7c-1.6,0.8-1.6,2.9,0,3.7L48,64.6c1.2,0.6,2.7,0.6,3.9,0l26.8-12.7C80.4,51.1,80.4,48.9,78.8,48.1
                                             z" />
                                                      </g>
                                                      <g>
                                                         <path d="M21.2,37.8l26.8,12.7c1.2,0.6,2.7,0.6,3.9,0l26.8-12.7c1.6-0.8,1.6-2.9,0-3.7L51.9,21.4
                                             c-1.2-0.6-2.7-0.6-3.9,0L21.2,34.2C19.6,34.9,19.6,37.1,21.2,37.8z" />
                                                      </g>
                                                   </g>
                                                </svg>
                                             </div>
                                          </div>
                                       </div>
                                       <?php
                                       $sql = "SELECT COUNT(*) AS orderCount, MIN(createdDate) AS minDate FROM `orders`";
                                       $stmt = $db->getConnection()->prepare($sql);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                       $ordersCount = $result['orderCount'] ?? 0;
                                       $minDate = $result['minDate'] ?? '';

                                       echo '<h1 class="mt-1 mb-3">' . $ordersCount . '</h1>';

                                       if (!empty($minDate)) {
                                          $sinceDate = date('M d, Y', strtotime($minDate));
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                          echo '</div>';
                                       } else {
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">No order records available.</span>';
                                          echo '</div>';
                                       }
                                       ?>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card">
                                 <a href="../admin/coursebooking/index.php" style="text-decoration:none;">
                                    <div class="card-body bg-info">
                                       <div class="row">
                                          <div class="col mt-0">
                                             <span class="card-title">Course Bookings</span>
                                          </div>
                                          <div class="col-auto">
                                             <div class="stat text-primary">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M12.0002 1.25C12.4144 1.25 12.7502 1.58579 12.7502 2V3.03647L17.7579 5.54032L17.8119 5.56731C18.5464 5.93447 19.1724 6.24743 19.608 6.55149C20.0498 6.85982 20.5142 7.3075 20.5142 8C20.5142 8.6925 20.0498 9.14018 19.608 9.44851C19.1724 9.75257 18.5464 10.0655 17.8119 10.4327L12.7502 12.9635V18C12.7502 18.4142 12.4144 18.75 12.0002 18.75C11.586 18.75 11.2502 18.4142 11.2502 18V12.5162C11.2499 12.5058 11.2499 12.4953 11.2502 12.4849V3.51509C11.2499 3.50466 11.2499 3.49421 11.2502 3.48375V2C11.2502 1.58579 11.586 1.25 12.0002 1.25Z" fill="#1C274C" />
                                                   <path d="M12 22C17.5228 22 22 20.433 22 18.5C22 16.8378 18.6894 15.4462 14.2502 15.089V18C14.2502 19.2426 13.2428 20.25 12.0002 20.25C10.7575 20.25 9.75016 19.2426 9.75016 18V15.0889C5.31073 15.4462 2 16.8378 2 18.5C2 20.433 6.47715 22 12 22Z" fill="#1C274C" />
                                                   <path d="M12.0002 1.25C11.586 1.25 11.2502 1.58579 11.2502 2V3.48375C11.2499 3.49421 11.2499 3.50466 11.2502 3.51509V12.4849C11.2499 12.4953 11.2499 12.5058 11.2502 12.5162V15.0097V18C11.2502 18.4142 11.586 18.75 12.0002 18.75C12.4144 18.75 12.7502 18.4142 12.7502 18V15.0097V12.9635L17.8119 10.4327C18.5464 10.0655 19.1724 9.75257 19.608 9.44851C20.0498 9.14018 20.5142 8.6925 20.5142 8C20.5142 7.3075 20.0498 6.85982 19.608 6.55149C19.1724 6.24743 18.5464 5.93447 17.8119 5.56731L12.7502 3.03647V2C12.7502 1.58579 12.4144 1.25 12.0002 1.25Z" fill="#1C274C" />
                                                </svg>
                                             </div>
                                          </div>
                                       </div>
                                       <?php
                                       $sql = "SELECT COUNT(*) AS orderCount, MIN(createdDate) AS minDate FROM `course_bookings`";
                                       $stmt = $db->getConnection()->prepare($sql);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                       $ordersCount = $result['orderCount'] ?? 0;
                                       $minDate = $result['minDate'] ?? '';

                                       echo '<h1 class="mt-1 mb-3">' . $ordersCount . '</h1>';

                                       if (!empty($minDate)) {
                                          $sinceDate = date('M d, Y', strtotime($minDate));
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                          echo '</div>';
                                       } else {
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">No order records available.</span>';
                                          echo '</div>';
                                       }
                                       ?>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card">
                                 <a href="../admin/tripbookings/index.php" style="text-decoration:none;">
                                    <div class="card-body bg-info">
                                       <div class="row">
                                          <div class="col mt-0">
                                             <span class="card-title">Trip Bookings</span>
                                          </div>
                                          <div class="col-auto">
                                             <div class="stat text-primary">
                                                <svg fill="#000000" width="40" height="40" viewBox="0 0 50 50" version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" overflow="inherit">
                                                   <path d="M21.493 8.001l-.542.97c-.354.718-1.086 1.029-1.923 1.029h-1.274c.731 1 1.901 1.819 3.257 1.819 2.218 0 3.989-1.676 3.989-3.888v.069h-3.318c-.083 0-.166-.082-.189.001zm-2.465.999c.437 0 .825-.152 1.003-.528l.53-.948c.201-.435.626-.524 1.121-.524h4.153c-.543-2-2.489-3.848-4.791-3.848-2.725 0-4.931 2.018-4.931 4.748 0 .436.047 1.1.165 1.1h2.75zm13.656 22c3.699 0 13.361-1.133 16.021-3.676-1.197-3.676-5.916-3.97-10.246-2.098-.744.322-1.734.56-2.867.772l-.885-3.426c.707-.365 1.174-1.113 1.131-1.954-.045-1.148-1.008-2.045-2.156-1.998l-.65-2.509c.639-.482.975-1.295.785-2.124-.26-1.124-1.375-1.836-2.502-1.583 0 0-9.161.082-12.034.853-2.867.771-3.834 5.589-3.834 5.589l-2.519 8.154h-11.928v4h31.684zm-8.235-14.196l7.108-.293.566 2.177c-1.922.094-5.338.271-8.388.441l.714-2.325zm-1.982 6.496l10.724-.482.891 3.413c-4.377.629-10.052.719-12.736.73l1.121-3.661zm20.039 12.309s6.494-.082 6.494-6.42c0-.254-.025-.445-.047-.68-4.053 2.929-14.883 3.491-16.252 3.491h-31.701v4.904c.767 0 1.558-.178 2.253-.482 1.145-.529 2.419-.812 3.67-.812 1.25 0 2.513.283 3.633.801.743.33 1.51.494 2.289.494.791 0 1.557-.164 2.265-.482 1.156-.529 2.418-.812 3.669-.812 1.262 0 2.501.271 3.646.801.719.33 1.509.494 2.289.494.778 0 1.545-.164 2.264-.482 1.145-.529 2.42-.812 3.658-.812 1.273 0 2.502.271 3.645.801.732.33 1.521.494 2.289.494l.277-.012.945 3.623c-.408.07-.814.119-1.234.119-1.037 0-2.041-.225-2.926-.625-.908-.424-1.934-.67-3.008-.67-1.072 0-2.1.246-3.008.67-.885.4-1.877.625-2.915.625s-2.041-.225-2.926-.625c-.908-.424-1.934-.67-3.008-.67s-2.1.246-3.008.67c-.885.4-1.876.625-2.914.625-1.026 0-2.029-.225-2.914-.625-.909-.424-1.935-.67-3.008-.67-1.062 0-2.089.246-2.997.67-.896.398-1.888.623-2.926.623v4.365c1.038 0 2.03-.223 2.926-.623.908-.424 1.935-.672 2.997-.672 1.073 0 2.099.248 3.008.672.885.4 1.888.623 2.914.623 1.038 0 2.029-.223 2.914-.623.908-.424 1.935-.672 3.008-.672 1.075 0 2.1.248 3.008.672.885.4 1.888.623 2.926.623s2.03-.223 2.915-.623c.908-.424 1.936-.672 3.008-.672 1.074 0 2.1.248 3.008.672.885.4 1.889.623 2.926.623 1.025 0 2.031-.223 2.914-.623.91-.424 1.936-.672 3.01-.672 1.072 0 1.892.248 2.8.672.885.4 1.718.623 2.718.623v-4.365c-1 0-1.833-.225-2.718-.625-.908-.424-1.831-.67-2.903-.67-1.074 0-2.048.246-2.958.67l-.188.082-.895-3.482.49-.188c1.146-.529 2.428-.813 3.678-.813z" />
                                                </svg>
                                             </div>
                                          </div>
                                       </div>
                                       <?php
                                       $sql = "SELECT COUNT(*) AS orderCount, MIN(createdDate) AS minDate FROM `trip_bookings`";
                                       $stmt = $db->getConnection()->prepare($sql);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                       $ordersCount = $result['orderCount'] ?? 0;
                                       $minDate = $result['minDate'] ?? '';

                                       echo '<h1 class="mt-1 mb-3">' . $ordersCount . '</h1>';

                                       if (!empty($minDate)) {
                                          $sinceDate = date('M d, Y', strtotime($minDate));
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                          echo '</div>';
                                       } else {
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">No order records available.</span>';
                                          echo '</div>';
                                       }
                                       ?>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card">
                                 <a href="../admin/customers/index.php" style="text-decoration:none;">
                                    <div class="card-body bg-info">
                                       <div class="row">
                                          <div class="col mt-0">
                                             <span class="card-title">Total Customers</span>
                                          </div>
                                          <div class="col-auto">
                                             <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                <ellipse cx="41.3" cy="42.3" rx="12.2" ry="13.5" />
                                                <path d="M52.6,57.4c-3.1,2.8-7,4.5-11.3,4.5c-4.3,0-8.3-1.7-11.3-4.6c-5.5,2.5-11,5.7-11,10.7v2.1
                                    c0,2.5,2,4.5,4.5,4.5h35.7c2.5,0,4.5-2,4.5-4.5v-2.1C63.6,63,58.2,59.9,52.6,57.4z" />
                                                <path d="M68,47.4c-0.2-0.1-0.3-0.2-0.5-0.3c-0.4-0.2-0.9-0.2-1.3,0.1c-2.1,1.3-4.6,2.1-7.2,2.1c-0.3,0-0.7,0-1,0
                                    c-0.5,1.3-1,2.6-1.7,3.7c0.4,0.2,0.9,0.3,1.4,0.6c5.7,2.5,9.7,5.6,12.5,9.8H75c2.2,0,4-1.8,4-4v-1.9C79,52.6,73.3,49.6,68,47.4z" />
                                                <path d="M66.9,34.2c0-4.9-3.6-8.9-7.9-8.9c-2.2,0-4.1,1-5.6,2.5c3.5,3.6,5.7,8.7,5.7,14.4c0,0.3,0,0.5,0,0.8
                                    C63.4,43,66.9,39.1,66.9,34.2z" />
                                             </svg>
                                          </div>
                                       </div>
                                       <?php
                                       $sql = "SELECT COUNT(*) AS customerCount, MIN(createdDate) AS minDate FROM customers";
                                       $stmt = $db->getConnection()->prepare($sql);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                       $customerCount = $result['customerCount'];
                                       $createdDate = $result['minDate'];

                                       echo '<h1 class="mt-1 mb-3">' . ($customerCount) . '</h1>';
                                       if (!empty($createdDate)) {
                                          $sinceDate = date('M d, Y', strtotime($createdDate));
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                          echo '</div>';
                                       } else {
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">No customer records available.</span>';
                                          echo '</div>';
                                       }
                                       ?>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card">
                                 <a href="../admin/users/index.php" style="text-decoration:none;">
                                    <div class="card-body bg-info">
                                       <div class="row">
                                          <div class="col mt-0">
                                             <span class="card-title">Total Users</span>
                                          </div>
                                          <div class="col-auto">
                                             <svg fill="#000000" height="40" width="40" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                                <g>
                                                   <g>
                                                      <path d="M363.09,19.342H147.772c-21.288,0-38.546,17.258-38.546,38.546v88.885c0,3.141,2.547,5.689,5.689,5.689h281.031
                                          c3.141,0,5.689-2.547,5.689-5.689V57.888C401.636,36.6,384.378,19.342,363.09,19.342z" />
                                                   </g>
                                                </g>
                                                <g>
                                                   <g>
                                                      <path d="M494.933,252.587c-4.128,0-178.414,0-182.076,0l-4.078-20.48h54.311c21.288,0,38.546-17.258,38.546-38.546v-1.277
                                          c0-3.141-2.548-5.689-5.689-5.689H114.916c-3.141,0-5.689,2.547-5.689,5.689v1.277c0,21.288,17.258,38.546,38.546,38.546h55.448
                                          l-4.078,20.48c-3.662,0-177.948,0-182.076,0C7.641,252.587,0,260.228,0,269.653s7.641,17.067,17.067,17.067h31.858
                                          c0,7.009,0,175.316,0,188.871c0,9.425,7.641,17.067,17.067,17.067s17.067-7.641,17.067-17.067V359.538h345.884v116.053
                                          c0,9.425,7.641,17.067,17.067,17.067s17.067-7.641,17.067-17.067c0-13.793,0-182.066,0-188.871h31.858
                                          c9.425,0,17.067-7.641,17.067-17.067S504.359,252.587,494.933,252.587z" />
                                                   </g>
                                                </g>
                                             </svg>
                                          </div>
                                       </div>
                                       <?php
                                       $sql = "SELECT COUNT(*) AS customerCount, MIN(createdDate) AS minDate FROM users";
                                       $stmt = $db->getConnection()->prepare($sql);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                       $userCount = $result['customerCount'];
                                       $createdDate = $result['minDate'];

                                       echo '<h1 class="mt-1 mb-3">' . ($userCount) . '</h1>';
                                       if (!empty($createdDate)) {
                                          $sinceDate = date('M d, Y', strtotime($createdDate));
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                          echo '</div>';
                                       } else {
                                          echo '<div class="mb-0">';
                                          echo '<span class="card-title">No user records available.</span>';
                                          echo '</div>';
                                       }
                                       ?>
                                    </div>
                                 </a>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-body bg-info">
                                    <div class="row">
                                       <div class="col mt-0">
                                          <span class="card-title">Total Earnings</span>
                                       </div>
                                       <div class="col-auto">
                                          <div class="stat text-primary">
                                             <svg fill="#000000" width="40" height="40" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg">
                                                <path d="M16.41 7.675v7.047a.476.476 0 0 1-.475.475H1.095a.476.476 0 0 1-.476-.475V7.675a.476.476 0 0 1 .475-.475h14.84a.476.476 0 0 1 .476.475zM11.803 11.2a3.181 3.181 0 1 0-.25 1.242 3.173 3.173 0 0 0 .25-1.242zm-1.976.116a1.094 1.094 0 0 1 .27.719 1.07 1.07 0 0 1-.537.924 1.725 1.725 0 0 1-.551.227v.365a.396.396 0 1 1-.792 0v-.36a1.867 1.867 0 0 1-.363-.112 1.219 1.219 0 0 1-.468-.344.396.396 0 1 1 .598-.518.44.44 0 0 0 .164.126 1.132 1.132 0 0 0 .216.07 1.692 1.692 0 0 0 .234.028 1.027 1.027 0 0 0 .532-.147c.176-.114.176-.212.176-.26a.307.307 0 0 0-.075-.197.681.681 0 0 0-.178-.143.904.904 0 0 0-.22-.079 1.029 1.029 0 0 0-.215-.021 2.128 2.128 0 0 1-.354-.029 1.62 1.62 0 0 1-.456-.147 1.317 1.317 0 0 1-.433-.347 1.116 1.116 0 0 1-.257-.7 1.13 1.13 0 0 1 .562-.955 1.714 1.714 0 0 1 .537-.216v-.352a.396.396 0 0 1 .792 0v.363a1.938 1.938 0 0 1 .37.127 1.408 1.408 0 0 1 .411.283.396.396 0 0 1-.559.56.612.612 0 0 0-.177-.121 1.165 1.165 0 0 0-.223-.078l-.023-.005a1.125 1.125 0 0 0-.184-.031 1.028 1.028 0 0 0-.52.14.345.345 0 0 0-.194.285.338.338 0 0 0 .08.2.54.54 0 0 0 .172.14.847.847 0 0 0 .232.074 1.338 1.338 0 0 0 .224.017 1.824 1.824 0 0 1 .384.04 1.696 1.696 0 0 1 .42.152 1.46 1.46 0 0 1 .405.322z" />
                                             </svg>
                                          </div>
                                       </div>
                                    </div>
                                    <?php
                                    $sql = "SELECT 
                                          (SELECT SUM(total_price) FROM orders) +
                                          (SELECT SUM(total_price) FROM course_bookings) +
                                          (SELECT SUM(total_price) FROM trip_bookings) AS total_price,
                                          (SELECT MIN(orderDate) FROM orders) AS minDate;
                                       ";
                                    $stmt = $db->getConnection()->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $totalPrice = $result['total_price'];
                                    $minDate = $result['minDate'] ?? '';

                                    echo '<h1 class="mt-1 mb-3">KWD ' . number_format($totalPrice, 2) . '</h1>';

                                    if (!empty($minDate)) {
                                       $sinceDate = date('M d, Y', strtotime($minDate));
                                       echo '<div class="mb-0">';
                                       echo '<span class="card-title">Since ' . $sinceDate . '</span>';
                                       echo '</div>';
                                    } else {
                                       echo '<div class="mb-0">';
                                       echo '<span class="card-title">No Earnings.</span>';
                                       echo '</div>';
                                    }
                                    ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>



                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="d-flex flex-wrap align-items-center mb-3">
                                 <h5 class="card-title mb-0">Statistics</h5>
                              </div>
                              <div class="row align-items-center">
                                 <div class="col-xl-12">
                                    <div class="chart-container">
                                       <div id="sales-statistics" class="apex-chart"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
               <!-- Footer START -->
               <?php include './layout/_footer.php'; ?>
               <!-- Core Vendors JS -->
               <script src="./assets/js/vendors.min.js"></script>
               <!-- page js -->
               <!-- Core JS -->
               <script src="./assets/js/app.min.js"></script>
               <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>
               <!-- scripts -->
               <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
               <script>
                  var alterationsTrendData = {
                     chart: {
                        height: 435,
                        type: 'area',
                        zoom: {
                           enabled: true
                        },
                        toolbar: {
                           show: true,
                        }
                     },
                     dataLabels: {
                        enabled: true
                     },
                     stroke: {
                        curve: 'smooth'
                     },
                     series: [{
                           name: "Total Product Orders",
                           data: <?= json_encode($data["orderTrend"]) ?>
                        },
                        {
                           name: "Total Customers",
                           data: <?= json_encode($data["customerTrend"]) ?>
                        },
                        {
                           name: "Total Course Bookings",
                           data: <?= json_encode($data["courseTrend"]) ?>
                        },
                        {
                           name: "Total Trip Bookings",
                           data: <?= json_encode($data["tripTrend"]) ?>
                        }
                     ],
                     grid: {
                        row: {
                           colors: ['#f1f2f3', 'transparent'],
                           opacity: 0.5
                        },
                     },
                  }

                  var alterationsTrendGraph = new ApexCharts(document.querySelector("#sales-statistics"), alterationsTrendData);
                  alterationsTrendGraph.render();
               </script>
               <!-- JavaScript for AJAX and Calendar -->
</body>

</html>
<?php
session_start();

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit;
}

include './app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

$userData = $_SESSION["auth"];

?>

<?php include './layout/_assign.php';






$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['fullName'], $_POST['email'])) {
        $fullName = trim($_POST['fullName']);
        $email = trim($_POST['email']);



        if (empty($fullName) || empty($email)) {
            $error_message = "Full Name or Email Address is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format. Please enter a valid email address.";
        } elseif (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirmPassword']) {
            $error_message = "New Passwords do not match. Please try again.";
        } else {
            $userId = $_SESSION['auth']->userId;

            $params = [];
            $updateFields = '';

            if (!empty($fullName)) {
                $params[] = $fullName;
                $updateFields .= "fullName = ?, ";
            }

            if (!empty($email)) {
                $params[] = $email;
                $updateFields .= "email = ?, ";
            }

            if (!empty($_POST['password'])) {
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $params[] = $hashedPassword;
                $updateFields .= "password = ?, ";
            }

            $params[] = $userId;

            if (empty($error_message)) {
                $updateFields = rtrim($updateFields, ", ");
                $sql = "UPDATE `users` SET $updateFields WHERE userId = ?";
                $result = $db->run($sql, $params);

                if ($result["status"] == "success") {
                    $success_message = "Profile updated successfully!";
                    echo '<script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 1000); 
                </script>';
                } else {
                    $error_message = "Failed to update profile. Please try again.";
                }
            }
        }
    }
}

$userId = $_SESSION['auth']->userId;
$sqlGetProfile = "SELECT fullName, email FROM `users` WHERE userId = ?";
$resultProfile = $db->run($sqlGetProfile, [$userId]);

if ($resultProfile["status"] == "success" && !empty($resultProfile["data"])) {
    $profileData = $resultProfile["data"][0];
    $fullName = isset($profileData['fullName']) ? $profileData['fullName'] : '';
    $email = isset($profileData['email']) ? $profileData['email'] : '';
} else {
    $error_message = "Failed to fetch profile data. Please try again.";
}
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

<body>
    <div class="app">
        <div class="layout is-side-nav-dark">
            <div class="header">
                <div class="logo logo-dark ">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <a href="index.html">

                            <img src="./assets//images//logo//Bubbles.png" alt="Logo" style="width:80px">
                            <img class="logo-fold" src="./assets//images//logo//Bubbles.png" alt="Bubbles Dive Logo" style="width:40px">
                        </a>
                    </div>


                </div>
                <div class="logo logo-white">
                    <a href="index.html">
                        <img src="./assets//images//logo//Bubbles.png" alt="Logo">
                        <img class="logo-fold" src="./assets//images//logo//Bubbles.png" alt="Bubbles Dive Logo">
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
                                <form action="../admin/editprofile.php" method="POST">
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

                                <form action="./action/action.php" method="POST">
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
                                <a class="dropdown-toggle" href="./gallery/gallery.php" style="text-decoration: none;">
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
                                        <li><a href="./producttype/index.php" style="text-decoration: none;"><span class="icon-holder"><i class="fa-solid fa-cubes"></i></span> Product Type</a></li>

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
                                    <li><a href="./reports/order.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-file-alt"></i></span> Product Order Reports</a></li>

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
                        <h2 class="header-title">Edit Profile</h2>
                        <div class="header-sub-title"></div>
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
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" name="fullName" id="fullName" value="<?= $fullName ?>" placeholder="Full Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" placeholder="Email Address" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                                            </div>
                                            <button type="submit" class="btn btn-success">Update Profile</button>
                                            <a href="index.php" class="btn btn-danger">Back</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <script>
                        $(document).ready(function() {
                            <?php if (!empty($error_message) || !empty($success_message)) : ?>
                                $('#messageModal').modal('show');
                            <?php endif; ?>
                        });
                    </script>
</body>

</html>
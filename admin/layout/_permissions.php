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
                                    <li><a href="../reports/order.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-shopping-cart"></i></span> Product Order Reports</a></li>
                                    <li><a href="../reports/courses.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-book"></i></span> Course Bookings Reports</a></li>
                                    <li><a href="../reports/trips.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-plane"></i></span> Trip Bookings Reports</a></li>
                                    <li><a href="../reports/customers.php" style="text-decoration: none;"><span class="icon-holder"><i class="fas fa-users"></i></span> Customers Reports</a></li>

                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
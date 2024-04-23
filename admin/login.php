<?php
session_start();
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
</head>


<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('/assets/images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h2 class="text-center m-b-20">Log In</h2>
                                    <div class="d-flex align-items-center justify-content-center m-b-30">
                                        <img class="img-fluid" alt="" src="./assets/images/logo/Bubbles.png" style="width: 200px;">
                                    </div>
                                    <?php
                                    if (isset($_SESSION['loginerror'])) : ?>
                                        <div class="alert alert-danger">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <span class="alert-icon">
                                                    <i class="anticon anticon-close-o"></i>
                                                </span>
                                                <span><?= $_SESSION['loginerror'] ?></span>
                                            </div>
                                        </div>
                                    <?php
                                        unset($_SESSION['loginerror']);
                                    endif
                                    ?>
                                    <form action="./action/action.php" method="POST">
                                        <input type="hidden" name="action" value="login">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="email">Email Address:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter the Email Address">
                                            </div>
                                        </div>

                                        <div class="form-group" style="position: relative;">
                                            <label class="font-weight-semibold" for="password">Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter the Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="togglePassword">
                                                        <i class="eye-icon anticon anticon-eye" onclick="togglePasswordVisibility()"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info" style="width: 100%;">Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core Vendors JS -->
    <script src="./assets/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="./assets/js/app.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>

</body>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.querySelector('.eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('anticon-eye');
            eyeIcon.classList.add('anticon-eye-invisible');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('anticon-eye-invisible');
            eyeIcon.classList.add('anticon-eye');
        }
    }
</script>


</html>
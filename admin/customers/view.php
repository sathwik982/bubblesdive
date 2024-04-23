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

<?php include '../layout/_assign.php';






if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

$userData = $_SESSION["auth"];

$error_message = '';
$success_message = '';

if (isset($_GET['customerId'])) {
    $customerId = intval($_GET['customerId']);

    $sql = "SELECT * FROM `customers` WHERE customerId = ?";
    $params = [$customerId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $customers = $result["data"][0];

        $customerFullName = htmlspecialchars($customers['customerFullName']);
        $customerMobileNumber = htmlspecialchars($customers['customerMobileNumber']);
        $address = htmlspecialchars($customers['address']);
        $customerEmailAddress = htmlspecialchars($customers['customerEmailAddress']);
        $customerStatus = htmlspecialchars($customers['customerStatus']);
    } else {
        $error_message = "Record not found.";
    }
}

?>

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

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

        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="customerId" value="<?php echo isset($_GET['customerId']) ? $_GET['customerId'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="customerFullName" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="customerFullName" id="customerFullName" value="<?= $customerFullName ?? '' ?>" placeholder="Customer Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerEmailAddress" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="customerEmailAddress" id="customerEmailAddress" value="<?= $customerEmailAddress ?? '' ?>" placeholder="Email Address" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerMobileNumber" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="customerMobileNumber" id="customerMobileNumber" value="<?= $customerMobileNumber ?? '' ?>" placeholder="Mobile Number" readonly>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="address">Address</label>
                                    <textarea class="form-control z-depth-1" id="address" name="address" rows="5" placeholder="Address" readonly><?= $address ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="customerStatus" class="form-label">Customer Status</label><br>
                                    <input type="text" class="form-control" name="customerStatus" id="customerStatus" value="<?= $customerStatus ?? '' ?>" placeholder="Customer Status" readonly>
                                </div>
                                <a href="index.php" class="btn btn-success">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        <!-- Add your scripts here -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
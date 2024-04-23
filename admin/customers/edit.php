<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}



include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

$userData = $_SESSION["auth"];

if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}


?>

<?php include '../layout/_assign.php';





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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerId = intval($_POST['customerId']);
    $customerFullName = htmlspecialchars($_POST['customerFullName']);
    $customerMobileNumber = htmlspecialchars($_POST['customerMobileNumber']);
    $address = htmlspecialchars($_POST['address']);
    $customerEmailAddress = htmlspecialchars($_POST['customerEmailAddress']);
    $customerStatus = htmlspecialchars($_POST['customerStatus']);

    $sql_check_changes = "SELECT * FROM `customers` WHERE customerId = ?";
    $params_check_changes = [$customerId];
    $result_check_changes = $db->run($sql_check_changes, $params_check_changes);

    if ($result_check_changes["status"] == "success" && !empty($result_check_changes["data"])) {
        $existing_customer = $result_check_changes["data"][0];

        $sql = "UPDATE `customers` SET customerFullName = ?, customerMobileNumber = ?, customerEmailAddress = ?, address = ?, customerStatus = ? WHERE customerId = ?";
        $params = [$customerFullName, $customerMobileNumber, $customerEmailAddress, $address, $customerStatus, $customerId];
        $update_result = $db->run($sql, $params);

        if ($update_result["status"] == "success") {
            $success_message = "Record has been updated successfully!";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1000);
            </script>';
        } else {
            $error_message = "Failed to update record details. Please try again.";
        }
    } else {
        $error_message = "Error fetching existing data.";
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
            <h2 class="header-title">Update Record</h2>
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
                                    <input type="text" class="form-control" name="customerFullName" id="customerFullName" value="<?= $customerFullName ?? '' ?>" placeholder="customer Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerEmailAddress" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="customerEmailAddress" id="customerEmailAddress" value="<?= $customerEmailAddress ?? '' ?>" placeholder="Email Address" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="customerMobileNumber" class="form-label">Mobile Number</label>
                                    <input type="number" class="form-control" name="customerMobileNumber" id="customerMobileNumber" value="<?= $customerMobileNumber ?? '' ?>" placeholder="Mobile Number" readonly>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="address">Address</label>
                                    <textarea class="form-control z-depth-1" id="address" name="address" rows="5" placeholder="Write Something here" readonly><?= $address ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="customerStatus" class="form-label">Customer Status</label><br>
                                    <select class="form-control" name="customerStatus">
                                        <option value="" <?= !isset($customerStatus) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="ACTIVE" <?= (isset($customerStatus) && $customerStatus == 'ACTIVE') ? 'selected' : '' ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?= (isset($customerStatus) && $customerStatus == 'INACTIVE') ? 'selected' : '' ?>>INACTIVE</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="index.php" class="btn btn-danger">Cancel</a>
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
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>
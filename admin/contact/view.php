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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `contactform` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $contact = $result["data"][0];

        $name = htmlspecialchars($contact['name']);
        $mobileNumber = htmlspecialchars($contact['mobileNumber']);
        $email = htmlspecialchars($contact['email']);
        $message = htmlspecialchars($contact['message']);
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
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">User Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?= $name ?? '' ?>" placeholder="User Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                                    <input type="number" class="form-control" name="mobileNumber" id="mobileNumber" value="<?= $mobileNumber ?? '' ?>" placeholder="Mobile Number" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?= $email ?? '' ?>" placeholder="Email Address" readonly>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="message">Message</label>
                                    <textarea class="form-control z-depth-1" id="message" name="message" rows="5" placeholder="Message" readonly><?= $message ?? '' ?></textarea>
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
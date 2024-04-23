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

?>

<?php include '../layout/_assign.php';




$error_message = '';
$success_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `teams` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $teams = $result["data"][0];

        $name = htmlspecialchars($teams['name']);
        $mobileNumber = htmlspecialchars($teams['mobileNumber']);
        $hireDate = htmlspecialchars($teams['hireDate']);
        $description = htmlspecialchars($teams['description']);
        $status = htmlspecialchars($teams['status']);
        $facebook = htmlspecialchars($teams['facebook']);
        $instagram = htmlspecialchars($teams['instagram']);
        $twitter = htmlspecialchars($teams['twitter']);
        $email = htmlspecialchars($teams['email']);
        $photo = htmlspecialchars($teams['photo']);
    } else {
        $error_message = "Record not found or error fetching data.";
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
                                    <label for="name" class="form-label">Staff Name</label>
                                    <input type="text" class="form-control" name="name" id="blogHeading" value="<?= $name ?? '' ?>" placeholder="Staff Name" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                                    <input type="number" class="form-control" name="mobileNumber" id="mobileNumber" value="<?= $mobileNumber ?? '' ?>" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, ''); placeholder=" Mobile Number" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="hireDate" class="form-label">Hire Date</label>
                                    <input type="date" class="form-control" name="hireDate" id="hireDate" value="<?= $hireDate ?? '' ?>" disabled>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="description">Description</label>
                                    <textarea class="form-control z-depth-1" id="description" name="description" rows="5" placeholder="Write Something here" readonly><?= $description ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook" value="<?= $facebook ?? '' ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Instagram" value="<?= $instagram ?? '' ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter" value="<?= $twitter ?? '' ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email ?? '' ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Staff Photo</label>
                                    <br>
                                </div>
                                <div class="mb-3">
                                    <?php if (!empty($photo) && file_exists("../uploads/" . $photo)) : ?>
                                        <img src="<?= "../uploads/" . $photo ?>" alt="Current Staff Photo" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No Image available</p>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status" disabled>
                                        <option value="" <?= !isset($status) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="PUBLISH" <?= (isset($status) && $status == 'PUBLISH') ? 'selected' : '' ?>>PUBLISH</option>
                                        <option value="UNPUBLISH" <?= (isset($status) && $status == 'UNPUBLISH') ? 'selected' : '' ?>>UNPUBLISH</option>
                                    </select>
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
        </body>

        </html>
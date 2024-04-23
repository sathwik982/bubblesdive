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

$error_message = '';
$success_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `about` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $about = $result["data"][0];

        $name = htmlspecialchars($about['name']);
        $establishedDate = htmlspecialchars($about['establishedDate']);
        $servicesOffered = htmlspecialchars($about['servicesOffered']);
        $location = htmlspecialchars($about['location']);
        $description = htmlspecialchars($about['description']);
        $bannerImage = htmlspecialchars($about['bannerImage']);
        $status = htmlspecialchars($about['status']);
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
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $id ?? '' ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?= $name ?? '' ?>" placeholder="Name" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="establishedDate" class="form-label">Established Date</label>
                                    <input type="date" class="form-control" name="establishedDate" value="<?= $establishedDate ?? '' ?>" id="establishedDate" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" id="location" value="<?= $location ?? '' ?>" placeholder="Location" disabled>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="servicesOffered">Services Offered</label>
                                    <textarea class="form-control z-depth-1" id="servicesOffered" name="servicesOffered" rows="5" placeholder="Write Something here" readonly><?= $servicesOffered ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="description">Description</label>
                                    <textarea class="form-control z-depth-1" id="description" name="description" rows="5" placeholder="Write Something here" readonly><?= $description ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="bannerImage" class="form-label">Banner Image</label>
                                    <br>
                                    <?php if (!empty($bannerImage) && file_exists($bannerImage)) : ?>
                                        <img src="<?= $bannerImage ?>" alt="Current Banner Image" class="img-thumbnail" disabled style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No banner image available</p>
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

        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>
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
$no_changes_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM `blogs` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $about = $result["data"][0];

        $blogHeading = htmlspecialchars($about['blogHeading']);
        $subHeading = htmlspecialchars($about['subHeading']);
        $comments = htmlspecialchars($about['comments']);
        $status = htmlspecialchars($about['status']);
        $blogImagePath = htmlspecialchars($about['blogImage']);
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
                        <?php elseif (!empty($no_changes_message)) : ?>
                            <div class="alert alert-info"><?= $no_changes_message ?></div>
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
                                    <label for="blogHeading" class="form-label">Article Heading</label>
                                    <input type="text" class="form-control" name="blogHeading" id="blogHeading" value="<?= $blogHeading ?? '' ?>" readonly>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="subHeading">Sub-Heading</label>
                                    <textarea class="form-control z-depth-1" id="subHeading" name="subHeading" rows="5" readonly><?= $subHeading ?? '' ?></textarea>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="comments">Article Content</label>
                                    <textarea class="form-control z-depth-1" id="comments" name="comments" rows="5" readonly><?= $comments ?? '' ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="bannerImage" class="form-label">Article Image</label>
                                    <br>
                                    <?php if (!empty($blogImagePath) && file_exists($blogImagePath)) : ?>
                                        <img src="<?= $blogImagePath ?>" alt="Current Banner Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No banner image available</p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <input type="text" class="form-control" name="status" id="status" value="<?= $status ?? '' ?>" readonly>
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
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message) || !empty($no_changes_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>
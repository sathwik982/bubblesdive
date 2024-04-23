<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit();
}

$userData = $_SESSION["auth"];

include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

?>

<?php include '../layout/_assign.php';



$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mediaType = htmlspecialchars($_POST['mediaType']);
    $status = htmlspecialchars($_POST['status']);

    $uploadsDirectory = "../uploads/";

    $targetFile = $uploadsDirectory . basename($_FILES["mediaUrl"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($mediaType == "IMAGE" && !in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
        $error_message = "For image media type, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    } elseif ($mediaType == "VIDEO" && !in_array($fileType, ["mp4", "avi", "mkv", "mov"])) {
        $error_message = "For video media type, only MP4, AVI, MKV, and MOV files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["mediaUrl"]["tmp_name"], $targetFile)) {
            if ($_FILES["mediaUrl"]["size"] > 50000000) {
                $error_message = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                $mediaUrl = basename($_FILES["mediaUrl"]["name"]);
                $mediaUrlPath = "../uploads/" . $mediaUrl;

                if (!empty($status)) {
                    $sql = "INSERT INTO `gallery` (mediaType, status, mediaUrl) VALUES (?, ?, ?)";
                    $params = [$mediaType, $status, $mediaUrlPath];
                    $stmt = $db->getConnection()->prepare($sql);
                    if ($stmt->execute($params)) {
                        $success_message = "Record has been added successfully! Redirecting...";
                        echo '<script>
                            setTimeout(function() {
                                window.location.href = "index.php";
                            }, 1000); 
                        </script>';
                    } else {
                        $error_message = "Failed to add record details. Please try again.";
                    }
                }
            }
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
    }
}

$sql = "SELECT *, DATE_FORMAT(createdDate, '%d-%b-%Y') as `cdate` FROM `gallery`";
$result = $db->run($sql);
if ($result["status"] == "success") {
    $gallery = $result["data"];
}
?>

<!-- TEMPLATE STARTS -->

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
                        <h2 class="header-title">Add Record</h2>
                        <div class="header-sub-title">
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="mediaType" class="form-label">Media Type</label>
                                                <select class="form-control" name="mediaType" required>
                                                    <option value="" selected>Please Select</option>
                                                    <option value="IMAGE">IMAGE</option>
                                                    <option value="VIDEO">VIDEO</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mediaUrl" class="form-label">Media (Image or Video)</label>
                                                <input class="form-control form-control-sm" id="mediaUrl" name="mediaUrl" type="file" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label><br>
                                                <select class="form-control" name="status" required>
                                                    <option value="" selected>Please Select</option>
                                                    <option value="PUBLISH">PUBLISH</option>
                                                    <option value="UNPUBLISH">UNPUBLISH</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer and scripts as before -->
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
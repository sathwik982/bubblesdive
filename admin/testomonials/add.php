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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authorName = $_POST['authorName'];
    $feedback = $_POST['feedback'];
    $status = $_POST['status'];

    if (!empty($status)) {
        $sql = "INSERT INTO `testimonials` (authorName, feedback, status) VALUES (?, ?, ?)";
        $params = [$authorName, $feedback, $status];
        $result = $db->run($sql, $params);

        if ($result["status"] == "success") {
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

$sql = "SELECT *, DATE_FORMAT(createdDate, '%d-%b-%Y') as `cdate` FROM `testimonials`";
$result = $db->run($sql);

if ($result["status"] == "success") {
    $testimonials = $result["data"];
}
?>


<!-- TEMPLATE STARTS -->

<!-- TEMPLATE STARTS -->

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">Add Record</h2>
            <div class="header-sub-title">
            </div>
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
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="authorName" class="form-label">Author Name</label>
                                    <input type="text" class="form-control" name="authorName" id="question" placeholder="Author Name" required>

                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="feedback">Feedback</label>
                                    <textarea class="form-control z-depth-1" id="feedback" name="feedback" rows="5" placeholder="Write Something here.." required></textarea>
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

        <!-- Footer START -->
        <?php include '../layout/_footer.php'; ?>

        <?php include '../layout/_scripts.php'; ?>
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
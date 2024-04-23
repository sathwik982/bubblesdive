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
$no_changes_message = '';

$sql = "SELECT productTypeId, productType FROM producttype";
$stmt = $db->getConnection()->query($sql);
$productTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['productId'])) {
    $productId = intval($_GET['productId']);

    $sql = "SELECT * FROM `products` WHERE productId = ?";
    $params = [$productId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $products = $result["data"][0];

        $productTypeId = htmlspecialchars($products['productTypeId']);
        $quantity = htmlspecialchars($products['quantity']);
        $description = htmlspecialchars($products['description']);
        $status = htmlspecialchars($products['status']);
        $productImagePath = htmlspecialchars($products['productImage']);
    } else {
        $error_message = "Record not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productTypeId = intval($_POST['productTypeId']);
    $productId = intval($_POST['productId']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $description = htmlspecialchars($_POST['description']);
    $status = htmlspecialchars($_POST['status']);

    if (!empty($_FILES["productImage"]["name"])) {
        $targetDirectory = "../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["productImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["productImage"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["productImage"]["size"] > 5000000) {
                $error_message = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $error_message .= " Your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                $productImage = basename($_FILES["productImage"]["name"]);
                $productImagePath = "../uploads/" . $productImage;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    $sql = "UPDATE `products` SET productTypeId = ?, quantity = ?, description = ?, status = ?";
    $params = [$productTypeId, $quantity, $description, $status];

    if (!empty($_FILES["productImage"]["name"])) {
        $sql .= ", productImage = ?";
        $params[] = $productImagePath;
    }

    $sql .= " WHERE productId = ?";
    $params[] = $productId;

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
                                <input type="hidden" name="productId" value="<?php echo isset($_GET['productId']) ? $_GET['productId'] : ''; ?>">
                                <input type="hidden" name="productTypeId" value="<?php echo isset($_GET['productTypeId']) ? $_GET['productTypeId'] : ''; ?>">
                                <div class="mb-3">
                                    <label for="productTypeId" class="form-label">Product Type</label>
                                    <select name="productTypeId" id="productTypeId" class="form-select">
                                        <?php foreach ($productTypes as $product) : ?>
                                            <?php $selected = ($product['productTypeId'] == $productTypeId) ? 'selected' : ''; ?>
                                            <option value="<?= htmlspecialchars($product['productTypeId']) ?>" <?= $selected ?>><?= htmlspecialchars($product['productType']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity" value="<?= $quantity ?? '' ?>" min="0" placeholder="Quantity" required>
                                </div>
                                <div class="form-group shadow-textarea">
                                    <label for="description">Description</label>
                                    <textarea class="form-control z-depth-1" id="description" name="description" rows="5" placeholder="Write Something here" required><?= $description ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Product Image</label>
                                    <input class="form-control form-control-sm" id="productImage" name="productImage" type="file" accept=".jpeg, .png, .jpg, image/jpeg, image/png">
                                </div>
                                <div class="mb-3">
                                    <?php if (!empty($productImagePath) && file_exists($productImagePath)) : ?>
                                        <img src="<?= $productImagePath ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <p>No Image available</p>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <select class="form-control" name="status" required>
                                        <option value="" <?= !isset($status) ? 'selected' : '' ?>>Please Select</option>
                                        <option value="PUBLISH" <?= (isset($status) && $status == 'PUBLISH') ? 'selected' : '' ?>>PUBLISH</option>
                                        <option value="UNPUBLISH" <?= (isset($status) && $status == 'UNPUBLISH') ? 'selected' : '' ?>>UNPUBLISH</option>
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
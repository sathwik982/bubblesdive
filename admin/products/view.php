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






$productId = intval($_GET['productId']);

$sql = "SELECT p.*, pt.productType 
FROM `products` p 
LEFT JOIN `producttype` pt ON p.productTypeId = pt.productTypeId
WHERE p.productId = ?";

$params = [$productId];
$result = $db->run($sql, $params);

if ($result["status"] == "success" && !empty($result["data"])) {
    $products = $result["data"][0];

    $productType = htmlspecialchars($products['productType']);
    $quantity = htmlspecialchars($products['quantity']);
    $description = htmlspecialchars($products['description']);
    $status = htmlspecialchars($products['status']);
    $productImagePath = htmlspecialchars($products['productImage']);
} else {
    $error_message = "Record not found.";
}

?>

<?php include '../layout/_header.php'; ?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="productId" value="<?php echo isset($_GET['productId']) ? $_GET['productId'] : ''; ?>">
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger"><?= $error_message ?></div>
                                <?php else : ?>
                                    <div class="mb-3">
                                        <label for="productType" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productType" value="<?= $productType ?? '' ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" value="<?= $quantity ?? '' ?>" id="quantity" disabled>
                                    </div>
                                    <div class="form-group shadow-textarea">
                                        <label for="description">Description</label>
                                        <textarea class="form-control z-depth-1" id="description" rows="5" readonly><?= $description ?? '' ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Product Image</label><br>
                                        <?php if (!empty($productImagePath) && file_exists($productImagePath)) : ?>
                                            <img src="<?= $productImagePath ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        <?php else : ?>
                                            <p>No Image available</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label><br>
                                        <input type="text" class="form-control" value="<?= $status ?? '' ?>" disabled>
                                    </div>
                                <?php endif; ?>
                                <a href="index.php" class="btn btn-success">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        </body>

        </html>
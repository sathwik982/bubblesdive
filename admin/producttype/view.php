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





$error_message = '';
$success_message = '';

if (isset($_GET['productTypeId'])) {
    $productTypeId = intval($_GET['productTypeId']);

    $sql = "SELECT * FROM `producttype` WHERE productTypeId = ?";
    $params = [$productTypeId];
    $result = $db->run($sql, $params);

    if ($result["status"] == "success" && !empty($result["data"])) {
        $producttype = $result["data"][0];

        $productType = htmlspecialchars($producttype['productType']);
        $price = htmlspecialchars($producttype['price']);
        $status = htmlspecialchars($producttype['status']);
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

        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger"><?= $error_message ?></div>
                                <?php else : ?>
                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="productTypeId" value="<?= isset($_GET['productTypeId']) ? $_GET['productTypeId'] : ''; ?>">
                                        <div class="mb-3">
                                            <label for="productType" class="form-label">Product Type</label>
                                            <input type="text" class="form-control" id="productType" value="<?= $productType ?? '' ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" value="<?= $price ?? '' ?>" id="price" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label><br>
                                            <input type="text" class="form-control" value="<?= $status ?? '' ?>" disabled>
                                        </div>
                                        <a href="index.php" class="btn btn-success">Back</a>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../layout/_footer.php'; ?>
        <?php include '../layout/_scripts.php'; ?>
        </body>

        </html>
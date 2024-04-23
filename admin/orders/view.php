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

$id = $customerId = $productId = $productTypeId = $quantity_ordered = $color = $size = $orderDate = $total_price = $customerFullName = $productType = '';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);


    $sql = "SELECT * FROM `orders` WHERE id = ?";
    $params = [$id];
    $result = $db->run($sql, $params);


    if ($result["status"] == "success" && !empty($result["data"])) {
        $orders = $result["data"][0];


        $customerId = htmlspecialchars($orders['customerId']);
        $productId = htmlspecialchars($orders['productId']);
        $productTypeId = htmlspecialchars($orders['productTypeId']);
        $quantity_ordered = htmlspecialchars($orders['quantity_ordered']);
        $orderDate = htmlspecialchars($orders['orderDate']);
        $total_price = htmlspecialchars($orders['total_price']);

        $sqlUser = "SELECT customerFullName FROM `customers` WHERE customerId = ?";
        $paramsUser = [$customerId];
        $resultUser = $db->run($sqlUser, $paramsUser);

        if ($resultUser["status"] == "success" && !empty($resultUser["data"])) {
            $customerFullName = htmlspecialchars($resultUser["data"][0]["customerFullName"]);
        }

        $sqlProduct = "SELECT productType FROM `producttype` WHERE productTypeId = ?";
        $paramsProduct = [$productTypeId];
        $resultProduct = $db->run($sqlProduct, $paramsProduct);

        if ($resultProduct["status"] == "success" && !empty($resultProduct["data"])) {
            $productType = htmlspecialchars($resultProduct["data"][0]["productType"]);
        }
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

        <div class="container">
            <div class="page-headers">
                <h2 class="header-title">View Record</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                <input type="hidden" name="customerId" value="<?= $customerId ?>">
                                <input type="hidden" name="productId" value="<?= $productId ?>">
                                <div class="mb-3">
                                    <label for="customerFullName" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="customerFullName" id="customerFullName" value="<?= $customerFullName ?? '' ?>" placeholder="Customer Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="productType" class="form-label">Product Type</label>
                                    <input type="text" class="form-control" name="productType" id="productType" value="<?= $productType ?? '' ?>" placeholder="Product Type" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity_ordered" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity_ordered" id="quantity_ordered" value="<?= $quantity_ordered ?>" placeholder="Quantity" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="orderDate" class="form-label">Order Date</label>
                                    <input type="date" class="form-control" name="orderDate" id="orderDate" value="<?= $orderDate ?>" placeholder="Order Date" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Total Price</label>
                                    <input type="number" class="form-control" name="total_price" id="total_price" value="<?= $total_price ?>" placeholder="Total Price" readonly>
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
        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>
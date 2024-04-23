<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit;
}

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

include './app/database/Connection.php';
$db = new Connection();

$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `languages` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
    $languages = $result["data"];
}
?>

<?php include './layout/_header.php'; ?>
<?php include './layout/_navbar.php'; ?>

<div class="page-header">
    <h2 class="header-title">Languages</h2>
    <div class="header-sub-title">
    </div>
</div>

<div class="container">
    <div class="table-responsive">
        <?php if (empty($languages)) : ?>
            <h5>No data found</h5>
        <?php else : ?>
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Language</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($languages as $language) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $language["languageName"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Footer START -->
<?php include './layout/_footer.php'; ?>
<?php include './layout/_scripts.php'; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
</body>

</html>
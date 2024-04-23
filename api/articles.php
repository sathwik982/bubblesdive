<?php
include '../admin/app/database/Connection.php';
$db = new Connection();
$sql = "SELECT * FROM `blogs` WHERE status = 'PUBLISH' ORDER BY createdDate DESC";
$result = $db->run($sql);
if ($result["status"] === "success") {
    $blog = $result["data"];
    $response = [
        'status' => 'success',
        'blog' => $blog
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Failed to fetch published Articles'
    ];
}
header('Content-Type: application/json');
echo json_encode($response);

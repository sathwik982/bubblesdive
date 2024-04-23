<?php
include '../admin/app/database/Connection.php';
$db = new Connection();
$sql = "SELECT * FROM `about` WHERE status = 'PUBLISH' ORDER BY createdDate DESC";
$result = $db->run($sql);
if ($result["status"] === "success") {
    $abouts = $result["data"];
    $response = [
        'status' => 'success',
        'abouts' => $abouts
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Failed to fetch published About'
    ];
}
header('Content-Type: application/json');
echo json_encode($response);

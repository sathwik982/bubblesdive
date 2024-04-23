<?php
include '../admin/app/database/Connection.php';
$db = new Connection();
$sql = "SELECT * FROM `faq` WHERE status = 'PUBLISH' ORDER BY createdDate DESC";
$result = $db->run($sql);
if ($result["status"] === "success") {
    $faqs = $result["data"];
    $response = [
        'status' => 'success',
        'faqs' => $faqs
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Failed to fetch published FAQs'
    ];
}
header('Content-Type: application/json');
echo json_encode($response);

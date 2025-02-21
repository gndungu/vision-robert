<?php
require '../db_connect.php';

// Fetch crops
$crops = [];
$sql = "SELECT id, common_name, scientific_name FROM crops";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}

// Create response
$response = [
    'status' => 'success',
    'crops' => $crops
];

// ob_start();
// Set JSON response header
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

$conn->close();
?>

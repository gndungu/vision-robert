<?php

require '../db_connect.php';

// Fetch diseases
$diseases = [];
$sql = "SELECT id, disease_index, disease_name, disease_symptom, disease_cure, disease_prevention, crop_id FROM diseases";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $diseases[] = $row;
    }
}


// Create response
$response = [
    'status' => 'success',
    'diseases' => $diseases
];

ob_start();
// Set JSON response header
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

$conn->close();
?>

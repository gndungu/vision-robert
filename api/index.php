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

// Fetch diseases
$diseases = [];
$sql = "SELECT id, disease_name, disease_symptom, disease_cure, disease_severity, crop_id FROM diseases";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $diseases[] = $row;
    }
}

// Fetch treatments
$treatments = [];
$sql = "SELECT id, disease_id, treatment_recommendation, treatment_instruction FROM treatments";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $treatments[] = $row;
    }
}

// Create response
$response = [
    'status' => 'success',
    'crops' => $crops,
    'diseases' => $diseases,
    'treatments' => $treatments
];

ob_start();
// Set JSON response header
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

$conn->close();
?>

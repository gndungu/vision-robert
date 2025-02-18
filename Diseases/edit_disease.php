<?php
require '../db_connect.php';

// Fetch the disease details if 'id' is set in the URL
if (isset($_GET['id'])) {
    $disease_id = $_GET['id'];

    // Fetch the current disease details
      $sql = "SELECT id, disease_name, disease_symptom, disease_cure, disease_severity, crop_id FROM diseases WHERE id = ?";    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $disease_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($disease_id, $disease_name, $disease_symptom, $disease_cure, $disease_severity, $crop_id);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "<p class='alert alert-danger'>Error fetching disease details: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='alert alert-danger'>Disease ID not provided.</p>";
    exit();
}

// Fetch crops to display in the dropdown
$sql = "SELECT id, common_name FROM crops";
$result = $conn->query($sql);
$crops = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}

// Handle form submission for updating the disease
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $disease_name = $_POST['disease_name'];
    $disease_symptom = $_POST['disease_symptom'];
    $disease_cure = $_POST['disease_cure'];
    $disease_severity = $_POST['disease_severity'];
    $crop_id = $_POST['crop_id'];

    // Prepare SQL to update the disease in the database
    $sql = "UPDATE diseases
            SET disease_name = ?, disease_symptom = ?, disease_cure = ?, disease_severity = ?, crop_id = ?
            WHERE id = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssssii", $disease_name, $disease_symptom, $disease_cure, $disease_severity, $crop_id, $disease_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p class='alert alert-success'>Disease updated successfully.</p>";
            header("Location: index.php");
            exit();
        } else {
            echo "<p class='alert alert-danger'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='alert alert-danger'>Error: " . $conn->error . "</p>";
    }
}

?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Edit Disease</h2>

        <form action="edit_disease.php?id=<?php echo $disease_id; ?>" method="POST">
            <div class="form-group">
                <label for="disease_name">Disease Name</label>
                <input type="text" class="form-control" id="disease_name" name="disease_name" value="<?php echo htmlspecialchars($disease_name); ?>" required>
            </div>

            <div class="form-group">
                <label for="disease_symptom">Disease Symptoms</label>
                <textarea class="form-control" id="disease_symptom" name="disease_symptom" rows="4" required><?php echo htmlspecialchars($disease_symptom); ?></textarea>
            </div>

            <div class="form-group">
                <label for="disease_cure">Disease Cure</label>
                <textarea class="form-control" id="disease_cure" name="disease_cure" rows="4" required><?php echo htmlspecialchars($disease_cure); ?></textarea>
            </div>

            <div class="form-group">
                <label for="disease_severity">Disease Severity</label>
                <select class="form-control" id="disease_severity" name="disease_severity" required>
                    <option value="Low" <?php if ($disease_severity == "Low") echo 'selected'; ?>>Low</option>
                    <option value="Moderate" <?php if ($disease_severity == "Moderate") echo 'selected'; ?>>Moderate</option>
                    <option value="High" <?php if ($disease_severity == "High") echo 'selected'; ?>>High</option>
                    <option value="Severe" <?php if ($disease_severity == "Severe") echo 'selected'; ?>>Severe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="crop_id">Select Crop</label>
                <select class="form-control" id="crop_id" name="crop_id" required>
                    <option value="">Select a crop</option>
                    <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['id']; ?>" <?php if ($crop['id'] == $crop_id) echo 'selected'; ?>>
                            <?php echo $crop['common_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-warning mt-3">Update Disease</button>
        </form>
    </div>
</body>
</html>

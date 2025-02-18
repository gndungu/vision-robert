<?php
require '../db_connect.php';

// Fetch crops to display in the dropdown
$sql = "SELECT id, common_name FROM crops";
$result = $conn->query($sql);
$crops = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}

// Handle form submission for creating a new disease
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $disease_name = $_POST['disease_name'];
    $disease_symptom = $_POST['disease_symptom'];
    $disease_cure = $_POST['disease_cure'];
    $disease_severity = $_POST['disease_severity'];
    $crop_id = $_POST['crop_id'];

    // Prepare SQL to insert the disease into the database
    $sql = "INSERT INTO diseases (disease_name, disease_symptom, disease_cure, disease_severity, crop_id)
            VALUES (?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssssi", $disease_name, $disease_symptom, $disease_cure, $disease_severity, $crop_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p class='alert alert-success'>Disease added successfully.</p>";
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
        <h2>Add New Disease</h2>

        <form action="create_disease.php" method="POST">
            <div class="form-group">
                <label for="disease_name">Disease Name</label>
                <input type="text" class="form-control" id="disease_name" name="disease_name" required>
            </div>

            <div class="form-group">
                <label for="disease_symptom">Disease Symptoms</label>
                <textarea class="form-control" id="disease_symptom" name="disease_symptom" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="disease_cure">Disease Cure</label>
                <textarea class="form-control" id="disease_cure" name="disease_cure" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="disease_severity">Disease Severity</label>
                <select class="form-control" id="disease_severity" name="disease_severity" required>
                    <option value="Low">Low</option>
                    <option value="Moderate">Moderate</option>
                    <option value="High">High</option>
                    <option value="Severe">Severe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="crop_id">Select Crop</label>
                <select class="form-control" id="crop_id" name="crop_id" required>
                    <option value="">Select a crop</option>
                    <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['id']; ?>"><?php echo $crop['common_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Add Disease</button>
        </form>
    </div>
</body>
</html>

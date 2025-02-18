<?php
require '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $common_name = $_POST['common_name'];
    $scientific_name = $_POST['scientific_name'];

    $sql = "INSERT INTO crops (common_name, scientific_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $common_name, $scientific_name);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Create New Crop</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="common_name" class="form-label">Common Name</label>
                <input type="text" name="common_name" id="common_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="scientific_name" class="form-label">Scientific Name</label>
                <input type="text" name="scientific_name" id="scientific_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Crop</button>
        </form>
    </div>

</body>
</html>

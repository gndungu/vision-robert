<?php
require '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $sql = "SELECT id, common_name, scientific_name, created_at, updated_at FROM crops WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($crop_id, $common_name, $scientific_name, $created_at, $updated_at);
    $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $common_name = $_POST['common_name'];
    $scientific_name = $_POST['scientific_name'];

    $sql = "UPDATE crops SET common_name = ?, scientific_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $common_name, $scientific_name, $id);

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
        <h2>Edit Crop</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="common_name" class="form-label">Common Name</label>
                <input type="text" name="common_name" id="common_name" class="form-control" value="<?php echo $common_name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="scientific_name" class="form-label">Scientific Name</label>
                <input type="text" name="scientific_name" id="scientific_name" class="form-control" value="<?php echo $scientific_name; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Crop</button>
        </form>
    </div>

</body>
</html>

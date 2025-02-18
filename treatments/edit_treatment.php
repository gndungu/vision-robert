<?php
require '../db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch treatment details
    $sql = "SELECT id, disease_id, treatment_recommendation, treatment_instruction, created_at, updated_at FROM treatments WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($treatment_id, $disease_id, $treatment_recommendation, $treatment_instruction, $created_at, $updated_at);
        $stmt->fetch();
    }

    // Update treatment if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $disease_id = $_POST['disease_id'];
        $treatment_recommendation = $_POST['treatment_recommendation'];
        $treatment_instruction = $_POST['treatment_instruction'];

        $update_sql = "UPDATE treatments SET disease_id = ?, treatment_recommendation = ?, treatment_instruction = ? WHERE id = ?";
        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("issi", $disease_id, $treatment_recommendation, $treatment_instruction, $id);
            $stmt->execute();
            header("Location: index.php");
            exit();
        }
    }

    $sql = "SELECT id, disease_name FROM diseases";
    $diseases = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: index.php");
    exit();
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Edit Treatment</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="disease_id" class="form-label">Select Disease</label>
                <select id="disease_id" name="disease_id" class="form-select" required>
                    <option value="">Select Disease</option>
                    <?php foreach ($diseases as $disease) { ?>
                        <option value="<?php echo $disease['id']; ?>" <?php echo $disease['id'] == $disease_id ? 'selected' : ''; ?>>
                            <?php echo $disease['disease_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="treatment_recommendation" class="form-label">Treatment Recommendation</label>
                <textarea id="treatment_recommendation" name="treatment_recommendation" class="form-control" required><?php echo $treatment_recommendation; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="treatment_instruction" class="form-label">Treatment Instruction</label>
                <textarea id="treatment_instruction" name="treatment_instruction" class="form-control" required><?php echo $treatment_instruction; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Treatment</button>
        </form>
    </div>
</body>
</html>

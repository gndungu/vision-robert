<?php
require '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disease_id = $_POST['disease_id'];
    $treatment_recommendation = $_POST['treatment_recommendation'];
    $treatment_instruction = $_POST['treatment_instruction'];

    $sql = "INSERT INTO treatments (disease_id, treatment_recommendation, treatment_instruction) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iss", $disease_id, $treatment_recommendation, $treatment_instruction);
        $stmt->execute();
        header("Location: index.php");
        exit();
    }
}

$sql = "SELECT id, disease_name FROM diseases";
$diseases = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Create Treatment</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="disease_id" class="form-label">Select Disease</label>
                <select id="disease_id" name="disease_id" class="form-select" required>
                    <option value="">Select Disease</option>
                    <?php foreach ($diseases as $disease) { ?>
                        <option value="<?php echo $disease['id']; ?>"><?php echo $disease['disease_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="treatment_recommendation" class="form-label">Treatment Recommendation</label>
                <textarea id="treatment_recommendation" name="treatment_recommendation" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="treatment_instruction" class="form-label">Treatment Instruction</label>
                <textarea id="treatment_instruction" name="treatment_instruction" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Treatment</button>
        </form>
    </div>
</body>
</html>

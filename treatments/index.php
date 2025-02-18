<?php
require '../db_connect.php';

$sql = "SELECT t.id, t.treatment_recommendation, t.treatment_instruction, d.disease_name
        FROM treatments t
        JOIN diseases d ON t.disease_id = d.id";
$result = $conn->query($sql);

$treatments = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $treatments[] = $row;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Treatments List</h2>
        <a href="create_treatment.php" class="btn btn-success mb-3">Add Treatment</a>

        <?php if (empty($treatments)) { ?>
            <p>No treatments found.</p>
        <?php } else { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Disease</th>
                        <th>Treatment Recommendation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($treatments as $treatment) { ?>
                        <tr>
                            <td><?php echo $treatment['id']; ?></td>
                            <td><?php echo $treatment['disease_name']; ?></td>
                            <td><?php echo $treatment['treatment_recommendation']; ?></td>
                            <td>
                                <a href="edit_treatment.php?id=<?php echo $treatment['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_treatment.php?id=<?php echo $treatment['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this treatment?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

</body>
</html>

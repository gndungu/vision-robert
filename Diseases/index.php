<?php
require '../db_connect.php';

// Fetch crops to associate with diseases
$sql = "SELECT id, common_name, scientific_name FROM crops";
$result = $conn->query($sql);

$crops = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}

// Fetch diseases from the database
$sql = "SELECT * FROM diseases";
$result = $conn->query($sql);

$diseases = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $diseases[] = $row;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Diseases List</h2>
        <!-- Add Disease Button -->
        <a href="create_disease.php" class="btn btn-success mb-3">Add Disease</a>

        <?php if (empty($diseases)) { ?>
            <p>No diseases found.</p>
        <?php } else { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Disease Index</th>
                        <th>Disease Name</th>
                        <th>Disease Symptom</th>
                        <th>Disease Cure</th>
                        <th>Disease Prevention</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diseases as $disease) { ?>
                        <tr>
                          <td><?php echo $disease['id']; ?></td>
                            <td><?php echo $disease['disease_index']; ?></td>
                            <td><?php echo $disease['disease_name']; ?></td>
                            <td><?php echo $disease['disease_symptom']; ?></td>
                            <td><?php echo $disease['disease_cure']; ?></td>
                            <td><?php echo $disease['disease_prevention']; ?></td>
                            <td>
                                <?php
                                    // Find the crop name for this disease
                                    $crop_name = '';
                                    foreach ($crops as $crop) {
                                        if ($crop['id'] == $disease['crop_id']) {
                                            $crop_name = $crop['common_name'];
                                            break;
                                        }
                                    }
                                    echo $crop_name;
                                ?>
                            </td>
                            <td>
                                <a href="edit_disease.php?id=<?php echo $disease['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_disease.php?id=<?php echo $disease['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this disease?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

</body>
</html>

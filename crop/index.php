<?php
require '../db_connect.php';

$sql = "SELECT id, common_name, scientific_name FROM crops";
$result = $conn->query($sql);

$crops = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>
    <div class="content">
        <h2>Crops List</h2>
        <!-- Add Crop Button -->
        <a href="create_crop.php" class="btn btn-success mb-3">Add Crop</a>

        <?php if (empty($crops)) { ?>
            <p>No crops found.</p>
        <?php } else { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Index</th>
                        <th>Common Name</th>
                        <th>Scientific Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($crops as $crop) { ?>
                        <tr>
                            <td><?php echo $crop['id']; ?></td>
                            <td><?php echo $crop['common_name']; ?></td>
                            <td><?php echo $crop['scientific_name']; ?></td>
                            <td>
                                <a href="edit_crop.php?id=<?php echo $crop['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_crop.php?id=<?php echo $crop['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this crop?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

</body>
</html>

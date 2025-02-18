<?php
require '../db_connect.php';

$sql = "SELECT id, name, phone_number, acreage FROM farmers";
$result = $conn->query($sql);

$farmers = [];
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    while($row = $result->fetch_assoc()) {
        $farmers[] = $row;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>

    <!-- Main Content -->
    <div class="content">
      <h2 class="text-center">Farmers List</h2>

        <?php
        // Check if there are farmers to display
        if (empty($farmers)) {
            echo "<p class='text-center'>No farmers found.</p>";
        } else {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Acreage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($farmers as $farmer) { ?>
                        <tr>
                            <td><?php echo $farmer['id']; ?></td>
                            <td><?php echo $farmer['name']; ?></td>
                            <td><?php echo $farmer['phone_number']; ?></td>
                            <td><?php echo $farmer['acreage']; ?></td>
                            <td>
                                <a href="view_farmer.php?id=<?php echo $farmer['id']; ?>" class="btn btn-info btn-sm">View</a>
                                <a href="edit_farmer.php?id=<?php echo $farmer['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_farmer.php?id=<?php echo $farmer['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this farmer?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

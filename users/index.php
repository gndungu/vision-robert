<?php
require '../db_connect.php';

$sql = "SELECT id, username FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<?php include '../header.php' ?>
<body>
    <?php include '../menu.php' ?>

    <!-- Main Content -->
    <div class="content">
      <h2 class="text-center">Users List</h2>

        <?php
        // Check if there are farmers to display
        if (empty($users)) {
            echo "<p class='text-center'>No users found.</p>";
        } else {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td>
                                <a href="view_user.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">View</a>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this farmer?')">Delete</a>
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

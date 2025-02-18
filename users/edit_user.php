<?php
require '../db_connect.php';

// Get user ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid user ID.");
}

$user_id = $_GET['id'];

// Fetch user data
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    // Update query
    if (!empty($new_password)) {
        // Hash password before storing
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $new_username, $hashed_password, $user_id);
    } else {
        // Update username only
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_username, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to user list
        exit();
    } else {
        echo "Error updating user.";
    }

    $stmt->close();
}

$conn->close();
?>

<?php include '../header.php'; ?>
<body>
    <?php include '../menu.php'; ?>
    <div class="content">
        <h2>Edit User</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (Leave blank to keep current)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="user_list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

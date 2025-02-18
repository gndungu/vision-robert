<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php' ?>
<body>

    <?php include 'menu.php' ?>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome to the Dashboard</h2>
        <p>Select a menu item from the sidebar to manage your data.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

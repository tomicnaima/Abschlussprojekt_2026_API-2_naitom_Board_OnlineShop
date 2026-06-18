<nav>
    <ul>
        <li><a href="index.php">Home</a></li>

        <?php if (!isset($_SESSION['user_role'])): ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Registrieren</a></li>

        <?php elseif ($_SESSION['user_role'] === 'customer'): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php elseif ($_SESSION['user_role'] === 'admin'): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="users.php">Benutzer</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php endif; ?>
    </ul>
</nav>
<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Navigationsleiste für die Website, die sich je nach Benutzerrolle anpasst.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */
?>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>

        <?php if (!isset($_SESSION['user_role'])): ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Registrieren</a></li>

        <?php elseif ($_SESSION['user_role'] === 'customer'): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="cart.php">Warenkorb</a></li>
            <li><a href="my_orders.php">Meine Bestellungen</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php elseif ($_SESSION['user_role'] === 'admin'): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="cart.php">Warenkorb</a></li>
            <li><a href="my_orders.php">Meine Bestellungen</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="admin_orders.php">Bestellungen (Admin)</a></li>
            <li><a href="admin_products.php" style="font-weight: bold; color: #FF69B4;">Produkte verwalten</a></li>

        <?php endif; ?>
    </ul>
</nav>
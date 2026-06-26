<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Admin-Seite zur Ansicht aller Bestellungen
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

session_start();
include 'includes/header.php';

// 1. Sicherheitsschloss (Issue #5): Nur Admins dürfen diese Seite sehen!
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "<main class='container'><p style='color:red; font-weight:bold;'>Zugriff verweigert! Du bist kein Admin.</p></main>";
    include 'includes/footer.php';
    exit();
}

try {
    // Verbindung Datenbank
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Query: Holt die Bestellungen und den passenden Username mit JOIN
    // Wir sortieren nach der neuesten Bestellung (DESC)
    $stmt = $db->query("
        SELECT o.id AS order_id, o.total_price, o.status, o.created_at, u.username 
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler beim Laden der Bestellungen: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Admin-Dashboard: Bestellübersicht</h2>
    <p>Hier siehst du alle eingegangenen Bestellungen im Shop:</p>

    <?php if (empty($orders)): ?>
        <p>Es sind noch keine Bestellungen eingegangen.</p>
    <?php else: ?>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; height: 40px; color: #7f8c8d;">
                        <th>Bestell-ID</th>
                        <th>Kunde</th>
                        <th>Datum / Uhrzeit</th>
                        <th>Gesamtsumme</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr style="border-bottom: 1px solid #eee; height: 50px;">
                            <td style="font-weight: bold;">#<?php echo $order['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td style="font-weight: bold; color: #e74c3c;">CHF <?php echo number_format($order['total_price'], 2, '.', '\''); ?></td>
                            <td>
                                <span style="background: #ffeaa7; color: #d63031; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem; font-weight: bold;">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
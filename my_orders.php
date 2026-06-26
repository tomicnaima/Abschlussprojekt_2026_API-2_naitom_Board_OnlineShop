<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Kunden-Bestellübersicht in CHF mit tabellarischer Auflistung.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

session_start();
include 'includes/header.php';

// 1. Sicherheitsschloss: Nur eingeloggte Kunden dürfen ihre eigenen Bestellungen sehen
if (!isset($_SESSION['user_id'])) {
    echo "<main class='container'><p>Bitte <a href='login.php'>logge dich ein</a>, um deine Bestellungen zu sehen.</p></main>";
    include 'includes/footer.php';
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Verbindung zur Datenbank herstellen
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Query: Holt alle Bestellungen des angemeldeten Benutzers, sortiert nach der neuesten
    $stmt = $db->prepare("
        SELECT id AS order_id, total_price, status, created_at 
        FROM orders 
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$userId]);
    $myOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler beim Laden deiner Bestellungen: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Meine Bestellungen</h2>
    <p>Hier siehst du die Übersicht all deiner bisherigen Einkäufe bei Naimas Shop:</p>

    <?php if (empty($myOrders)): ?>
        <div style="background: white; padding: 30px; border-radius: 8px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <p style="font-size: 1.2rem; color: #7f8c8d;">Du hast bisher noch keine Bestellungen aufgegeben.</p>
            <a href="index.php" class="btn" style="background-color: #3498db;">Jetzt den ersten Einkauf tätigen</a>
        </div>
    <?php else: ?>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; height: 40px; color: #7f8c8d;">
                        <th>Bestell-Nummer</th>
                        <th>Datum / Uhrzeit</th>
                        <th>Gesamtsumme</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($myOrders as $order): ?>
                        <tr style="border-bottom: 1px solid #eee; height: 50px;">
                            <td style="font-weight: bold;">#<?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td style="font-weight: bold; color: #2c3e50;">CHF <?php echo number_format($order['total_price'], 2, '.', '\''); ?></td>
                            <td>
                                <?php if ($order['status'] === 'pending'): ?>
                                    <span style="background: #ffeaa7; color: #d63031; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem; font-weight: bold;">
                                        In Bearbeitung
                                    </span>
                                <?php else: ?>
                                    <span style="background: #e8f8f0; color: #2ecc71; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem; font-weight: bold;">
                                        <?php echo htmlspecialchars($order['status']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
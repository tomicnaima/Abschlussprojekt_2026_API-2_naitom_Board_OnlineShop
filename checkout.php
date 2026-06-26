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

// 1. Nur für eingeloggte User
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$totalPrice = 0;

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hol die Produkte aus dem Warenkorb für die Vorschau
    $stmt = $db->prepare("
        SELECT ci.quantity, p.name, p.price
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Wenn der Warenkorb leer ist, darf man nicht zur Kasse
    if (empty($cartItems)) {
        header("Location: cart.php");
        exit();
    }
} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Kasse / Bestellübersicht</h2>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 20px;">
        
        <div style="flex: 1; min-width: 300px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3>1. Lieferadresse</h3>
            <form action="place_order.php" method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 5px; font-weight: bold;">Vollständiger Name</label>
                    <input type="text" name="full_name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 5px; font-weight: bold;">Straße & Hausnummer</label>
                    <input type="text" name="address" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display:block; margin-bottom: 5px; font-weight: bold;">PLZ</label>
                        <input type="text" name="zip" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                    <div style="flex: 2;">
                        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Stadt</label>
                        <input type="text" name="city" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                </div>

                <button type="submit" class="btn" style="width: 100%; background-color: #2ecc71; border: none; padding: 15px; font-size: 1.1rem; cursor: pointer; border-radius: 6px;">
                    Zahlungspflichtig bestellen
                </button>
            </form>
        </div>

        <div style="flex: 1; min-width: 300px; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); height: fit-content;">
            <h3>2. Deine Artikel</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($cartItems as $item): 
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                ?>
                    <li style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <span><?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($item['name']); ?></span>
                        <!-- HIER AUF CHF GEÄNDERT -->
                        <span style="font-weight: bold;">CHF <?php echo number_format($itemTotal, 2, '.', '\''); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div style="display: flex; justify-content: space-between; margin-top: 20px; padding-top: 15px; border-top: 2px solid #333; font-size: 1.3rem; font-weight: bold;">
                <span>Gesamtsumme:</span>
                <span style="color: #e74c3c;">CHF <?php echo number_format($totalPrice, 2, '.', '\''); ?></span>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
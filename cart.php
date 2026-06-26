<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.3
 * Description: Warenkorb-Anzeige (Cart). Holt die Produkte des Users via SQL-JOIN 
 * mit korrekter 'image'-Spalte und listet die Preise in CHF auf.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

session_start();
include 'includes/header.php';

// 1. Sicherheitsschloss: Nur eingeloggte User dürfen ihren Warenkorb sehen
if (!isset($_SESSION['user_id'])) {
    echo "<main class='container'><p>Bitte <a href='login.php'>logge dich ein</a>, um deinen Warenkorb zu sehen.</p></main>";
    include 'includes/footer.php';
    exit();
}

$userId = $_SESSION['user_id'];
$totalPrice = 0;

try {
    // Verbindung zur Datenbank herstellen
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // HIER KORRIGIERT: p.image statt p.image_url im SELECT-Statement
    $stmt = $db->prepare("
        SELECT ci.id AS cart_item_id, ci.quantity, p.name, p.price, p.color, p.image, p.id AS product_id
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler beim Laden des Warenkorbs: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Dein Warenkorb</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: #2ecc71; font-weight: bold; background: #e8f8f0; padding: 10px; border-radius: 0px;">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </p>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div style="background: white; padding: 40px; border-radius: 0px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #eee;">
            <p style="font-size: 1.2rem; color: #777; margin-bottom: 25px;">Dein Warenkorb ist aktuell noch leer.</p>
            <a href="index.php" class="btn">Jetzt shoppen gehen</a>
        </div>
    <?php else: ?>
        <div style="background: white; padding: 25px; border-radius: 0px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow-x: auto; border: 1px solid #eee;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #111; height: 40px; color: #111; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;">
                        <th>Produkt</th>
                        <th>Name</th>
                        <th>Farbe</th>
                        <th>Anzahl</th>
                        <th>Einzelpreis</th>
                        <th>Gesamt</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalPrice += $itemTotal;
                    ?>
                        <tr style="border-bottom: 1px solid #eee; height: 90px;">
                            <td>
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #eee;">
                            </td>
                            <td style="font-weight: bold; color: #111;"><?php echo htmlspecialchars($item['name']); ?></td>
                            <td style="color: #555; text-transform: uppercase; font-size: 0.85rem;"><?php echo htmlspecialchars($item['color']); ?></td>
                            <td style="font-weight: bold;"><?php echo $item['quantity']; ?>x</td>
                            <td>CHF <?php echo number_format($item['price'], 2, '.', '\''); ?></td>
                            <td style="font-weight: bold; color: #FF69B4;">CHF <?php echo number_format($itemTotal, 2, '.', '\''); ?></td>
                            <td>
                                <form action="remove_from_cart.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 8px 14px; border-radius: 0px; cursor: pointer; font-weight: bold; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">
                                        Löschen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 30px; text-align: right; padding-top: 20px; border-top: 2px solid #111;">
                <h3 style="font-size: 1.5rem; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.05em;">Gesamtsumme: <span style="color: #FF69B4;">CHF <?php echo number_format($totalPrice, 2, '.', '\''); ?></span></h3>
                <a href="checkout.php" class="btn" style="padding: 16px 35px; font-size: 1rem;">Zur Kasse gehen &rarr;</a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
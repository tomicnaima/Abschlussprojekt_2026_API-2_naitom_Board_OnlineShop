<?php
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

    // SQL-Query: Holt die Cart-Items UND die passenden Infos aus der Products-Tabelle via JOIN
    $stmt = $db->prepare("
        SELECT ci.id AS cart_item_id, ci.quantity, p.name, p.price, p.color, p.image_url, p.id AS product_id
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
        <p style="color: #2ecc71; font-weight: bold; background: #e8f8f0; padding: 10px; border-radius: 4px;">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </p>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div style="background: white; padding: 30px; border-radius: 8px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <p style="font-size: 1.2rem; color: #7f8c8d;">Dein Warenkorb ist aktuell noch leer.</p>
            <a href="index.php" class="btn" style="background-color: #3498db;">Jetzt shoppen gehen</a>
        </div>
    <?php else: ?>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; height: 40px; color: #7f8c8d;">
                        <th>Produkt</th>
                        <th>Name</th>
                        <th>Farbe</th>
                        <th>Anzahl</th>
                        <th>Einzelpreis</th>
                        <th>Gesamt</th>
                        <th>Aktion</th> </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalPrice += $itemTotal;
                    ?>
                        <tr style="border-bottom: 1px solid #eee; height: 80px;">
                            <td>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="font-weight: bold;"><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['color']); ?></td>
                            <td><?php echo $item['quantity']; ?>x</td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td style="font-weight: bold; color: #2c3e50;"><?php echo number_format($itemTotal, 2, ',', '.'); ?> €</td>
                            <td>
                                <form action="remove_from_cart.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background 0.2s;">
                                        Löschen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 30px; text-align: right; padding-top: 20px; border-top: 2px solid #eee;">
                <h3 style="font-size: 1.5rem; margin-bottom: 20px;">Gesamtsumme: <span style="color: #e74c3c;"><?php echo number_format($totalPrice, 2, ',', '.'); ?> €</span></h3>
                <a href="checkout.php" class="btn" style="background-color: #2ecc71; padding: 15px 30px; font-size: 1.1rem; border-radius: 6px;">Zur Kasse gehen &rarr;</a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
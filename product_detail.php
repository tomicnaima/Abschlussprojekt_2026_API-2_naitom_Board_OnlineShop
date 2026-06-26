<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Produktdetailseite, die die Details eines einzelnen Produkts anzeigt und Empfehlungen für ähnliche Produkte in der gleichen Farbe bietet.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

session_start();
include 'includes/header.php';

// Hier wird das Hauptprodukt geladen (hast du schon so oder so ähnlich)
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hauptprodukt holen
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<main class='container'><p>Produkt nicht gefunden!</p></main>";
        include 'includes/footer.php';
        exit();
    }


    // ISSUE #16: EMPFEHLUNGEN HOLEN
    //  mit der GLEICHEN Farbe, schliessen aber das aktuelle Produkt aus (id != ?)
    // Mit LIMIT 3 begrenzen wir die Vorschläge auf maximal 3 Artikel
    $recommendStmt = $db->prepare("SELECT * FROM products WHERE color = ? AND id != ? LIMIT 3");
    $recommendStmt->execute([$product['color'], $product['id']]);
    $recommendedProducts = $recommendStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>

<main class="container">
    <!-- Hier normale Produkt-Detailansicht -->
    <div style="display: flex; gap: 40px; margin-bottom: 50px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="flex: 1;">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px;">
        </div>
        <div style="flex: 1;">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p style="color: #7f8c8d; font-style: italic;">Farbe: <?php echo htmlspecialchars($product['color']); ?></p>
            <p style="font-size: 1.2rem; margin: 20px 0;"><?php echo htmlspecialchars($product['description']); ?></p>
            <h3 style="color: #e74c3c; font-size: 1.8rem;">CHF <?php echo number_format($product['price'], 2, '.', '\''); ?></h3>
            
            <form action="add_to_cart.php" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 8px; margin-right: 10px;">
                <button type="submit" class="btn" style="background: #3498db; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">In den Warenkorb</button>
            </form>
        </div>
    </div>

    <!-- LOGIK FÜR ISSUE #17: EMPFEHLUNGEN ANZEIGEN -->
    <hr style="border: 0; height: 1px; background: #eee; margin: 40px 0;">
    
    <h3>Das könnte dir auch gefallen (Ähnliche Produkte in <?php echo htmlspecialchars($product['color']); ?>):</h3>
    
    <?php if (empty($recommendedProducts)): ?>
        <p style="color: #7f8c8d;">Aktuell keine ähnlichen Produkte in dieser Farbe verfügbar.</p>
    <?php else: ?>
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
            <?php foreach ($recommendedProducts as $recProduct): ?>
                <div style="flex: 1; min-width: 200px; max-width: 250px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                    <img src="<?php echo htmlspecialchars($recProduct['image']); ?>" alt="" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
                    <h4 style="margin: 5px 0;"><?php echo htmlspecialchars($recProduct['name']); ?></h4>
                    <p style="color: #e74c3c; font-weight: bold; margin-bottom: 10px;">CHF <?php echo number_format($recProduct['price'], 2, '.', '\''); ?></p>
                    <a href="product_detail.php?id=<?php echo $recProduct['id']; ?>" style="display: block; background: #f3f3f3; color: #333; padding: 8px; text-decoration: none; border-radius: 4px; font-size: 0.9rem;">Ansehen</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.3
 * Description: Das ist die Hauptseite des OnlineShops. Zeigt die Produktübersicht 
 * mit korrekten Bildpfaden und neuem Hero-Design an.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Session starten, falls wir später den Warenkorb brauchen
session_start();

include 'includes/header.php';

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Produkte aus der Datenbank abfragen
    $stmt = $db->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fehler beim Laden der Produkte: " . $e->getMessage();
    $products = [];
}
?>

<main class="container">
    <section class="hero" style="background: linear-gradient(135deg, #111111 0%, #222222 100%); text-align: center; padding: 80px 20px; border-bottom: 5px solid #FF69B4; margin-bottom: 40px;">
        <h1 style="font-size: 3rem; font-weight: 900; text-transform: uppercase; color: #FF69B4; margin: 0 0 10px 0; letter-spacing: 0.05em;">Willkommen in Naima's Webshop</h1>
        <p style="font-size: 1.2rem; color: #cccccc; max-width: 600px; margin: 0 auto; text-transform: uppercase; font-weight: 600; letter-spacing: 0.03em;">Entdecke die neuesten Trends und exklusive Streetwear.</p>
    </section>

    <h2 style="text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 30px; border-bottom: 2px solid #111; padding-bottom: 10px; display: inline-block;">Unsere Produkte</h2>
    
    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p>Aktuell sind keine Produkte verfügbar.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-color">Farbe: <?php echo htmlspecialchars($product['color']); ?></p>
                        <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="product-price">CHF <?php echo number_format($product['price'], 2, '.', '\''); ?></p>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn">Details ansehen</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php
// Footer einbinden
include 'includes/footer.php';
?>
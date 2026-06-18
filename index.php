<?php
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
    <section class="hero">
        <h1>Willkommen in Naimas Shop</h1>
        <p>Entdecke die neuesten Trends und exklusive Streetwear.</p>
    </section>

    <h2>Unsere Produkte</h2>
    
    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p>Aktuell sind keine Produkte verfügbar.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-color">Farbe: <?php echo htmlspecialchars($product['color']); ?></p>
                        <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="product-price"><?php echo number_format($product['price'], 2, ',', '.'); ?> €</p>
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
<?php
session_start();
include 'includes/header.php';

// Prüfen, ob eine Produkt-ID in der URL übergeben wurde
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$productId = intval($_GET['id']);

try {
    // Verbindung zur Datenbank
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Genau das eine Produkt auslesen
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Wenn das Produkt nicht existiert
    if (!$product) {
        echo "<main class='container'><p>Produkt nicht gefunden.</p><a href='index.php' class='btn'>Zurück zum Shop</a></main>";
        include 'includes/footer.php';
        exit();
    }
} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>

<main class="container">
    <div style="display: flex; flex-wrap: wrap; gap: 40px; margin-top: 30px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <div style="flex: 1; min-width: 300px;">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px;">
        </div>
        
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; justify-content: center;">
            <a href="index.php" style="color: #3498db; text-decoration: none; margin-bottom: 20px; display: inline-block;">&larr; Zurück zur Übersicht</a>
            
            <h1 style="margin: 0 0 10px 0; font-size: 2.5rem;"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p style="font-size: 1.1rem; color: #7f8c8d; margin-bottom: 20px;">Farbe: <strong><?php echo htmlspecialchars($product['color']); ?></strong></p>
            
            <p style="font-size: 1.2rem; line-height: 1.6; color: #34495e; margin-bottom: 30px;">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>
            
            <p style="font-size: 2rem; font-weight: bold; color: #e74c3c; margin-bottom: 30px;">
                <?php echo number_format($product['price'], 2, ',', '.'); ?> €
            </p>
            
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; margin-right: 10px;">Anzahl:</label>
                    <input type="number" name="quantity" value="1" min="1" max="10" style="width: 60px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; text-align: center;">
                </div>
                <button type="submit" class="btn" style="border: none; padding: 15px 30px; font-size: 1.1rem; cursor: pointer; background-color: #e67e22;">
                    In den Warenkorb legen
                </button>
            </form>
        </div>
        
    </div>
</main>

<?php include 'includes/footer.php'; ?>
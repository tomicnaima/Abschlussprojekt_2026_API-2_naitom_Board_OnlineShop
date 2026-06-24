<?php
session_start();
include 'includes/header.php';

//  Nur für Admins
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "<main class='container'><p style='color:red; font-weight:bold;'>Zugriff verweigert! Du bist kein Admin.</p></main>";
    include 'includes/footer.php';
    exit();
}

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ==========================================
    // LOGIK FÜR ISSUE #8: PRODUKT ERSTELLEN (hier ai für hilfe benutzt)
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $color = trim($_POST['color']);
        $image = trim($_POST['image']); // Pfad zum Bild, z.B. images/sneaker.jpg

        if (!empty($name) && $price > 0) {
            $insertStmt = $db->prepare("INSERT INTO products (name, description, price, color, image) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->execute([$name, $description, $price, $color, $image]);
            echo "<p style='color:green; font-weight:bold; text-align:center;'>Produkt erfolgreich hinzugefügt!</p>";
        }
    }


    // PRODUKT LÖSCHEN
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $productId = intval($_POST['product_id']);
        
        $deleteStmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $deleteStmt->execute([$productId]);
        echo "<p style='color:red; font-weight:bold; text-align:center;'>Produkt gelöscht!</p>";
    }

    // ALLE PRODUKTE LADEN (ANZEIGEN)
    $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Admin-Bereich: Produktverwaltung</h2>

    <!-- FORMULAR: NEUES PRODUKT HINZUFÜGEN (issue 8) -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <h3>Neues Produkt hinzufügen</h3>
        <form action="admin_products.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="action" value="create">
            
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Produktname</label>
                <input type="text" name="name" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Beschreibung</label>
                <textarea name="description" rows="3" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"></textarea>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Preis (€)</label>
                    <input type="number" step="0.01" name="price" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Farbe</label>
                    <input type="text" name="color" placeholder="z.B. rot, blau, schwarz" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
            </div>

            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Bild-Pfad</label>
                <input type="text" name="image" value="images/sneaker.jpg" placeholder="images/produktname.jpg" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <button type="submit" class="btn" style="background:#2ecc71; color:white; border:none; padding:10px; font-size:1rem; cursor:pointer; border-radius:4px;">
                Produkt speichern
            </button>
        </form>
    </div>

    <hr style="border: 0; height: 1px; background: #eee; margin: 40px 0;">

    <!-- TABELLE: VORHANDENE PRODUKTE ANZEIGEN & LÖSCHEN  -->
    <h3>Alle Produkte im Shop</h3>
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #eee; height: 40px; color: #7f8c8d;">
                    <th>Bild</th>
                    <th>Name</th>
                    <th>Farbe</th>
                    <th>Preis</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr style="border-bottom: 1px solid #eee; height: 60px;">
                        <td>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td style="font-weight: bold;"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['color']); ?></td>
                        <td style="font-weight: bold;"><?php echo number_format($product['price'], 2, ',', '.'); ?> €</td>
                        <td>
                            <!-- Löschen Button als Mini-Formular -->
                            <form action="admin_products.php" method="POST" onsubmit="return confirm('Produkt wirklich löschen?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px;">
                                    Löschen
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
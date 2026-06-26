<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.4
 * Description: Admin-Produktverwaltung (CRUD). Erstellt die 'image'-Spalte 
 * automatisch, falls sie in der SQLite-Datenbank fehlt.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

session_start();
include 'includes/header.php';

// Nur für Admins
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "<main class='container'><p style='color:red; font-weight:bold;'>Zugriff verweigert! Du bist kein Admin.</p></main>";
    include 'includes/footer.php';
    exit();
}

$editProduct = null;

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // AUTOMATISCHER DATENBANK-CHECK: Prüfen ob die Spalte 'image' existiert
    $checkColumn = $db->query("PRAGMA table_info(products)")->fetchAll(PDO::FETCH_ASSOC);
    $hasImageColumn = false;
    foreach ($checkColumn as $column) {
        if ($column['name'] === 'image') {
            $hasImageColumn = true;
            break;
        }
    }

    // Wenn die Spalte fehlt, fügen wir sie jetzt automatisch hinzu!
    if (!$hasImageColumn) {
        $db->exec("ALTER TABLE products ADD COLUMN image TEXT DEFAULT 'images/sneaker.jpg'");
    }

    // ==========================================
    // 1. PRODUKT ERSTELLEN
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $color = trim($_POST['color']);
        $image = trim($_POST['image']); 

        if (!empty($name) && $price > 0) {
            $insertStmt = $db->prepare("INSERT INTO products (name, description, price, color, image) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->execute([$name, $description, $price, $color, $image]);
            echo "<p style='color:green; font-weight:bold; text-align:center; margin-top:20px;'>Produkt erfolgreich hinzugefügt!</p>";
        }
    }

    // ==========================================
    // 2. PRODUKT AKTUALISIEREN (UPDATE)
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $productId = intval($_POST['product_id']);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $color = trim($_POST['color']);
        $image = trim($_POST['image']);

        if (!empty($name) && $price > 0) {
            $updateStmt = $db->prepare("UPDATE products SET name = ?, description = ?, price = ?, color = ?, image = ? WHERE id = ?");
            $updateStmt->execute([$name, $description, $price, $color, $image, $productId]);
            echo "<p style='color:green; font-weight:bold; text-align:center; margin-top:20px;'>Produkt erfolgreich aktualisiert!</p>";
        }
    }

    // ==========================================
    // 3. PRODUKT LÖSCHEN
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $productId = intval($_POST['product_id']);
        
        $deleteStmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $deleteStmt->execute([$productId]);
        echo "<p style='color:red; font-weight:bold; text-align:center; margin-top:20px;'>Produkt gelöscht!</p>";
    }

    // ==========================================
    // 4. PRÜFEN OB EIN PRODUKT BEARBEITET WERDEN SOLL
    // ==========================================
    if (isset($_GET['edit_id'])) {
        $editId = intval($_GET['edit_id']);
        $editStmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $editStmt->execute([$editId]);
        $editProduct = $editStmt->fetch(PDO::FETCH_ASSOC);
    }

    // ALLE PRODUKTE FÜR DIE TABELLE LADEN
    $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>

<main class="container">
    <h2>Admin-Bereich: Produktverwaltung</h2>

    <div style="background: white; padding: 30px; border-radius: 0px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 40px; border: 1px solid #eee;">
        <h3><?= $editProduct ? 'Produkt bearbeiten' : 'Neues Produkt hinzufügen' ?></h3>
        
        <form action="admin_products.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="action" value="<?= $editProduct ? 'update' : 'create' ?>">
            <?php if ($editProduct): ?>
                <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
            <?php endif; ?>
            
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Produktname</label>
                <input type="text" name="name" required value="<?= $editProduct ? htmlspecialchars($editProduct['name']) : '' ?>" style="width:100%; padding:10px; border:1px solid #ccc; box-sizing:border-box;">
            </div>
            
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Beschreibung</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #ccc; box-sizing:border-box;"><?= $editProduct ? htmlspecialchars($editProduct['description']) : '' ?></textarea>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Preis (CHF)</label>
                    <input type="number" step="0.01" name="price" required value="<?= $editProduct ? htmlspecialchars($editProduct['price']) : '' ?>" style="width:100%; padding:10px; border:1px solid #ccc; box-sizing:border-box;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Farbe</label>
                    <input type="text" name="color" value="<?= $editProduct ? htmlspecialchars($editProduct['color']) : '' ?>" placeholder="z.B. rot, blau, schwarz" style="width:100%; padding:10px; border:1px solid #ccc; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Bild-Pfad / Dateiname</label>
                <input type="text" name="image" value="<?= $editProduct ? htmlspecialchars($editProduct['image']) : 'images/sneaker.jpg' ?>" style="width:100%; padding:10px; border:1px solid #ccc; box-sizing:border-box;">
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit" class="btn">
                    <?= $editProduct ? 'Änderungen speichern' : 'Produkt speichern' ?>
                </button>
                <?php if ($editProduct): ?>
                    <a href="admin_products.php" style="color: #777; text-decoration: none; font-size: 0.9rem; font-weight: bold; text-transform: uppercase;">Abbrechen</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <hr style="border: 0; height: 1px; background: #eee; margin: 40px 0;">

    <h3>Alle Produkte im Shop</h3>
    <div style="background: white; padding: 25px; border-radius: 0px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow-x: auto; border: 1px solid #eee;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #111; height: 40px; color: #111; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;">
                    <th>Bild</th>
                    <th>Name</th>
                    <th>Farbe</th>
                    <th>Preis</th>
                    <th style="text-align: right;">Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr style="border-bottom: 1px solid #eee; height: 70px;">
                        <td>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #eee;">
                        </td>
                        <td style="font-weight: bold; color: #111;"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td style="color: #555; text-transform: uppercase; font-size: 0.85rem;"><?php echo htmlspecialchars($product['color']); ?></td>
                        <td style="font-weight: bold; color: #FF69B4;">CHF <?php echo number_format($product['price'], 2, '.', '\''); ?></td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 10px; justify-content: flex-end;">
                                <a href="admin_products.php?edit_id=<?php echo $product['id']; ?>" style="background: #333; color: white; text-decoration: none; padding: 8px 14px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Bearbeiten
                                </a>
                                <form action="admin_products.php" method="POST" onsubmit="return confirm('Produkt wirklich löschen?');" style="margin: 0;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 8px 14px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer;">
                                        Löschen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<?php
session_start();

// Sicherheitsschloss: Nur für eingeloggte User
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    
    // Adresse auffangen (könnte man später in der DB speichern, hier nutzen wir sie für die Logik)
    $fullName = trim($_POST['full_name']);
    $address = trim($_POST['address']);
    $zip = trim($_POST['zip']);
    $city = trim($_POST['city']);

    try {
        $db = new PDO('sqlite:database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Warenkorb-Artikel holen, um den Gesamtpreis zu berechnen
        $stmt = $db->prepare("
            SELECT ci.quantity, p.price, p.id AS product_id
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.user_id = ?
        ");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cartItems)) {
            header("Location: cart.php");
            exit();
        }

        // Gesamtpreis berechnen
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Datenbank-Transaktion starten (Sicherheit: Entweder alles klappt oder nichts!)
        $db->beginTransaction();

        // In die Tabelle orders eintragen
        $insertOrderStmt = $db->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
        $insertOrderStmt->execute([$userId, $totalPrice]);
        
        // Die gerade generierte Order-ID holen
        $orderId = $db->lastInsertId();

        // Alle Artikel in `order_items` übertragen
        $insertItemsStmt = $db->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
        foreach ($cartItems as $item) {
            $insertItemsStmt->execute([
                $orderId,
                $item['product_id'],
                $item['price'],
                $item['quantity']
            ]);
        }

        // Warenkorb leeren
        $deleteCartStmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $deleteCartStmt->execute([$userId]);

        // speichern!
        $db->commit();

        // Weiterleitung zur Bestätigungsseite
        header("Location: index.php?success=Vielen Dank für deine Bestellung! Deine Bestellnummer lautet: #" . $orderId);
        exit();

    } catch (PDOException $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        die("Fehler bei der Bestellung: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
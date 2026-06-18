<?php
session_start();

// Prüfen ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    // Wenn nicht eingeloggt, ab zur Login-Seite mit einer Warnung
    header("Location: login.php?error=Bitte logge dich zuerst ein, um Produkte in den Warenkorb zu legen.");
    exit();
}

// Prüfen ob Daten per POST geschickt wurden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($productId > 0 && $quantity > 0) {
        try {
            // Verbindung zur Datenbank
            $db = new PDO('sqlite:database.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prüfen, ob dieses Produkt von diesem User bereits im Warenkorb liegt
            $stmt = $db->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Wenn es schon existiert, erhöhen wir einfach die Menge
                $newQuantity = $existingItem['quantity'] + $quantity;
                $updateStmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                $updateStmt->execute([$newQuantity, $existingItem['id']]);
            } else {
                // Wenn es neu ist, legen wir einen neuen Eintrag an
                $insertStmt = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insertStmt->execute([$userId, $productId, $quantity]);
            }

            // leitet den User zurück zur Detailseite mit einer Erfolgsmeldung
            header("Location: cart.php?success=Produkt wurde in den Warenkorb gelegt!");
            exit();

        } catch (PDOException $e) {
            die("Fehler beim Hinzufügen zum Warenkorb: " . $e->getMessage());
        }
    }
}

// Falls irgendwas schiefgelaufen ist oder die Datei falsch aufgerufen wurde, zurück zum Shop
header("Location: index.php");
exit();


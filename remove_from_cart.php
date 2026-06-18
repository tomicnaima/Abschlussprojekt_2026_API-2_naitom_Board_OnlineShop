<?php
session_start();

// Prüft ob der Nutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Prüft ob eine gültige Cart-Item-ID übergeben wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_item_id'])) {
    $cartItemId = intval($_POST['cart_item_id']);
    $userId = $_SESSION['user_id'];

    try {
        // Verbindung zur Datenbank
        $db = new PDO('sqlite:database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sicherstellen, dass das Item auch wirklich diesem User gehört (Sicherheit!)
        $stmt = $db->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
        $stmt->execute([$cartItemId, $userId]);

        // Zurück zum Warenkorb leiten mit einer Erfolgsmeldung
        header("Location: cart.php?success=Produkt wurde aus dem Warenkorb entfernt.");
        exit();

    } catch (PDOException $e) {
        die("Fehler beim Löschen des Produkts: " . $e->getMessage());
    }
}

// Falls die Datei falsch aufgerufen wurde
header("Location: cart.php");
exit();
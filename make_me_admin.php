<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Datenbank-Migrationsskript. Fügt der Tabelle 'products' nachträglich 
 * die Spalte 'image' für Produktbild-Dateipfade hinzu.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Befördert naima@gmail.com zum Admin
    $stmt = $db->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
    $stmt->execute(['naima@gmail.com']);

    echo "<h2 style='color:green;'>Erfolg! Du wurdest in der Datenbank zum Admin befördert. 🚀</h2>";
    echo "<p>Bitte logge dich jetzt im Shop kurz <strong>aus und wieder ein</strong>, damit dein neuer Admin-Status aktiv wird!</p>";
    echo "<p><a href='index.php'>Zurück zur Startseite</a></p>";

} catch (PDOException $e) {
    echo "<h3 style='color:orange;'>Fehler beim Zuweisen der Admin-Rechte:</h3> " . $e->getMessage();
    echo "<p><a href='index.php'>Zurück zur Startseite</a></p>";
}
?>
<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Setup-Skript für die SQLite-Datenbank des OnlineShops. Erstellt die notwendigen Tabellen und fügt Testdaten ein.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Verbindung zur SQLite-Datenbankdatei herstellen
try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Starte Datenbank-Setup...<br>";

    // Erstellen der Tabellen, falls nicht vorhanden
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT DEFAULT 'customer',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            price REAL NOT NULL,
            color TEXT NOT NULL,
            image_url TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS cart_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            total_price REAL NOT NULL,
            status TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            price REAL NOT NULL,
            quantity INTEGER NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        );
    ");

    echo "Alle 5 Tabellen wurden erfolgreich überprüft/erstellt.<br>";

    // Wir leeren die Tabelle, um die sauberen Schweizer Testdaten mit Empfehlungs-Matches zu erzwingen
    $db->exec("DELETE FROM products");

    echo "Füge Test-Produkte mit Schweizer Rechtschreibung (ss) und passenden Farben für die Empfehlungen hinzu...<br>";
    
    // Hier sind perfekt abgestimmte Testdaten (2x weiss, 2x schwarz), damit der Farb-Filter anschlägt!
    $insertProducts = [
        [
            'name' => 'Retro Sneaker White',
            'description' => 'Klassischer Sneaker im 90er Look. Extrem bequem, komplett in modernem Weiss.',
            'price' => 129.90,
            'color' => 'weiss',
            'image_url' => 'images/sneaker.jpg'
        ],
        [
            'name' => 'Streetwear Hoodie White',
            'description' => 'Oversized Hoodie aus 100% Bio-Baumwolle. Passt farblich perfekt zu weissen Sneakern.',
            'price' => 79.90,
            'color' => 'weiss',
            'image_url' => 'images/hoodie.jpg'
        ],
        [
            'name' => 'Streetwear Hoodie Black',
            'description' => 'Klassischer, schwerer Hoodie in tiefem Schwarz. Hält perfekt warm.',
            'price' => 79.90,
            'color' => 'schwarz',
            'image_url' => 'images/hoodie.jpg'
        ],
        [
            'name' => 'Urban Cap Black',
            'description' => 'Verstellbare Basecap im minimalistischen, schwarzen Design.',
            'price' => 24.90,
            'color' => 'schwarz',
            'image_url' => 'images/cap.jpg'
        ]
    ];

    $insertStmt = $db->prepare("INSERT INTO products (name, description, price, color, image_url) VALUES (:name, :description, :price, :color, :image_url)");
    
    foreach ($insertProducts as $p) {
        $insertStmt->execute([
            ':name' => $p['name'],
            ':description' => $p['description'],
            ':price' => $p['price'],
            ':color' => $p['color'],
            ':image_url' => $p['image_url']
        ]);
    }
    
    echo "4 Test-Produkte erfolgreich eingefügt (Farben: weiss & schwarz)!<br>";
    echo "<strong>Setup abgeschlossen!</strong>";
    echo "<p><a href='index.php'>Direkt zum Shop und testen!</a></p>";

} catch (PDOException $e) {
    die("Fehler beim Setup: " . $e->getMessage());
}
?>
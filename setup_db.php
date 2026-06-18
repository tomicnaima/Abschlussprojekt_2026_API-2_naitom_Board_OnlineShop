<?php
// Verbindung zur SQLite-Datenbankdatei herstellen
$db = new PDO('sqlite:database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Starte Datenbank-Setup...<br>";

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

// OPTIONAL: Löscht alte Testprodukte mit Unsplash-Verlinkung, damit wir die neuen lokalen Pfade erzwingen
$db->exec("DELETE FROM products");

// Test-Produkte einfügen, falls die Tabelle leer ist (oder wir sie gerade geleert haben)
$stmt = $db->query("SELECT COUNT(*) FROM products");
$productCount = $stmt->fetchColumn();

if ($productCount == 0) {
    echo "Füge Test-Produkte mit lokalen Bildpfaden hinzu...<br>";
    
    $insertProducts = [
        [
            'name' => 'Retro Sneaker',
            'description' => 'Klassischer Sneaker im 90er Look. Extrem bequem und stylisch.',
            'price' => 129.99,
            'color' => 'Weiss/Pink',
            'image_url' => 'images/sneaker.jpg'
        ],
        [
            'name' => 'Streetwear Hoodie',
            'description' => 'Oversized Hoodie aus 100% Bio-Baumwolle. Hält perfekt warm.',
            'price' => 79.95,
            'color' => 'Schwarz/Grün',
            'image_url' => 'images/hoodie.jpg'
        ],
        [
            'name' => 'Urban Cap',
            'description' => 'Verstellbare Basecap im minimalistischen Design.',
            'price' => 24.99,
            'color' => 'Dunkelblau',
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
    echo "3 Test-Produkte erfolgreich mit den lokalen Bildpfaden eingefügt!<br>";
} else {
    echo "Produkte existieren bereits, überspringe Einfügen.<br>";
}

echo "<strong>Setup abgeschlossen!</strong>";
?>
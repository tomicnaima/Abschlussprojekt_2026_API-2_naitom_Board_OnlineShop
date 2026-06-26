<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.1
 * Description: Header-Datei, die in allen Seiten eingebunden wird und die Navigation enthält.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Session nur starten, wenn sie nicht schon läuft
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Abschlussprojekt: Naima's Shop</title>
    <link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<header>
    <h1>Abschlussprojekt: Naima's Shop</h1>
</header>

<?php include 'includes/navbar.php'; ?>

<main>
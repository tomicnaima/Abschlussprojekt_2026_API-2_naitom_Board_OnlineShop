<?php
// Session nur starten, wenn sie nicht schon läuft
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Abschlussprojekt</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>Abschlussprojekt</h1>
</header>

<?php include 'navbar.php'; ?>

<main>
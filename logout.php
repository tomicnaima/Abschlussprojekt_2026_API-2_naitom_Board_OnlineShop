<?php
// Session starten, um Zugriff darauf zu haben
session_start();

// Alle Session-Variablen löschen
$_SESSION = array();

// Die Session komplett zerstören
session_destroy();

// Den User automatisch zur Startseite (oder Login) zurückschicken
header("Location: index.php");
exit;
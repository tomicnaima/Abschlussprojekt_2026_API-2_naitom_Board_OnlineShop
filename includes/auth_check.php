<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Funktion, um eine Seite NUR für Admins zu erlauben
function checkAdmin() {
    // Wenn nicht eingeloggt ODER die Rolle nicht admin ist
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        // Schicke den User weg (z.B. zum Login oder zur Startseite)
        header("Location: login.php");
        exit;
    }
}

// eine Seite NUR für eingeloggte Kunden/User zu erlauben
function checkLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}
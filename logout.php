<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Kunden-Bestellübersicht in CHF mit tabellarischer Auflistung.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Session starten, um Zugriff darauf zu haben
session_start();

// Alle Session-Variablen löschen
$_SESSION = array();

// Die Session komplett zerstören
session_destroy();

// Den User automatisch zur Startseite (oder Login) zurückschicken
header("Location: index.php");
exit;
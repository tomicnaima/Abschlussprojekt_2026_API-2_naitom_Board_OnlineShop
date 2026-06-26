<?php
/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.3
 * Description: Dynamisches Benutzer-Dashboard. Zeigt den Namen und die tatsächliche 
 * Rolle des Benutzers live aus der Session an.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Schutz-Funktionen laden
require_once 'includes/auth_check.php';

// Schutz aktivieren: Nur eingeloggte User dürfen hier hin
checkLoggedIn(); 
?>

<?php include 'includes/header.php'; ?>

<main class="container">
    <h2>Dein Dashboard</h2>
    <p>Hallo <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>!</p>
    
    <p>Du bist erfolgreich eingeloggt. Deine Rolle im Shop ist: <strong style="text-transform: uppercase; color: #FF69B4;"><?php echo htmlspecialchars($_SESSION['user_role']); ?></strong></p>
    
    <div style="margin-top: 30px; background: white; padding: 20px; border-radius: 0px; border: 1px solid #eee; border-left: 4px solid #FF69B4; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <p style="margin: 0; font-size: 1.1rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em;">
            🛒 <a href="my_orders.php" style="color: #111; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#FF69B4'" onmouseout="this.style.color='#111'">Meine Bestellungen ansehen</a>
        </p>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
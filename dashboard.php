<?php
// Schutz-Funktionen laden
require_once 'includes/auth_check.php';

// Schutz aktivieren: Nur eingeloggte User dürfen hier hin
checkLoggedIn(); 
?>

<!-- Hier kommt das normale Layout, wenn der User den Schutz-Check bestanden hat -->
<?php include 'includes/header.php'; ?>

<div class="dashboard-container">
    <h2>Dein Dashboard</h2>
    <p>Hallo <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>!</p>
    <p>Du bist erfolgreich eingeloggt. Deine Rolle im Shop ist: <u><?php echo htmlspecialchars($_SESSION['user_role']); ?></u></p>
    
    <div class="dashboard-content">
        <p>Hier wirst du bald deine Bestellungen sehen können.</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
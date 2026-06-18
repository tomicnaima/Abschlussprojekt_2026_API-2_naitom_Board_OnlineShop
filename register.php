<?php 
session_start(); 
include 'includes/header.php'; 

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
}

$message = '';
$success = false; // Variable, um zu prüfen, ob die Registrierung geklappt hat

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $message = "Bitte alle Felder ausfüllen.";
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $message = "E-Mail bereits vergeben.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            $message = "Registrierung erfolgreich!";
            $success = true; // Registrierung war erfolgreich!
        }
    }
}
?>

<main class="container">
    <div style="max-width: 400px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <h2>Registrierung</h2>

        <?php if ($message): ?>
            <!-- Färbt die Nachricht grün bei Erfolg, rot bei Fehlern -->
            <p style="color: <?php echo $success ? '#2ecc71' : '#e74c3c'; ?>; font-weight: bold;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- Wenn erfolgreich, zeige den Button zum Login anstelle des Formulars -->
        <?php if ($success): ?>
            <p>Du kannst dich jetzt mit deinem Account einloggen:</p>
            <a href="login.php" class="btn" style="display: block; text-align: center;">Jetzt zum Login</a>
        <?php else: ?>
            
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 5px; font-weight: bold;">Benutzername</label>
                    <input type="text" name="username" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 5px; font-weight: bold;">E-Mail</label>
                    <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom: 5px; font-weight: bold;">Passwort</label>
                    <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <button type="submit" class="btn" style="width: 100%; border: none; cursor: pointer;">
                    Registrieren
                </button>
            </form>
            
            <p style="margin-top: 15px; text-align: center; font-size: 0.9rem;">
                Bereits ein Konto? <a href="login.php" style="color: #3498db;">Hier einloggen</a>
            </p>
        <?php endif; ?>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
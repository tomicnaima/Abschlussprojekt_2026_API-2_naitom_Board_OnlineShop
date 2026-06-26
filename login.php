<?php

/**
 * Author: Naima Tomic
 * Date: 2026-06-25
 * Version: 1.2
 * Description: Kunden-Bestellübersicht in CHF mit tabellarischer Auflistung.
 * Project: Individuelles Abschlussprojekt BLJ - OnlineShop
 */

// Session starten, damit der Server sich merkt, wer eingeloggt ist
session_start();

// Wenn der User schon eingeloggt ist, schicken wir ihn direkt zur Startseite
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Prüfen ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            // Verbindung zur SQLite-Datenbank herstellen
            $db = new PDO("sqlite:database.sqlite");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Nach dem User mit dieser E-Mail suchen
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Wenn ein User gefunden wurde und das Passwort stimmt
            if ($user && password_verify($password, $user['password'])) {
                
                // Wichtige Daten in der Session speichern
                $_SESSION['user_id'] = $user['id'];
                
                // Falls deine Spalte in der Datenbank 'username' heisst, nutzen wir das, sonst 'name'
                $_SESSION['user_name'] = isset($user['username']) ? $user['username'] : (isset($user['name']) ? $user['name'] : 'User');
                
                // Hier wird die Rolle (admin oder customer) aus der DB in die Session geladen
                $_SESSION['user_role'] = $user['role']; 

                header("Location: index.php");
                exit;
            } else {
                $error = "E-Mail oder Passwort falsch!";
            }

        } catch (PDOException $e) {
            $error = "Datenbank-Fehler: " . $e->getMessage();
        }
    } else {
        $error = "Bitte alle Felder ausfüllen!";
    }
}

include 'includes/header.php'; 
?>

<main class="container">
    <div class="login-container" style="max-width: 400px; margin: 40px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2>Einloggen</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <div class="form-group">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">E-Mail-Adresse:</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Passwort:</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            </div>

            <button type="submit" class="btn" style="width: 100%; border: none; cursor: pointer;">
                Login
            </button>
        </form>

        <p style="margin-top: 15px; text-align: center; font-size: 0.9rem;">
            Noch kein Konto? <a href="register.php" style="color: #FF69B4;">Hier registrieren</a>
        </p>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
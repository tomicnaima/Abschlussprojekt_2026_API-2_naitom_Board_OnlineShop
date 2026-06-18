<?php
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
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role']; // Damit wir wissen, ob es ein Admin oder Kunde ist

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
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login OnlineShop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="login-container">
        <h2>Einloggen</h2>

        <!-- Wenn es einen Fehler gibt, hier angezeigt-->
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>E-Mail-Adresse:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Passwort:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p>Noch kein Konto? <a href="register.php">Hier registrieren</a></p>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
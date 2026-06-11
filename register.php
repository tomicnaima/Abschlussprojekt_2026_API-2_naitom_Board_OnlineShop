<?php

$db = new PDO('sqlite:database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {

        $message = "Bitte alle Felder ausfüllen.";

    } else {

        $stmt = $db->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $message = "E-Mail bereits vergeben.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $db->prepare(
                "INSERT INTO users
                (username, email, password)
                VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $username,
                $email,
                $hashedPassword
            ]);

            $message = "Registrierung erfolgreich!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
</head>
<body>

<h2>Registrierung</h2>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">

    <label>Benutzername</label><br>
    <input type="text" name="username"><br><br>

    <label>E-Mail</label><br>
    <input type="email" name="email"><br><br>

    <label>Passwort</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">
        Registrieren
    </button>

</form>

</body>
</html>
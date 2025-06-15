<?php
include 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Wszystkie pola są wymagane.";
    } elseif ($password !== $confirm) {
        $errors[] = "Hasła nie są takie same.";
    } else {
        // Перевірка чи існує вже ім'я користувача
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = "Nazwa użytkownika już istnieje.";
        }

        // Перевірка чи існує вже email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Adres e-mail już jest używany.";
        }

        // Якщо немає помилок - додаємо користувача
        if (empty($errors)) {
            $hashed = hash('sha256', $password);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);
            $success = "Rejestracja zakończona sukcesem. <a href='login.php'>Zaloguj się tutaj</a>.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
form {
  background: rgba(255, 255, 255, 0.05);  /* Прозорий білий */
  padding: 30px;
  border-radius: 16px;
  box-shadow: 0 0 30px rgba(0,0,0,0.2);
  color: white;
  width: 100%;
  max-width: 400px;
  margin: auto;
}
    </style>
</head>
<body class="home">
      <video autoplay muted loop class="video-bg">
        <source src="assets/videos/background.mp4" type="video/mp4">
        Twoja przeglądarka nie obsługuje wideo.
    </video>
    <div class="overlay"></div>
    <a class="panel" href="index.php">Główna</a>
  <a class="panel_02" href="missions.php">Misji</a>
    <div class="login-wrapper">
        <div class="login-box">
            <h1>📝 Rejestracja</h1>

            <?php if ($errors): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <p style="color: #aaffaa;"><?= $success ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Nazwa użytkownika:
                    <input type="text" name="username" placeholder="Wpisz nazwę" required>
                </label>

                <label>Adres e-mail:
                    <input type="email" name="email" placeholder="Wpisz email" required>
                </label>

                <label>Hasło:
                    <input type="password" name="password" placeholder="••••••••" required>
                </label>

                <label>Powtórz hasło:
                    <input type="password" name="confirm" placeholder="••••••••" required>
                </label>

                <button type="submit">Zarejestruj się</button>
            </form>

            <p><a href="index.php">⬅️ Powrót do strony głównej</a></p>
        </div>
    </div>
</body>
</html>

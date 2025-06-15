<?php 
session_start();
include 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $errors[] = "Wszystkie pola są wymagane.";
    } else {
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && hash('sha256', $password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role']; 
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Nieprawidłowa nazwa użytkownika lub hasło.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
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

input[type="text"], input[type="password"] {
  width: 100%;
  padding: 12px;
  margin-bottom: 16px;
  border: none;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
  font-size: 16px;
}

input::placeholder {
  color: #eee;
}

button[type="submit"] {
  background-color: #ff69b4;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #e0559e;
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
            <h1>🔐 Zaloguj się</h1>

            <?php if ($errors): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post">
  <label>
    Nazwa użytkownika:
    <input type="text" name="username" placeholder="Wpisz nazwę" required>
  </label>

  <label>
    Hasło:
    <input type="password" name="password" placeholder="••••••••" required>
  </label>

  <button type="submit">Zaloguj się</button>
</form>


            <p><a href="#">❓ Zapomniałeś hasła?</a></p>
            <hr>
            <p><a href="register.php">Nie masz konta? Zarejestruj się</a></p>
        </div>
    </div>
</body>
</html>

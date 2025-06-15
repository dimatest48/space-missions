<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona główna</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="home">
    <video autoplay muted loop class="video-bg">
    <source src="assets/videos/background.mp4" type="video/mp4">
    Twoja przeglądarka nie obsługuje wideo.
    </video>
    <div class="overlay"></div>
  <a class="panel" href="index.php">Główna</a>
  <a class="panel_02" href="missions.php">Misji</a>
  <div class="container">
    <div class="left">
      <div>
        <h1>ODKRYJ KOSMOS</h1>
          <ul>
        Czy wiesz, że…<p>
        <li>Teleskop Jamesa Webba może obserwować galaktyki powstałe tuż po Wielkim Wybuchu.</li><p>
        <li>Międzynarodowa Stacja Kosmiczna (ISS) okrąża Ziemię co 90 minut.</li><p>
        <li>Pierwszy obiekt stworzony przez człowieka, który opuścił Układ Słoneczny, to Voyager 1.</li>
        </ul>
        <p>Dołącz do naszej społeczności odkrywców kosmosu! Poznaj najnowsze misje, odkrycia i technologie, które zmieniają sposób, w jaki postrzegamy Wszechświat.</p>
        <p>Po prostu kliknij przycisk i zanurz się w świat międzygwiezdnych podróży.</p>
        <button onclick="window.location.href='missions.php'">Przejdź do misji</button>
      </div>
    </div>

    <div class="right">
        <h1>Witaj w systemie misji kosmicznych</h1>

        <?php if (isset($_SESSION['username'])): ?>
            <p>👋 Cześć, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
            <p><a class="btn" href="profile.php">👤 Mój profil</a></p>
            <p><a class="btn btn-secondary" href="logout.php">🚪 Wyloguj się</a></p>
        <?php else: ?>
            <p>
                <a class="btn" href="login.php">Zaloguj się</a>
                lub
                <a class="btn" href="register.php">Zarejestruj się</a>
            </p>
        <?php endif; ?>
        <hr>
       

         <ul>
        Nasze cele<p>
        <li>Promowanie edukacji kosmicznej.</li><p>
        <li>Zbieranie danych o misjach w czasie rzeczywistym.</li><p>
        <li>Tworzenie społeczności miłośników astronomii i eksploracji.</li>
        </ul>
    </div>
        </div>
</body>
</html>

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT username, email, role, avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Nie znaleziono użytkownika.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Profil użytkownika</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="profile-page">

<div class="profile-container">

    <h1 class="profile-title">👤 Twój profil</h1>

    <div class="profile-card">
        <?php if (!empty($user['avatar'])): ?>
            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="profile-avatar">
        <?php else: ?>
            <p class="no-avatar">Brak avatara.</p>
        <?php endif; ?>
    </div>

    <div class="profile-info">
        <div class="info-block"><strong>Nazwa użytkownika:</strong> <?= htmlspecialchars($user['username']) ?></div>
        <div class="info-block"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
        <div class="info-block"><strong>Rola:</strong> <?= htmlspecialchars($user['role']) ?></div>
    </div>

    <div class="avatar-upload">
        <h3>🖼 Zmień avatar</h3>
        <form method="post" action="upload_avatar.php" enctype="multipart/form-data">
            <input type="file" name="avatar" accept="image/png, image/jpeg" required>
            <button type="submit">📤 Prześlij</button>
        </form>
    </div>

    <div class="back-link">
        <a href="index.php">⬅️ Powrót do strony głównej</a>
    </div>

</div>

</body>
</html>


<?php
session_start();
require 'db.php';

$mission_id = isset($_GET['mission_id']) ? intval($_GET['mission_id']) : 0;

// Отримання місії
$stmt = $pdo->prepare("SELECT * FROM missions WHERE id = ?");
$stmt->execute([$mission_id]);
$mission = $stmt->fetch();

if (!$mission) {
    echo "Misja nie istnieje.";
    exit;
}

// Отримання коментарів
$stmt = $pdo->prepare("
    SELECT comments.id, comments.content, comments.created_at, users.username, users.avatar
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE mission_id = ?
    ORDER BY created_at DESC
");

$stmt->execute([$mission_id]);
$comments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Komentarze do misji: <?= htmlspecialchars($mission['title']) ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fdfbff;
        padding: 20px;
        color: #333;
    }

    h1 {
        font-size: 24px;
        color: #222;
    }

    a {
        color: #a34ea3;
        text-decoration: none;
    }

    .comment {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .comment:hover {
        transform: translateY(-2px);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffaad4;
        box-shadow: 0 0 10px rgba(255, 105, 180, 0.2);
        margin-right: 10px;
    }

    .delete-link {
        float: right;
        font-size: 14px;
        color: #e74c3c;
        text-decoration: none;
    }

    .delete-link:hover {
        text-decoration: underline;
    }

    form {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }

    textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        resize: vertical;
        font-size: 14px;
        font-family: inherit;
        box-sizing: border-box;
    }

    button[type="submit"] {
        margin-top: 10px;
        background-color: #ff70b4;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    button[type="submit"]:hover {
        background-color: #ff52a3;
    }

    em {
        font-size: 13px;
        color: #888;
    }

    strong {
        font-size: 16px;
    }

    hr {
        margin-top: 40px;
        border: none;
        height: 1px;
        background: #eee;
    }
</style>

</head>
<body>
   <h1>💬 Komentarze do misji: <?= htmlspecialchars($mission['title']) ?> (<?= count($comments) ?>)</h1>

    <p><a href="missions.php">⏪ Powrót do listy misji</a></p>

    <?php foreach ($comments as $comment): ?>
    <div class="comment">
        <div class="comment-header">
            <div class="user-info">
                <?php if (!empty($comment['avatar'])): ?>
                    <img src="<?= htmlspecialchars($comment['avatar']) ?>" alt="Avatar" class="avatar">
                <?php endif; ?>
                <strong><?= htmlspecialchars($comment['username']) ?></strong>
            </div>
            <em><?= $comment['created_at'] ?></em>
        </div>
        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a class="delete-link" href="delete_comment.php?id=<?= $comment['id'] ?>&mission_id=<?= $mission_id ?>" onclick="return confirm('Czy na pewno usunąć komentarz?')">🗑 Usuń</a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <hr>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post" action="post_comment.php">
            <h3>➕ Dodaj komentarz</h3>
            <textarea name="content" rows="4" cols="50" required placeholder="Napisz coś..."></textarea><br>
            <input type="hidden" name="mission_id" value="<?= $mission_id ?>">
            <button type="submit">💬 Wyślij</button>
        </form>
    <?php else: ?>
        <p>🔒 Musisz być <a href="login.php">zalogowany</a>, aby dodać komentarz.</p>
    <?php endif; ?>
</body>
</html>

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];

    if ($file['error'] === 0 && in_array($file['type'], ['image/jpeg', 'image/png'])) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatars/' . uniqid() . '.' . $ext;

        if (!is_dir('avatars')) {
            mkdir('avatars', 0777, true);
        }

        move_uploaded_file($file['tmp_name'], $filename);

        $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute([$filename, $_SESSION['user_id']]);
    }

    header("Location: profile.php");
    exit;
}
?>

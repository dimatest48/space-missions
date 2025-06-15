<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    die("Brak dostępu.");
}

$comment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mission_id = isset($_GET['mission_id']) ? intval($_GET['mission_id']) : 0;

// перевірити чи коментар існує
$stmt = $pdo->prepare("SELECT id FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);
if (!$stmt->fetch()) {
  die("Komentarz nie istnieje.");
}

$stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);

header("Location: comments.php?mission_id=" . $mission_id);
exit;

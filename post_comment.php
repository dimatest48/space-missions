<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mission_id = $_POST['mission_id'];
$content = trim($_POST['content']);

if ($content !== '') {
    $stmt = $pdo->prepare("INSERT INTO comments (mission_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$mission_id, $_SESSION['user_id'], $content]);
}

header("Location: comments.php?mission_id=" . $mission_id);
exit;

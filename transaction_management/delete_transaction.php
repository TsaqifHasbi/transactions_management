<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM transactions WHERE id = :id');
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit;
?>
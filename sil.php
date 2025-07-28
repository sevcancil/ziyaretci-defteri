<?php
session_start();
if (!isset($_SESSION['giris'])) {
    header("Location: login.php");
    exit;
}

require_once 'veritabani.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sorgu = $pdo->prepare("DELETE FROM mesajlar WHERE id = ?");
    $sorgu->execute([$id]);
}

header("Location: index.php");
exit;

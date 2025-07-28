<?php
session_start();
require_once 'veritabani.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kullanici = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    $sorgu = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?");
    $sorgu->execute([$kullanici, $sifre]);

    if ($sorgu->rowCount() == 1) {
        $_SESSION['giris'] = true;
        $_SESSION['kullanici_adi'] = $kullanici;
        header("Location: index.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    <h1>Giriş Yap</h1>
    <?php if (isset($hata)) echo "<p style='color:red;'>$hata</p>"; ?>

    <form method="POST">
        <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required><br><br>
        <input type="password" name="sifre" placeholder="Şifre" required><br><br>
        <button type="submit">Giriş</button>
    </form>
</body>
</html>

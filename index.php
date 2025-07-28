<?php
session_start();
if (!isset($_SESSION['giris'])) {
    header("Location: login.php");
    exit;
}
require_once 'veritabani.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ziyaretçi Defteri</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    <h1>Ziyaretçi Defteri</h1>

    <form method="POST">
        <p>Hoş geldin, <?php echo $_SESSION['kullanici_adi']; ?> | <a href="logout.php">Çıkış yap</a></p>
        <input type="text" name="isim" placeholder="Adınız" required><br><br>
        <textarea name="mesaj" placeholder="Mesajınız" required></textarea><br><br>
        <button type="submit">Gönder</button>
    </form>

    <hr>

    <h2>Gönderilen Mesajlar:</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $isim = $_POST['isim'];
        $mesaj = $_POST['mesaj'];

        $sorgu = $pdo->prepare("INSERT INTO mesajlar (isim, mesaj) VALUES (?, ?)");
        $sorgu->execute([$isim, $mesaj]);
    }

    $sorgu = $pdo->query("SELECT * FROM mesajlar ORDER BY tarih DESC");
    foreach ($sorgu as $satir) {
        echo "<p><strong>" . htmlspecialchars($satir['isim']) . "</strong>: " . nl2br(htmlspecialchars($satir['mesaj'])) . "<br><small>" . $satir['tarih'] . "</small></p><hr>";
    }
    ?>
</body>
</html>

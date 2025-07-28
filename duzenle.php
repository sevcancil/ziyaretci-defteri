<?php
session_start();
if (!isset($_SESSION['giris'])) {
    header("Location: login.php");
    exit;
}

require_once 'veritabani.php';

// Veriyi çek
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sorgu = $pdo->prepare("SELECT * FROM mesajlar WHERE id = ?");
    $sorgu->execute([$id]);
    $kayit = $sorgu->fetch();

    if (!$kayit) {
        die("Kayıt bulunamadı.");
    }
}

// Form gönderildiyse güncelle
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isim = $_POST['isim'];
    $mesaj = $_POST['mesaj'];
    $id = $_POST['id'];

    $sorgu = $pdo->prepare("UPDATE mesajlar SET isim = ?, mesaj = ? WHERE id = ?");
    $sorgu->execute([$isim, $mesaj, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mesaj Düzenle</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    <h1>Mesaj Düzenle</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $kayit['id']; ?>">
        <input type="text" name="isim" value="<?php echo htmlspecialchars($kayit['isim']); ?>" required><br><br>
        <textarea name="mesaj" required><?php echo htmlspecialchars($kayit['mesaj']); ?></textarea><br><br>
        <button type="submit">Güncelle</button>
    </form>
</body>
</html>

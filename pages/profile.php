<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (!isLoggedIn()) {
    header("Location: ../index.php");
} else {
    $musteri_id = $_SESSION["musteri_id"];
}
?>

<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <?php include("../parts/index_header.php"); ?>
    <div class="profile-content">
        <div class="user-menu">
            <h4>Hesabım</h4>
            <ul>
                <li><a href="sepet.php">Siparişlerim</a></li>
                <li><a href="profile.php">Profilim</a></li>
                <li><a href="evaluations.php">Değerlendirmelerim</a></li>
                <li><a href="favorites.php">Beğenmelerim</a></li>
            </ul>
            <h4>Kullanıcı Bilgilerim</h4>
            <ul>
                <li><a href="#">Üyelik Bilgilerim</a></li>
                <li><a href="#">IBAN Bilgilerim</a></li>
                <li><a href="#">İletişim Bilgilerim</a></li>
                <li><a href="#">Adreslerim</a></li>
            </ul>
        </div>
        <div class="user-pr">
            <form action="profile.php" method="post">
                <h3>Üyelik Bilgilerim</h3>
                <label for="name">Ad:</label><br>
                <input type="text" name="ad" value=""><br>
                <label for="surname">Soyad:</label><br>
                <input type="text" name="soyad" value=""><br>
                <label for="date">Doğum Tarihi:</label><br>
                <input type="date" name="dtarih"><br>
                <label for="">Cinsiyet:</label><br>
                <input type="radio" name="cinsiyet" value="Erkek"><label for="">Erkek</label>
                <input type="radio" name="cinsiyet" value="Kadın"><label for="">Kadın</label><br>
                <button type="submit">Güncelle</button>
            </form>
        </div>
        <div class="pswd">
            <form action="profile.php" method="post">
                <h3>Şifre Güncelleme</h3>
                <label for="Password">Mevcut Şifre:</label><br>
                <input type="password" name="password"><br>
                <label for="newpassword">Yeni Şifre:</label><br>
                <input type="password" name="newpassword"><br>
                <label for="renewpassword">Yeni Şifre(Tekrar):</label><br>
                <input type="password" name="renewpassword"><br>
                <button type="submit">Güncelle</button>
            </form>
        </div>
    </div>

    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/footer.php") ?>

</body>

</html>
<?php
require_once("../parts/config.php");
require("../libs/functions.php");
require("../libs/classes.php");
session_start();
if (isAdminLoggedIn()) {
    if (isset($_GET["urun_kodu"])) {
        $urun_kodu = $_GET["urun_kodu"];
        if (isset($_POST["add-submit"])) {
            $UrunEkle = new AddProduct();
            if ($urun_kodu[0] == "1") {
                $UrunEkle->BilgisayarEkle($baglanti, $urun_kodu);
            } else if ($urun_kodu[0] == "2") {
                $UrunEkle->TelefonEkle($baglanti, $urun_kodu);
            } else if ($urun_kodu[0] == "3") {
                $UrunEkle->TelevizyonEkle($baglanti, $urun_kodu);
            } else if ($urun_kodu[0] == "4") {
                $UrunEkle->TabletEkle($baglanti, $urun_kodu);
            } else if ($urun_kodu[0] == "5") {
                $UrunEkle->SaatEkle($baglanti, $urun_kodu);
            }
        }
    }
} else {
    header("Location: ./login.php");
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Ürün Yönetimi</title>
</head>

<body>
    <div class="product-div">
        <div class="product-form">
            <form action="" method="get">
                <input type="text" name="urun_kodu" placeholder="Eklenecek ürün kodunu giriniz..">
                <button type="submit">Tamam</button>
            </form>
            <?php if (isset($_GET["urun_kodu"]) && $urun_kodu[0] == "1") : ?>
                <form action="" method="post">
                    <h2>Ürün Ekle</h2>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" required><br>
                    <input name="marka" type="text" placeholder="Marka" required><br>
                    <input name="model" type="text" placeholder="Model" required><br>
                    <input name="seri" type="text" placeholder="Seri"><br>
                    <input name="kategori" type="text" placeholder="Kategori" required><br>
                    <input name="urun_tipi" type="text" placeholder="Ürün Tipi" required><br>
                    <input name="ekran_karti" type="text" placeholder="Ekran Kartı" required><br>
                    <input name="ram" type="text" placeholder="Ram" required><br>
                    <input name="ekran_k_hafiza" type="text" placeholder="Ekran Kartı Hafızası" required><br>
                    <input name="ekran_k_tipi" type="text" placeholder="Ekran Kartı Tipi" required><br>
                    <input name="ram_tipi" type="text" placeholder="Ram Tipi" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" required><br>
                    <input name="renk" type="text" placeholder="Renk" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" required><br>
                    <input name="maks_islemci_hiz" type="text" placeholder="Maks. İşlemci Hızı" required><br>
                    <input name="bellek_hizi" type="text" placeholder="Bellek Hızı" required><br>
                    <input name="islemci_nesli" type="text" placeholder="İşlemci Nesli" required><br>
                    <input name="islemci" type="text" placeholder="İşlemci" required><br>
                    <input name="islemci_modeli" type="text" placeholder="İşlemci Modeli" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyut" required><br>
                    <input name="stok" type="text" placeholder="Stok Sayısı" required><br>
                    <input name="fiyat" type="text" placeholder="Fiyat" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" required><br>
                    <button type="submit" name="add-submit">Ekle</button>
                </form>
            <?php endif; ?>
            <?php if (isset($_GET["urun_kodu"]) && $urun_kodu[0] == "2") : ?>
                <form action="" method="post">
                    <h2>Ürün Ekle</h2>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" required><br>
                    <input name="marka" type="text" placeholder="Marka" required><br>
                    <input name="model" type="text" placeholder="Model" required><br>
                    <input name="seri" type="text" placeholder="Seri"><br>
                    <input name="kategori" type="text" placeholder="Kategori" required><br>
                    <input name="renk" type="text" placeholder="Renk" required><br>
                    <input name="yuz_tanima" type="text" placeholder="Yüz Tanıma" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" required><br>
                    <input name="kamera" type="text" placeholder="Kamera" required><br>
                    <input name="pil_gucu" type="text" placeholder="Pil Gücü" required><br>
                    <input name="on_kamera" type="text" placeholder="Ön Kamera" required><br>
                    <input name="ram" type="text" placeholder="Ram" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" required><br>
                    <input name="kablosuz_sarj" type="text" placeholder="Kablosuz Şarj" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" required><br>
                    <input name="stok" type="text" placeholder="Stok Sayısı" required><br>
                    <input name="fiyat" type="text" placeholder="Fiyat" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" required><br>
                    <button type="submit" name="add-submit">Ekle</button>
                </form>
            <?php endif; ?>
            <?php if (isset($_GET["urun_kodu"]) && $urun_kodu[0] == "3") : ?>
                <form action="" method="post">
                    <h2>Ürün Ekle</h2>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" required><br>
                    <input name="marka" type="text" placeholder="Marka" required><br>
                    <input name="model" type="text" placeholder="Model" required><br>
                    <input name="seri" type="text" placeholder="Seri"><br>
                    <input name="kategori" type="text" placeholder="Kategori" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" required><br>
                    <input name="smarttv" type="text" placeholder="Smart TV" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" required><br>
                    <input name="goruntu" type="text" placeholder="Görüntü" required><br>
                    <input name="model_yil" type="text" placeholder="Model Yılı" required><br>
                    <input name="cozunurluk" type="text" placeholder="Çözünürlük" required><br>
                    <input name="enerji_sinifi" type="text" placeholder="Enerji Sınıfı" required><br>
                    <input name="stok" type="text" placeholder="Stok Sayısı" required><br>
                    <input name="fiyat" type="text" placeholder="Fiyat" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" required><br>
                    <button type="submit" name="add-submit">Ekle</button>
                </form>
            <?php endif; ?>
            <?php if (isset($_GET["urun_kodu"]) && $urun_kodu[0] == "4") : ?>
                <form action="" method="post">
                    <h2>Ürün Ekle</h2>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" required><br>
                    <input name="marka" type="text" placeholder="Marka" required><br>
                    <input name="model" type="text" placeholder="Model" required><br>
                    <input name="seri" type="text" placeholder="Seri"><br>
                    <input name="kategori" type="text" placeholder="Kategori" required><br>
                    <input name="renk" type="text" placeholder="Renk" required><br>
                    <input name="kalem" type="text" placeholder="Kalem" required><br>
                    <input name="ram" type="text" placeholder="Ram" required><br>
                    <input name="pil_gucu" type="text" placeholder="Pil Gücü" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" required><br>
                    <input name="stok" type="text" placeholder="Stok Sayısı" required><br>
                    <input name="fiyat" type="text" placeholder="Fiyat" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" required><br>
                    <button type="submit" name="add-submit">Ekle</button>
                </form>
            <?php endif; ?>
            <?php if (isset($_GET["urun_kodu"]) && $urun_kodu[0] == "5") : ?>
                <form action="" method="post">
                    <h2>Ürün Ekle</h2>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" required><br>
                    <input name="marka" type="text" placeholder="Marka" required><br>
                    <input name="model" type="text" placeholder="Model" required><br>
                    <input name="seri" type="text" placeholder="Seri"><br>
                    <input name="kategori" type="text" placeholder="Kategori" required><br>
                    <input name="kamera" type="text" placeholder="Kamera" required><br>
                    <input name="titresim" type="text" placeholder="Titreşim" required><br>
                    <input name="gps" type="text" placeholder="GPS" required><br>
                    <input name="sesli_gorusme" type="text" placeholder="Sesli Görüşme" required><br>
                    <input name="su_gecirme" type="text" placeholder="Su Geçirme" required><br>
                    <input name="uyku" type="text" placeholder="Uyku Takibi" required><br>
                    <input name="adim" type="text" placeholder="Adım Ölçer" required><br>
                    <input name="kalp" type="text" placeholder="Kalp Ölçer" required><br>
                    <input name="cinsiyet" type="text" placeholder="Cinsiyet" required><br>
                    <input name="renk" type="text" placeholder="Renk" required><br>
                    <input name="stok" type="text" placeholder="Stok Sayısı" required><br>
                    <input name="fiyat" type="text" placeholder="Fiyat" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" required><br>
                    <button type="submit" name="add-submit">Ekle</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
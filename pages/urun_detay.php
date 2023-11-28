<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php"); ?>
<?php session_start(); ?>
<?php
if (!isset($_GET["kod"])) {
    header("Location: ../index.php");
}
$id = $_GET["kod"];

if ($id[0] == 1) {
    $result_urun = mysqli_query($baglanti, "SELECT * FROM computers WHERE urun_kodu=" . $id);

    $urun = mysqli_fetch_assoc($result_urun);
} elseif ($id[0] == 2) {
    $result_urun = mysqli_query($baglanti, "SELECT * FROM phones WHERE urun_kodu=" . $id);

    $urun = mysqli_fetch_assoc($result_urun);
} elseif ($id[0] == 3) {
    $result_urun = mysqli_query($baglanti, "SELECT * FROM televisions WHERE urun_kodu=" . $id);

    $urun = mysqli_fetch_assoc($result_urun);
} elseif ($id[0] == 4) {
    $result_urun = mysqli_query($baglanti, "SELECT * FROM tablets WHERE urun_kodu=" . $id);

    $urun = mysqli_fetch_assoc($result_urun);
} elseif ($id[0] == 5) {
    $result_urun = mysqli_query($baglanti, "SELECT * FROM smart_watchs WHERE urun_kodu=" . $id);

    $urun = mysqli_fetch_assoc($result_urun);
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $urun["marka"] . " " . $urun["model"]; ?>
    </title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <?php include("../parts/index_header.php"); ?>
    <?php include("../parts/categories.php"); ?>
    <?php
    echo "<div class='urun'>
            <img src='../image/$urun[resim_adi]' alt='$urun[marka] $urun[model] $urun[seri]'>
            <div style= 'border: 1px solid grey;'>
                <div>
                    <form action = '../libs/sepete_ekle.php' method = 'post'>
                        <h2>$urun[marka] $urun[model] $urun[seri]</h2>
                        <h1>$urun[fiyat] TL</h1>
                        <h3>Stok:  $urun[stok]</h3>
                        <input type='hidden' name='product_id' value='$urun[urun_kodu]'>
                        <button class = 'sepetekle2' type='submit'>Sepete Ekle</button>
                    </form>
                </div>
            </div>
        </div>"
    ?>
    <?php
    if ($id[0] == 1) {
        echo "<div class='ozellikler'>
                <h2>Özellikler</h2>
                <table>
                    <tr>
                        <td>Ekran Kartı</td>
                        <td>$urun[ekran_karti]</td>
                    </tr>
                    <tr>
                        <td>Ürün Tipi</td>
                        <td>$urun[urun_tipi]</td>
                    </tr>
                    <tr>
                        <td>RAM</td>
                        <td>$urun[ram] GB</td>
                    </tr> 
                    <tr>
                        <td>Ekran Kartı Hafızası</td>
                        <td>$urun[ekran_k_hafiza]</td>
                    </tr>
                    <tr>
                        <td>SSD</td>
                        <td>$urun[hafiza] GB</td>
                    </tr>
                    <tr>
                        <td>Ekran Kartı Tipi</td>
                        <td>$urun[ekran_k_tipi]</td>
                    </tr>
                    <tr>
                        <td>RAM Tipi</td>
                        <td>$urun[ram_tipi]</td>
                    </tr>
                    <tr>
                        <td>Renk</td>
                        <td>$urun[renk]</td>
                    </tr>
                    <tr>
                        <td>İşletim Sistemi</td>
                        <td>$urun[isletim_sistemi]</td>
                    </tr>
                    <tr>
                        <td>Maks. İşlemci Hızı</td>
                        <td>$urun[maks_islemci_hiz] GHz</td>
                    </tr>
                    <tr>
                        <td>Bellek Hızı</td>
                        <td>$urun[bellek_hizi]</td>
                    </tr>
                    <tr>
                        <td>İşlemci Nesli</td>
                        <td>$urun[islemci_nesli]</td>
                    </tr>
                    <tr>
                        <td>Ekran Boyutu</td>
                        <td>$urun[ekran_boyut] inç</td>
                    </tr>
                    <tr>
                        <td>İşlemci Modeli</td>
                        <td>$urun[islemci_modeli]</td>
                    </tr>
                    <tr>
                        <td>İşlemci</td>
                        <td>$urun[islemci]</td>
                    </tr>
                </table>
           </div>";
    } elseif ($id[0] == 2) {
        echo "<div class='ozellikler'>
                <h2>Özellikler</h2>
                <table>
                    <tr>
                        <td>Renk</td>
                        <td>$urun[renk]</td>
                    </tr>
                    <tr>
                        <td>Yüz Tanıma</td>
                        <td>$urun[yuz_tanima]</td>
                    </tr>
                    <tr>
                        <td>Ekran Boyutu</td>
                        <td>$urun[ekran_boyut] inç</td>
                    </tr> 
                    <tr>
                        <td>Kamera</td>
                        <td>$urun[kamera] MP</td>
                    </tr>
                    <tr>
                        <td>Pil Gücü</td>
                        <td>$urun[pil_gucu] mAh</td>
                    </tr>
                    <tr>
                        <td>Ön Kamera</td>
                        <td>$urun[on_kamera] MP</td>
                    </tr>
                    <tr>
                        <td>RAM</td>
                        <td>$urun[ram] GB</td>
                    </tr>
                    <tr>
                        <td>Hafıza</td>
                        <td>$urun[hafiza] GB</td>
                    </tr>
                    <tr>
                        <td>Kablosuz Şarj</td>
                        <td>$urun[kablosuz_sarj]</td>
                    </tr>
                    <tr>
                        <td>İşletim Sistemi</td>
                        <td>$urun[isletim_sistemi]</td>
                    </tr>
                </table>
            </div>";
    } elseif ($id[0] == 3) {
        echo "<div class='ozellikler'>
                <h2>Özellikler</h2>
                <table>
                    <tr>
                        <td>Ekran Boyutu</td>
                        <td>$urun[ekran_boyut] inç</td>
                    </tr>
                    <tr>
                        <td>Smart TV</td>
                        <td>$urun[smarttv]</td>
                    </tr>
                    <tr>
                        <td>İşletim Sistemi</td>
                        <td>$urun[isletim_sistemi]</td>
                    </tr> 
                    <tr>
                        <td>Görüntü Teknolojisi</td>
                        <td>$urun[goruntu]</td>
                    </tr>
                    <tr>
                        <td>Model Yılı</td>
                        <td>$urun[model_yil]</td>
                    </tr>
                    <tr>
                        <td>Çözünürlük</td>
                        <td>$urun[cozunurluk]</td>
                    </tr>
                    <tr>
                        <td>Enerji Sınıfı</td>
                        <td>$urun[enerji_sinifi]</td>
                    </tr>
                </table>
            </div>";
    } elseif ($id[0] == 4) {
        echo "<div class='ozellikler'>
                <h2>Özellikler</h2>
                <table>
                    <tr>
                        <td>Renk</td>
                        <td>$urun[renk]</td>
                    </tr>
                    <tr>
                        <td>Kalem Desteği</td>
                        <td>$urun[kalem]</td>
                    </tr>
                    <tr>
                        <td>RAM</td>
                        <td>$urun[ram] GB</td>
                    </tr> 
                    <tr>
                        <td>Pil Gücü</td>
                        <td>$urun[pil_gucu] mAh</td>
                    </tr>
                    <tr>
                        <td>İşletim Sistemi</td>
                        <td>$urun[isletim_sistemi]</td>
                    </tr>
                    <tr>
                        <td>Ekran Boyutu</td>
                        <td>$urun[ekran_boyut] inç</td>
                    </tr>
                    <tr>
                        <td>Hafıza</td>
                        <td>$urun[hafiza] GB</td>
                    </tr>
                </table>
            </div>";
    } elseif ($id[0] == 5) {
        echo "<div class='ozellikler'>
                <h2>Özellikler</h2>
                <table>
                    <tr>
                        <td>Kamera</td>
                        <td>$urun[kamera]</td>
                    </tr>
                    <tr>
                        <td>Titreşim</td>
                        <td>$urun[titresim]</td>
                    </tr>
                    <tr>
                        <td>GPS</td>
                        <td>$urun[gps]</td>
                    </tr> 
                    <tr>
                        <td>Sesli Görüşme</td>
                        <td>$urun[sesli_gorusme]</td>
                    </tr>
                    <tr>
                        <td>Su Geçirmezlik</td>
                        <td>$urun[su_gecirme]</td>
                    </tr>
                    <tr>
                        <td>Uyku Takibi</td>
                        <td>$urun[uyku]</td>
                    </tr>
                    <tr>
                        <td>Adım Takibi</td>
                        <td>$urun[adim]</td>
                    </tr>
                    <tr>
                        <td>Kalp Ritmi Ölçme</td>
                        <td>$urun[kalp]</td>
                    </tr>
                    <tr>
                        <td>Cinsiyet</td>
                        <td>$urun[cinsiyet]</td>
                    </tr>
                    <tr>
                        <td>Renk</td>
                        <td>$urun[renk]</td>
                    </tr>
                </table>
            </div>";
    }
    ?>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php"); ?>
    <?php include("../parts/footer.php"); ?>
</body>

</html>
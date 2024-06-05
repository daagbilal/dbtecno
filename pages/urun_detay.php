<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php"); ?>
<?php session_start() ?>
<?php
if (!isset($_GET["kod"])) {
    header("Location: ../index.php");
}
$id = $_GET["kod"];
$musteri_id = "";
$urun = "";

if ($id[0] == 1) {
    $stmt = mysqli_prepare($baglanti, "SELECT c.urun_kodu, resim_adi, marka, model, seri, kategori, urun_tipi, ekran_karti, ram, ekran_k_hafiza, ekran_k_tipi, ram_tipi, hafiza, renk, isletim_sistemi, maks_islemci_hiz, bellek_hizi, islemci_nesli, islemci, islemci_modeli, ekran_boyut, sf.fiyat, sf.stok
    FROM computers c
    INNER JOIN stokfiyat sf ON c.urun_kodu = sf.urun_kodu
    WHERE c.urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $urun = mysqli_fetch_assoc($result);
} elseif ($id[0] == 2) {
    $stmt = mysqli_prepare($baglanti, "SELECT p.urun_kodu, resim_adi, marka, model, seri, kategori, renk, yuz_tanima, ekran_boyut, kamera, pil_gucu, on_kamera, ram, hafiza, kablosuz_sarj, isletim_sistemi, sf.fiyat, sf.stok
    FROM phones p
    INNER JOIN stokfiyat sf ON p.urun_kodu = sf.urun_kodu
    WHERE p.urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $urun = mysqli_fetch_assoc($result);
} elseif ($id[0] == 3) {
    $stmt = mysqli_prepare($baglanti, "SELECT t.urun_kodu, resim_adi, marka, model, seri, kategori, ekran_boyut, smarttv, isletim_sistemi, goruntu, model_yil, cozunurluk, enerji_sinifi, sf.fiyat, sf.stok
    FROM televisions t
    INNER JOIN stokfiyat sf ON t.urun_kodu = sf.urun_kodu
    WHERE t.urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $urun = mysqli_fetch_assoc($result);
} elseif ($id[0] == 4) {
    $stmt = mysqli_prepare($baglanti, "SELECT tb.urun_kodu, resim_adi, marka, model, seri, kategori, renk, kalem, ram, pil_gucu, isletim_sistemi, ekran_boyut, hafiza, sf.fiyat, sf.stok
    FROM tablets tb
    INNER JOIN stokfiyat sf ON tb.urun_kodu = sf.urun_kodu
    WHERE tb.urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $urun = mysqli_fetch_assoc($result);
} elseif ($id[0] == 5) {
    $stmt = mysqli_prepare($baglanti, "SELECT sw.urun_kodu, resim_adi, marka, model, seri, kategori, kamera, titresim, gps, sesli_gorusme, su_gecirme, uyku, adim, kalp, cinsiyet, renk, sf.fiyat, sf.stok
    FROM smart_watchs sw
    INNER JOIN stokfiyat sf ON sw.urun_kodu = sf.urun_kodu
    WHERE sw.urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $urun = mysqli_fetch_assoc($result);
}

$stmt = mysqli_prepare($baglanti, "SELECT * FROM evaluations WHERE urun_kodu = ? AND onay = 1 ORDER BY add_time desc, ad LIMIT 3");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$evaluations = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($baglanti, "SELECT AVG(puan) FROM evaluations WHERE urun_kodu = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result_puan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$result_puan = $result_puan["AVG(puan)"];
if ($result_puan != 0) {
    $puan = number_format($result_puan, 1, '.', '');
} else {
    $puan = 0;
}



$favorite = false;

if (empty($urun)) {
    header("Location: ../index.php");
}
if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $sql = "SELECT * FROM favorites WHERE urun_kodu= ? AND musteri_id = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $musteri_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 1) {
        $favorite = true;
    } else {
        $favorite = false;
    }
}

$ev_ctrl = "SELECT musteri_id FROM evaluations WHERE urun_kodu =? AND musteri_id = ?";
$stmt = mysqli_prepare($baglanti, $ev_ctrl);
mysqli_stmt_bind_param($stmt, "ii", $id, $musteri_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) == 1) {
    $degerlendirme = true;
} else {
    $degerlendirme = false;
}



if (isLoggedIn() && isset($_POST["evaluation_submit"])) {
    $stmt = mysqli_prepare($baglanti, "INSERT INTO evaluations (urun_kodu, urun, musteri_id, ad, soyad, puan, yorum, add_time) VALUES (?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "isississ", $id, $urun_adi, $musteri_id, $ad, $soyad, $puan, $yorum, $add_time);
    $urun_adi = "$urun[marka] $urun[model] $urun[seri]";
    $musteri_id = $_SESSION["musteri_id"];
    $ad = $_SESSION["ad"];
    $soyad = $_SESSION["soyad"];
    $puan = $_POST["rating"];
    $yorum = $_POST["yorum"];
    $add_time = date('Y-m-d');
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("location: urun_detay.php?kod=$id");
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"   />

</head>

<body>
    <div id="loading">
        <img src="../icons/Double Ring-1s-200px.svg" alt="Yükleniyor..." />
    </div>

    <script>
        window.addEventListener('load', fg_load)

        function fg_load() {
            document.getElementById('loading').style.display = 'none'
        }
    </script>
    <?php include("../parts/index_header.php"); ?>
    <?php include("../parts/categories.php"); ?>
    <div class='urun'>
        <img src='../image/<?php echo $urun['resim_adi'] ?>' alt='<?php echo "$urun[marka] $urun[model] $urun[seri]" ?>'>
        <div>
            <div>
                <h2><?php echo "$urun[marka] $urun[model] $urun[seri]" ?></h2>
                <h1><?php echo "$urun[fiyat] TL" ?></h1>
                <?php
                if ($urun["stok"] <= 5 && $urun["stok"] > 0) {
                    echo "<h3 style='color:red'>Stok: $urun[stok]</h3>";
                } else if ($urun["stok"] == 0) {
                    echo "<h3 style='color:red'>Stok Tükendi!</h3>";
                } else {
                    echo "<h3>Stok: $urun[stok]</h3>";
                }
                ?>
                <?php if ($favorite == true) : ?>
                        <button class='favorite-button' type='submit' onclick="favorite_product(1, <?php echo $urun['urun_kodu'] ?>)"><i class="fa-solid fa-heart fa-2xl"></i></button>
                <?php endif; ?>
                <?php if ($favorite == false) : ?>
                        <button class='favorite-button' type='submit' onclick="favorite_product(0, <?php echo $urun['urun_kodu'] ?>)"><i class="fa-regular fa-heart fa-2xl"></i></button>
                <?php endif; ?>
                <button class='sepetekle2' type='submit' onclick="sepetekle(<?php echo $urun['urun_kodu'] ?>)">Sepete Ekle</button>
            </div>
        </div>
    </div>
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
    <div class="degerlendir_content">
        <h2 style="width: 100%; text-align:center;">Değerlendirmeler</h2>
        <div class="total_degerlendirme">
            <div>
                <h3><?php echo "$urun[marka] $urun[model] $urun[seri]" ?></h3>
                <h3>Puan: <?php echo $puan ?></h3>
                <?php if (isLoggedIn() && $degerlendirme == false) : ?>
                    <button class="evaluation-button" id="showReviewForm">Değerlendir</button>
                <?php endif; ?>
                <?php if (isLoggedIn() == false || $degerlendirme == true) : ?>
                    <button class="evaluation-button-off">Değerlendir</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="degerlendirmeler">
            <?php if (!empty($evaluations)) : ?>
                <?php foreach ($evaluations as $evaluation) : ?>
                    <div class="degerlendirme">
                        <div class="degerlendirme-head">
                            <h4><?php echo "$evaluation[ad] $evaluation[soyad]" ?></h4>
                            <div><?php echo $evaluation["add_time"] ?></div>
                        </div>
                        <div class="degerlendirme-star">
                            <div>Puan: <?php echo $evaluation["puan"] ?></div>
                        </div>
                        <div class="degerlendirme-yorum">
                            <p><?php echo $evaluation["yorum"] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (empty($evaluations)) : ?>
                <div style="font-size: 20px; margin: 15px;text-align:center;">İlk değerlendirmeyi siz yapın.</div>
            <?php endif; ?>
        </div>
    </div>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php"); ?>
    <?php include("../parts/footer.php"); ?>
    <div class="reviewForm">
        <form action="" method="post">
            <div style="display: inline-block;">
                <input type="radio" name="rating" id="rating-1" value=1><label for="rating-1">1</label>
                <input type="radio" name="rating" id="rating-2" value=2><label for="rating-2">2</label>
                <input type="radio" name="rating" id="rating-3" value=3><label for="rating-3">3</label>
                <input type="radio" name="rating" id="rating-4" value=4><label for="rating-4">4</label>
                <input type="radio" name="rating" id="rating-5" value=5><label for="rating-5">5</label>
            </div>
            <textarea name="yorum" id="" cols="30" rows="4" placeholder="Yorumunuz..." required></textarea>
            <button class="evaluation-button" type="submit" name="evaluation_submit">Kaydet</button>
        </form>
        <div class="close"></div>
    </div>

    <script>
        let button = document.querySelector(".evaluation-button");
        let form = document.querySelector(".reviewForm");
        let close = document.querySelector(".close");

        button.addEventListener('click', function() {
            form.classList.add("active");
        })
        close.addEventListener('click', function() {
            form.classList.remove("active");
        })
    </script>
    <script src="/libs/app.js"></script>
</body>

</html>
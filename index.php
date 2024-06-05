<?php require_once("parts/config.php"); ?>
<?php require("libs/functions.php") ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            if ($id == 1) {
                echo "Bilgisayar";
            } elseif ($id == 2) {
                echo "Telefon";
            } elseif ($id == 3) {
                echo "Televizyon";
            } elseif ($id == 4) {
                echo "Tablet";
            } elseif ($id == 5) {
                echo "Akıllı Saat";
            }
        } else {
            echo "Teknolojinin Adresi";
        }
        ?>
    </title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #daddd678;">
    <div id="loading">
        <img src="icons/Double Ring-1s-200px.svg" alt="Yükleniyor..." />
    </div>

    <script>
        window.addEventListener('load', fg_load)

        function fg_load() {
            document.getElementById('loading').style.display = 'none'
        }
    </script>
    <?php include("parts/index_header.php"); ?>
    <?php include("parts/categories.php"); ?>
    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $product_category = "";
        if ($id == 1) {
            $product_category = db_products($baglanti, "computers");
            $baslik = "Bilgisayarlar";
        } elseif ($id == 2) {
            $product_category = db_products($baglanti, "phones");
            $baslik = "Telefonlar";
        } elseif ($id == 3) {
            $product_category = db_products($baglanti, "televisions");
            $baslik = "Televizyonlar";
        } elseif ($id == 4) {
            $product_category = db_products($baglanti, "tablets");
            $baslik = "Tabletler";
        } elseif ($id == 5) {
            $product_category = db_products($baglanti, "smart_watchs");
            $baslik = "Akıllı Saatler";
        }
        if (!empty($product_category)) {
            echo "<h2 class='baslik' style='padding-top: 30px;'>$baslik</h2>";
            echo "<div class='content'>";
            foreach ($product_category as $urun) {
                echo "<div class = 'product'>";
                echo "<a href='pages/urun_detay.php?kod=$urun[urun_kodu]' title = '$urun[marka] $urun[model] $urun[seri]'>";
                echo "<img src='image/$urun[resim_adi]' alt = '$urun[marka] $urun[model] $urun[fiyat]'>";
                echo "<h3>$urun[marka]</h3>";
                echo "<h3>$urun[model]</h3>";
                echo "<h4>$urun[fiyat] TL</h4>";
                echo "</a>";
                echo "<button class='sepetekle1' type='submit' title = 'Sepete Ekle' onclick = 'sepetekle($urun[urun_kodu])'>Sepete Ekle</button>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            header("Location: index.php");
        }
    } else {
        for ($x = 1; $x <= 5; $x++) {
            if ($x == 1) {
                $product = db_products_ctg($baglanti, "computers");
                $baslik = "Popüler Bilgisayarlar";
            } elseif ($x == 2) {
                $product = db_products_ctg($baglanti, "phones");
                $baslik = "Popüler Telefonlar";
            } elseif ($x == 3) {
                $product = db_products_ctg($baglanti, "televisions");
                $baslik = "Popüler Televizyonlar";
            } elseif ($x == 4) {
                $product = db_products_ctg($baglanti, "tablets");
                $baslik = "Popüler Tabletler";
            } elseif ($x == 5) {
                $product = db_products_ctg($baglanti, "smart_watchs");
                $baslik = "Popüler Saatler";
            }

            if (!empty($product)) {
                echo "<h2 class='baslik' style='padding-top: 30px;'>$baslik</h2>";
                echo "<div class='content'>";
                foreach ($product as $urun) {
                    echo "<div class = 'product'>";
                    echo "<a href='pages/urun_detay.php?kod=$urun[urun_kodu]' title = '$urun[marka] $urun[model] $urun[seri]'>";
                    echo "<img src='image/$urun[resim_adi]' alt ='$urun[marka] $urun[model] $urun[seri]'>";
                    echo "<h3>$urun[marka]</h3>";
                    echo "<h3>$urun[model]</h3>";
                    echo "<h4>$urun[fiyat] TL</h4>";
                    echo "</a>";
                    echo "<button class='sepetekle1' type='submit' title = 'Sepete Ekle' onclick = 'sepetekle($urun[urun_kodu])'>Sepete Ekle</button>";
                    echo "</div>";
                }
                echo "</div>";
            }
        }
    }
    ?>
    <?php mysqli_close($baglanti) ?>
    <?php include("parts/avantaj.php") ?>
    <?php include("parts/footer.php") ?>
    <script src="/libs/app.js"></script>
</body>

</html>
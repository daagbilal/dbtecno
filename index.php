<?php require_once("parts/config.php"); ?>
<?php require("libs/functions.php") ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>

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
</head>

<body>
    <?php include("parts/index_header.php"); ?>
    <?php include("parts/categories.php"); ?>
    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        if ($id == 1) {
            $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM computers");
            $product_category = mysqli_fetch_all($products_category, MYSQLI_ASSOC);
            $baslik = "Bilgisayarlar";
        } elseif ($id == 2) {
            $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM phones");
            $product_category = mysqli_fetch_all($products_category, MYSQLI_ASSOC);
            $baslik = "Telefonlar";
        } elseif ($id == 3) {
            $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM televisions");
            $product_category = mysqli_fetch_all($products_category, MYSQLI_ASSOC);
            $baslik = "Televizyonlar";
        } elseif ($id == 4) {
            $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM tablets");
            $product_category = mysqli_fetch_all($products_category, MYSQLI_ASSOC);
            $baslik = "Tabletler";
        } elseif ($id == 5) {
            $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM smart_watchs");
            $product_category = mysqli_fetch_all($products_category, MYSQLI_ASSOC);
            $baslik = "Akıllı Saatler";
        }
        if ($product_category) :
            echo "<h2 class='baslik' style='padding-top: 30px; background-color: #daddd678;'>$baslik</h2>";
            echo "<div class='content'>";
            foreach ($product_category as $urun) :
                echo "<a href='pages/urun_detay.php?kod=$urun[urun_kodu]' class='product' title = '$urun[marka] $urun[model] $urun[seri]'>";
                echo "<form action='libs/sepete_ekle.php' method='post'>";
                echo "<img src='image/$urun[resim_adi]' alt = '$urun[marka] $urun[model] $urun[fiyat]'>";
                echo "<h3>$urun[marka]</h3>";
                echo "<h3>$urun[model]</h3>";
                echo "<h4>$urun[fiyat] TL</h4>";
                echo "<input type='hidden' name='product_id' value= '$urun[urun_kodu]'>";
                echo "<button class='sepetekle1' type='submit' title = 'Sepete Ekle'>Sepete Ekle</button>";
                echo "</form>";
                echo "</a>";
            endforeach;
            echo "</div>";
        endif;
    } else {
        for ($x = 1; $x <= 5; $x++) {
            if ($x == 1) {
                $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM computers ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
                $product = mysqli_fetch_all($products, MYSQLI_ASSOC);
                $baslik = "Popüler Bilgisayarlar";
            } elseif ($x == 2) {
                $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM phones ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
                $product = mysqli_fetch_all($products, MYSQLI_ASSOC);
                $baslik = "Popüler Telefonlar";
            } elseif ($x == 3) {
                $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM televisions ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
                $product = mysqli_fetch_all($products, MYSQLI_ASSOC);
                $baslik = "Popüler Televizyonlar";
            } elseif ($x == 4) {
                $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM tablets ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
                $product = mysqli_fetch_all($products, MYSQLI_ASSOC);
                $baslik = "Popüler Tabletler";
            } elseif ($x == 5) {
                $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM smart_watchs ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
                $product = mysqli_fetch_all($products, MYSQLI_ASSOC);
                $baslik = "Popüler Saatler";
            }

            if ($product) :
                echo "<h2 class='baslik' style='padding-top: 30px; background-color: #daddd678;'>$baslik</h2>";
                echo "<div class='content'>";
                foreach ($product as $urun) :
                    echo "<a href='pages/urun_detay.php?kod=$urun[urun_kodu]' class='product' title = '$urun[marka] $urun[model] $urun[seri]'>";
                    echo "<form action='libs/sepete_ekle.php' method='post'>";
                    echo "<img src='image/$urun[resim_adi]' alt ='$urun[marka] $urun[model] $urun[seri]'>";
                    echo "<h3>$urun[marka]</h3>";
                    echo "<h3>$urun[model]</h3>";
                    echo "<h4>$urun[fiyat] TL</h4>";
                    echo "<input type='hidden' name='product_id' value= '$urun[urun_kodu]'>";
                    echo "<button class='sepetekle1' type='submit' title = 'Sepete Ekle'>Sepete Ekle</button>";
                    echo "</form>";
                    echo "</a>";
                endforeach;
                echo "</div>";
            endif;
        }
    }
    ?>
    <?php mysqli_close($baglanti) ?>
    <?php include("parts/avantaj.php") ?>
    <?php include("parts/footer.php") ?>
</body>

</html>
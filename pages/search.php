<?php
require_once("../parts/config.php");
if (isset($_GET["search"])) {
    $input = $_GET["search"];
    

    
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Arama Sonuçları
    </title>
    <link rel="stylesheet" href="../css/index.css">
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
    if (!empty($product)) {
        echo "<h2 class='baslik' style='padding-top: 30px;'>$baslik</h2>";
        echo "<div class='content'>";
        foreach ($product as $urun) {
            echo "<a href='../pages/urun_detay.php?kod=$urun[urun_kodu]' class='product' title = '$urun[marka] $urun[model] $urun[seri]'>";
            echo "<form action='../libs/sepete_ekle.php' method='post'>";
            echo "<img src='../image/$urun[resim_adi]' alt ='$urun[marka] $urun[model] $urun[seri]'>";
            echo "<h3>$urun[marka]</h3>";
            echo "<h3>$urun[model]</h3>";
            echo "<h4>$urun[fiyat] TL</h4>";
            echo "<input type='hidden' name='product_id' value= '$urun[urun_kodu]'>";
            echo "<button class='sepetekle1' type='submit' title = 'Sepete Ekle'>Sepete Ekle</button>";
            echo "</form>";
            echo "</a>";
        }
        echo "</div>";
    }
    ?>
    <?php mysqli_close($baglanti) ?>
</body>

</html>
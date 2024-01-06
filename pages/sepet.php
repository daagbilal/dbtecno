<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php") ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <?php
    if (isLoggedIn()) {
        $stmt = mysqli_prepare($baglanti, "SELECT musteri_id, urun_kodu, miktar FROM sepet WHERE musteri_id= ?");
        mysqli_stmt_bind_param($stmt, "i", $musteri_id);
        $musteri_id = $_SESSION["musteri_id"];
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $sepet_products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        $tutar = 0;
    } else {
        header("Location: ../login.php");
    }
    ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Sepetim</h2>
    <div class="sepet-content">
        <?php include("../parts/user_menu.php") ?>
        <div class="sepet">
            <ul style="padding: 0; margin:0;">
                <?php
                if ($sepet_products) {
                    foreach ($sepet_products as $sepet_product) {
                        $sql = "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM computers
                            WHERE urun_kodu='$sepet_product[urun_kodu]'
                            UNION
                            SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM phones
                            WHERE urun_kodu='$sepet_product[urun_kodu]'
                            UNION
                            SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM televisions
                            WHERE urun_kodu='$sepet_product[urun_kodu]'
                            UNION 
                            SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM tablets
                            WHERE urun_kodu='$sepet_product[urun_kodu]'
                            UNION 
                            SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM smart_watchs
                            WHERE urun_kodu='$sepet_product[urun_kodu]'";

                        $result = mysqli_query($baglanti, $sql);
                        $product = mysqli_fetch_assoc($result);

                        echo "<li class='sepet-urun'>
                                <div class='sepet-baslik'>
                                    <img src='../image/$product[resim_adi]' alt='$product[marka] $product[model] $product[seri]'>
                                    <div style= 'width: 40%;'>
                                    <a href = '../pages/urun_detay.php?kod=$sepet_product[urun_kodu]'><h4>$product[marka] $product[model] $product[seri]</h4></a>
                                    </div>
                                </div>
                                <h4 style= 'width: 35%;'>$product[fiyat] TL</h4>
                                <form action='../libs/urun_kaldir.php' method='post'>
                                    <input type='hidden' name='product_id' value='$sepet_product[urun_kodu]'>
                                    <button class='urun_kaldir' type='submit'>Kaldır</button>
                                </form>
                            </li>";
                        $tutar += ($product["fiyat"]);
                    }
                } else {
                    echo "<div style = 'text-align: center; font-size: 20px'>Sepetiniz Boş</div>";
                }
                ?>
            </ul>
        </div>
        <?php
        if (!empty($sepet_products)) {
            echo "<div class='sepet-tutar'>
                    <h4>Ürünler: $tutar TL</h4>";
            echo "<h2 style='text-align: center;'>Toplam Tutar: $tutar TL</h2>
                    <button class='siparis_ver'>Sipariş Ver</button>
                </div>";
        }
        ?>
    </div>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php") ?>
    <?php include("../parts/footer.php") ?>
</body>

</html>
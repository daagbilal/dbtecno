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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #daddd678;">

    <?php
    include("../parts/index_header.php");
    $sepet_products = 0;
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
    }
    ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Sepetim</h2>
    <div class="sepet-content">
        <?php include("../parts/user_menu.php") ?>
        <div class="sepet">
            <ul class="s-ul">
                <?php
                if ($sepet_products) {
                    foreach ($sepet_products as $sepet_product) {
                        $sql = "SELECT computers.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM computers
                            INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
                            WHERE computers.urun_kodu='$sepet_product[urun_kodu]'
                            UNION
                            SELECT phones.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM phones
                            INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
                            WHERE phones.urun_kodu='$sepet_product[urun_kodu]'
                            UNION
                            SELECT televisions.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM televisions
                            INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
                            WHERE televisions.urun_kodu='$sepet_product[urun_kodu]'
                            UNION 
                            SELECT tablets.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM tablets
                            INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
                            WHERE tablets.urun_kodu='$sepet_product[urun_kodu]'
                            UNION 
                            SELECT smart_watchs.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM smart_watchs
                            INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
                            WHERE smart_watchs.urun_kodu='$sepet_product[urun_kodu]'";
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
                                <button class='urun_kaldir' type='submit' onclick = 'delete_product($sepet_product[urun_kodu])'><i class='fa-solid fa-trash-can fa-lg'></i></button>
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
                    <button class='siparis_ver' onclick='goToPage()'>Sipariş Ver</button>
                </div>";
        }
        ?>
    </div>
    <script>
        function goToPage() {
            window.location.href = 'siparis_onay.php';
        }
    </script>
    <script src="/libs/app.js"></script>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php") ?>
    <?php include("../parts/footer.php") ?>
</body>

</html>
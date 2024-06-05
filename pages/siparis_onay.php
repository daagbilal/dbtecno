<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $stmt = mysqli_prepare($baglanti, "SELECT * FROM adres WHERE musteri_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $musteri_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $adresses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }
    $sql = "SELECT urun_kodu, resim_adi, marka, model, seri, fiyat, miktar
    FROM (
        SELECT computers.urun_kodu, computers.resim_adi, computers.marka, computers.model, computers.seri, sf.fiyat, sepet.miktar
        FROM computers
        INNER JOIN sepet ON computers.urun_kodu = sepet.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT phones.urun_kodu, phones.resim_adi, phones.marka, phones.model, phones.seri, sf.fiyat, sepet.miktar
        FROM phones
        INNER JOIN sepet ON phones.urun_kodu = sepet.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT televisions.urun_kodu, televisions.resim_adi, televisions.marka, televisions.model, televisions.seri, sf.fiyat, sepet.miktar
        FROM televisions
        INNER JOIN sepet ON televisions.urun_kodu = sepet.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT tablets.urun_kodu, tablets.resim_adi, tablets.marka, tablets.model, tablets.seri, sf.fiyat, sepet.miktar
        FROM tablets
        INNER JOIN sepet ON tablets.urun_kodu = sepet.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT smart_watchs.urun_kodu, smart_watchs.resim_adi, smart_watchs.marka, smart_watchs.model, smart_watchs.seri, sf.fiyat, sepet.miktar
        FROM smart_watchs
        INNER JOIN sepet ON smart_watchs.urun_kodu = sepet.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
        WHERE musteri_id = ?
    ) AS combined_result;
    ";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "iiiii", $musteri_id, $musteri_id, $musteri_id, $musteri_id, $musteri_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        if (empty($products)) {
            header("Location: ../index.php");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
}


?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişi Onayla</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #daddd678;">
    <?php include("../parts/index_header.php"); ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Sipariş Onayı</h2>
    <form class="s_onay_content" action="../libs/add_order.php" method="post">
        <div class="order_detail">
            <div class="select_adress">
                <label for="adres">Adres Seçimi: </label><br>
                <?php if (!empty($adresses)) : ?>
                    <select name="adres" id="adres">
                        <?php foreach ($adresses as $adress) : ?>
                            <option value='<?php echo $adress['adres_id'] ?>'><?php echo "[ $adress[title] ] $adress[adres] $adress[ilce]/$adress[il]" ?></option>
                        <?php endforeach; ?>
                    </select><br>
                <?php endif; ?>
                <?php if (empty($adresses)) : ?>
                    <div style="width: 80%; height: 50px;"><a href="adres.php?page=adres-ekle">Adres Ekleyin</a></div>
                <?php endif; ?>
                <div class="alici_iletisim">
                    <div class="alici_ad">Alıcı: <?php echo "$_SESSION[ad] $_SESSION[soyad]" ?></div>
                    <div class="alici_mail">E-Posta: <?php echo "$_SESSION[email]" ?></div>
                    <div class="alici_tel">Telefon: <?php echo "$_SESSION[telefon]" ?></div>
                </div>
            </div>

            <?php if (!empty($products)) : ?>
                <?php $total = 0; ?>
                <div class="order_products">
                    <?php foreach ($products as $product) : ?>
                        <div class="order_product">
                            <div class='order-baslik'>
                                <img src='../image/<?php echo $product['resim_adi'] ?>' alt='<?php echo '$product[marka] $product[model] $product[seri]' ?> '>
                                <div style='width: 40%;'>
                                    <a href='../pages/urun_detay.php?kod=<?php echo $product['urun_kodu'] ?>'>
                                        <h4><?php echo "$product[marka] $product[model]" ?></h4>
                                    </a>
                                </div>
                            </div>
                            <h4><?php echo $product["fiyat"] ?> TL</h4>
                            <h4>Miktar: <?php echo $product["miktar"] ?></h4>
                        </div>
                        <?php $total += ($product["fiyat"] * $product["miktar"]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class='sepet-tutar'>
            <h4>Ürünler: <?php echo $total; ?> TL</h4>
            <h2 style='text-align: center;'>Tutar: <?php echo $total; ?> TL</h2>
            <button type="submit" name="order_submit" class='siparis_ver'>Sipariş Ver</button>
        </div>
    </form>
    <?php include("../parts/footer.php") ?>
    <?php mysqli_close($baglanti) ?>
</body>

</html>
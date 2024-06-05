<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $sql = "SELECT urun_kodu, resim_adi, marka, model, seri, fiyat, miktar, durum, siparis_id, add_time
    FROM (
        SELECT computers.urun_kodu, computers.resim_adi, computers.marka, computers.model, computers.seri, sf.fiyat, orders.miktar, orders.durum, orders.siparis_id, orders.add_time
        FROM computers
        INNER JOIN orders ON computers.urun_kodu = orders.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT phones.urun_kodu, phones.resim_adi, phones.marka, phones.model, phones.seri, sf.fiyat, orders.miktar, orders.durum, orders.siparis_id, orders.add_time
        FROM phones
        INNER JOIN orders ON phones.urun_kodu = orders.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT televisions.urun_kodu, televisions.resim_adi, televisions.marka, televisions.model, televisions.seri, sf.fiyat, orders.miktar, orders.durum, orders.siparis_id, orders.add_time
        FROM televisions
        INNER JOIN orders ON televisions.urun_kodu = orders.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT tablets.urun_kodu, tablets.resim_adi, tablets.marka, tablets.model, tablets.seri, sf.fiyat, orders.miktar, orders.durum, orders.siparis_id, orders.add_time
        FROM tablets
        INNER JOIN orders ON tablets.urun_kodu = orders.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
        WHERE musteri_id = ?
        UNION ALL
        SELECT smart_watchs.urun_kodu, smart_watchs.resim_adi, smart_watchs.marka, smart_watchs.model, smart_watchs.seri, sf.fiyat, orders.miktar, orders.durum, orders.siparis_id, orders.add_time
        FROM smart_watchs
        INNER JOIN orders ON smart_watchs.urun_kodu = orders.urun_kodu
        INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
        WHERE musteri_id = ?
    ) AS combined_result ORDER BY add_time DESC, marka ASC;
    ";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "iiiii", $musteri_id, $musteri_id, $musteri_id, $musteri_id, $musteri_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
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
    <title>Siparişlerim</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #daddd678;">
    <?php include("../parts/index_header.php"); ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Siparişlerim</h2>

    <div class="siparis-content">
        <?php include("../parts/user_menu.php"); ?>
        <div class="siparis">
            <?php if (!empty($orders)) : ?>
                <ul class="s-ul">
                    <?php foreach ($orders as $order) : ?>
                        <li class='siparis-urun'>
                            <div class='siparis-baslik'>
                                <img src='../image/<?php echo $order['resim_adi'] ?>' alt='<?php echo "$order[marka] $order[model] $order[seri]" ?>'>
                                <div style='width: 40%;'>
                                    <a href='../pages/urun_detay.php?kod=<?php echo $order['urun_kodu'] ?>'>
                                        <h4><?php echo "$order[marka] $order[model] $order[seri]" ?></h4>
                                    </a>
                                </div>
                            </div>
                            <div>Sipariş No: <?php echo $order['siparis_id'] ?></div>
                            <div><?php echo $order['fiyat'] ?> TL</div>
                            <div>
                                <?php
                                if ($order["durum"] == 0) {
                                    echo "Siparişiniz alındı";
                                } elseif ($order["durum"] == 1) {
                                    echo "Kargoya verildi";
                                } elseif ($order["durum"] == 2) {
                                    echo "Dağıtıma çıktı";
                                } elseif ($order["durum"] == 3) {
                                    echo "Teslim edildi";
                                }
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if (empty($orders)) : ?>
                <div style='text-align: center; font-size: 20px'>Siparişiniz Yok</div>
            <?php endif; ?>
        </div>

    </div>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php") ?>
    <?php include("../parts/footer.php") ?>
</body>

</html>
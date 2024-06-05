<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    $tarih = date("Y-m-d"); // Bugünün tarihi
    // gelir
    $sql = "SELECT SUM(birim_fiyat * miktar) AS toplam_tutar
    FROM orders
    WHERE durum = 3;
    ";
    $stmt = mysqli_prepare($baglanti, $sql);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result1 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    // satış sayısı
    $sql2 = "SELECT COUNT(durum) AS tam_siparis FROM orders WHERE durum = 3";
    $stmt = mysqli_prepare($baglanti, $sql2);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result3 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    // sipariş sayısı
    $sql3 = "SELECT COUNT(durum) AS siparisler FROM orders WHERE durum = 0";
    $stmt = mysqli_prepare($baglanti, $sql3);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result4 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    $sql4 = "SELECT siparis_id, 
    COALESCE(computers.marka, phones.marka, televisions.marka, tablets.marka, smart_watchs.marka) AS marka,
    COALESCE(computers.model, phones.model, televisions.model, tablets.model, smart_watchs.model) AS model,
    COALESCE(computers.seri, phones.seri, televisions.seri, tablets.seri, smart_watchs.seri) AS seri,
    users.ad,
    users.soyad,
    miktar,
    add_time
FROM orders
LEFT JOIN computers ON computers.urun_kodu = orders.urun_kodu
LEFT JOIN phones ON phones.urun_kodu = orders.urun_kodu
LEFT JOIN televisions ON televisions.urun_kodu = orders.urun_kodu
LEFT JOIN tablets ON tablets.urun_kodu = orders.urun_kodu
LEFT JOIN smart_watchs ON smart_watchs.urun_kodu = orders.urun_kodu
LEFT JOIN users ON users.id = orders.musteri_id
WHERE orders.durum = 0;
";
    $stmt = mysqli_prepare($baglanti, $sql4);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result5 = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }
    // SQL sorgusu
    $sql5 = "SELECT COUNT(siparis_id) AS gunluk_siparis
    FROM orders
    WHERE add_time LIKE '$tarih%'";
    $stmt = mysqli_prepare($baglanti, $sql5);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result6 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($baglanti);
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="panel.css">
    <title>Sipariş Yönetimi</title>
</head>

<body>
    <div class="main-div">
        <?php include("partials/options.php"); ?>
        <div class="dashboard-div">
            <?php include("partials/header.php"); ?>
            <div class="content">
                <div class="info_products">
                    <div class="infobox">
                        <h3>Gelir</h3>
                        <div class="numbers"><?php echo "$result1[toplam_tutar] TL" ?></div>
                    </div>
                    <div class="infobox">
                        <h3>Satış Sayısı</h3>
                        <div class="numbers"><?php echo $result3["tam_siparis"] ?></div>
                    </div>
                    <div class="infobox">
                        <h3>Bek. Sipariş Sayısı</h3>
                        <div class="numbers"><?php echo $result4["siparisler"] ?></div>
                    </div>
                    <div class="infobox">
                        <h3>Günlük Sipariş Sayısı</h3>
                        <div class="numbers"><?php echo $result6["gunluk_siparis"] ?></div>
                    </div>
                </div>
                <h3 style="margin: 10px; padding: 0;">Sipariş Bekleyen Ürünler</h3>
                <div class="product-list">
                    <table>
                        <tr>
                            <th>Sipariş ID</th>
                            <th>Ürün AD</th>
                            <th>Müşteri AD</th>
                            <th>Miktar</th>
                            <th>Sipariş Tarihi</th>
                            <th></th>

                        </tr>
                        <!-- php kodu -->
                        <?php
                        foreach ($result5 as $result) :
                        ?>
                            <tr>
                                <td><?php echo $result["siparis_id"] ?></td>
                                <td><?php echo "$result[marka] $result[model] $result[seri]" ?></td>
                                <td><?php echo "$result[ad] $result[soyad]" ?></td>
                                <td><?php echo $result["miktar"] ?></td>
                                <td><?php echo $result["add_time"] ?></td>
                                <td>
                                    <button class="blue-button button-order" onclick="kargola(<?php echo $result['siparis_id'] ?>)">Kargola</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- /php kodu  -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function kargola(urun_id) {
            const apiurl = "/admin/partials/kargola.php?id=" + urun_id;
            const options = {
                method: 'GET'
            }
            fetch(apiurl,options).then(response => response.json())
            .then(data => {
                const mesaj = data.mesaj;
                alert(mesaj);
                window.location.reload();
            }).catch(error => {
                console.error("Hata:", error);
            });
        }
    </script>
</body>

</html>
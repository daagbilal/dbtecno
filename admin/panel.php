<?php 
    require_once("../parts/config.php");
    require("../libs/functions.php");
    session_start();
    if (isAdminLoggedIn()) {
        // Ürün Sayısı
        $sql = "SELECT COUNT(DISTINCT urun_kodu) AS urun_sayisi
        FROM (
            SELECT urun_kodu FROM computers
            UNION ALL
            SELECT urun_kodu FROM phones
            UNION ALL
            SELECT urun_kodu FROM televisions
            UNION ALL
            SELECT urun_kodu FROM tablets
            UNION ALL
            SELECT urun_kodu FROM smart_watchs
        ) AS combined_result;
        ";

        $stmt = mysqli_prepare($baglanti, $sql);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $result1 = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
        // ^^^^^^
        // Stok Sayısı
        $sql1 = "SELECT SUM(stok) AS stoklar
        FROM (
            SELECT sf.stok FROM computers
            INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
            UNION ALL
            SELECT sf.stok FROM phones
            INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
            UNION ALL
            SELECT sf.stok FROM televisions
            INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
            UNION ALL
            SELECT sf.stok FROM tablets
            INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
            UNION ALL
            SELECT sf.stok FROM smart_watchs
            INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
        ) AS combined_result;
        ";
        $stmt = mysqli_prepare($baglanti, $sql1);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $result2 = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
        // ^^^^^^^^^^
        // Tamamlanan Sipariş Sayısı
        $sql2 = "SELECT COUNT(durum) AS tam_siparis FROM orders WHERE durum = 3";
        $stmt = mysqli_prepare($baglanti, $sql2);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $result3 = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
        //^^^^^^^^
        // Bekleyen Siparisler
        $sql3 = "SELECT COUNT(durum) AS siparisler FROM orders WHERE durum = 0";
        $stmt = mysqli_prepare($baglanti, $sql3);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $result4 = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
        //^^^^^^^^^^^^
        $sql4 = "SELECT 
        COALESCE(c.urun_kodu, h.urun_kodu, t.urun_kodu, tv.urun_kodu, sw.urun_kodu) AS urun_kodu,
        COALESCE(c.marka, h.marka, t.marka, tv.marka, sw.marka) AS urun_marka,
        COALESCE(c.model, h.model, t.model, tv.model, sw.model) AS urun_model,
        COALESCE(c.seri, h.seri, t.seri, tv.seri, sw.seri) AS urun_seri,
        COALESCE(sf.stok) AS urun_stok,
        COUNT(o.siparis_id) AS order_count,
        SUM(CASE WHEN o.durum = 0 THEN 1 ELSE 0 END) AS durum_0_count,
        SUM(CASE WHEN o.durum = 3 THEN 1 ELSE 0 END) AS durum_3_count
    FROM orders o
    LEFT JOIN computers c ON o.urun_kodu = c.urun_kodu
    LEFT JOIN phones h ON o.urun_kodu = h.urun_kodu
    LEFT JOIN tablets t ON o.urun_kodu = t.urun_kodu
    LEFT JOIN televisions tv ON o.urun_kodu = tv.urun_kodu
    LEFT JOIN smart_watchs sw ON o.urun_kodu = sw.urun_kodu
    LEFT JOIN stokfiyat sf ON sf.urun_kodu = o.urun_kodu
    GROUP BY urun_kodu, urun_marka, urun_model, urun_seri, urun_stok
    ORDER BY durum_3_count DESC, urun_marka ASC
    LIMIT 10;
    ";
        $stmt = mysqli_prepare($baglanti, $sql4);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $result5 = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
        }


    }else {
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
    <title>Dashboard</title>
</head>
<body>
    <div class="main-div">
        <?php include("partials/options.php");?>
        <div class="dashboard-div">
            <?php include("partials/header.php");?>
            <div class="content">
                <div class="info_products">
                    <div class="infobox">
                        <h3>Ürün Sayısı</h3>
                        <div class="numbers"><?php echo $result1["urun_sayisi"]?></div>
                    </div>
                    <div class="infobox">
                        <h3>Stok</h3>
                        <div class="numbers"><?php echo $result2["stoklar"]?></div>
                    </div>
                    <div class="infobox">
                        <h3>Satış Sayısı</h3>
                        <div class="numbers"><?php echo $result3["tam_siparis"]?></div>
                    </div>
                    <div class="infobox">
                        <h3>Bekleyen Sipariş</h3>
                        <div class="numbers"><?php echo $result4["siparisler"]?></div>
                    </div>
                </div>
                <h3 style="margin: 10px; padding: 0;">Satan Ürünler Listesi</h3>
                <div class="product-list">
                    <table>
                        <tr>
                            <th>Sıra</th>
                            <th>Ürün Kodu</th>
                            <th>Ürün Adı</th>
                            <th>Satış Sayısı</th>
                            <th>Bekleyen Sipariş Sayısı</th>
                            <th>Stok</th>
                        </tr>
                        <!-- php kodu -->
                        <?php 
                        $sayac = 0;
                        foreach($result5 as $result):
                            $sayac++;
                        ?>
                        <tr>
                            <td><?php echo $sayac; ?></td>
                            <td><?php echo $result["urun_kodu"]?></td>
                            <td><?php echo "$result[urun_marka] $result[urun_model] $result[urun_seri]"?></td>
                            <td><?php echo $result["durum_3_count"]?></td>
                            <td><?php echo $result["durum_0_count"]?></td>
                            <td><?php echo $result["urun_stok"]?></td>
                        </tr>
                        <?php endforeach;?>
                        <!-- /php kodu  -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
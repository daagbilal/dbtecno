<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    $sql = "SELECT SUM(stok) AS stoklar
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
        ) AS combined_result;";
    $stmt = mysqli_prepare($baglanti, $sql);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result1 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }

    $sql4 = "SELECT urun_kodu, marka, model, seri, stok, fiyat, kategori 
    FROM (SELECT computers.urun_kodu, marka, model, seri, sf.stok, sf.fiyat, kategori FROM computers
    INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
            UNION ALL
            SELECT phones.urun_kodu, marka, model, seri, sf.stok, sf.fiyat, kategori FROM phones
            INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
            UNION ALL
            SELECT televisions.urun_kodu, marka, model, seri, sf.stok, sf.fiyat, kategori FROM televisions
            INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
            UNION ALL
            SELECT tablets.urun_kodu, marka, model, seri, sf.stok, sf.fiyat, kategori FROM tablets
            INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
            UNION ALL
            SELECT smart_watchs.urun_kodu, marka, model, seri, sf.stok, sf.fiyat, kategori FROM smart_watchs
            INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu) 
    AS urunler";
    $stmt = mysqli_prepare($baglanti, $sql4);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result5 = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>Stok ve Fiyat Yönetimi</title>
</head>

<body>
    <div class="main-div">
        <?php include("partials/options.php"); ?>
        <div class="dashboard-div">
            <?php include("partials/header.php"); ?>
            <div class="content">
                <div class="info_products">
                    <div class="infobox">
                        <h3>Stok</h3>
                        <div class="numbers"><?php echo $result1["stoklar"] ?></div>
                    </div>
                </div>
                <div class="product-list">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Ürün AD</th>
                            <th>Stok Miktarı</th>
                            <th>Fiyat</th>
                            <th>Kategori</th>
                            <th></th>
                            <th></th>

                        </tr>
                        <!-- php kodu -->
                        <?php
                        foreach ($result5 as $result) :
                        ?>
                            <tr>
                                <td><?php echo $result["urun_kodu"] ?></td>
                                <td><?php echo "$result[marka] $result[model] $result[seri]" ?></td>
                                <td><?php echo $result["stok"] ?></td>
                                <td><?php echo $result["fiyat"] ?></td>
                                <td><?php echo $result["kategori"] ?></td>
                                <td>
                                    <button class="button-order blue-button" onclick="fiyatguncelle(<?php echo $result['urun_kodu'] ?>)">Fiyat Güncelle</button>
                                </td>
                                <td>
                                    <form action="./partials/stokguncelle.php" method="post">
                                        <input type="hidden" name="urun_id" value="<?php echo $result["urun_kodu"] ?>">
                                        <input style="width: 50px;" type="text" name="guncelstok" value="<?php echo $result["stok"] ?>">
                                        <button class="button-order blue-button" name="stokguncelle" type="submit">Stok Güncelle</button>
                                    </form>
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
        function fiyatguncelle(urun_id) {
            const apiurl = "/admin/partials/curl.php?id=" + urun_id;
            const options = {
                method: 'GET'
            }
            fetch(apiurl, options)
                .then(response => response.json())
                .then(data => {
                    const mesaj = data.mesaj;
                    alert(mesaj);
                    window.location.reload();
                })
                .catch(error => {
                    console.error("Hata: ", error)
                });
        }
    </script>
</body>

</html>
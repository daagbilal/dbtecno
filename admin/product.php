<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    $sql = "SELECT computers.urun_kodu, marka, model, seri, sf.fiyat, sf.stok, kategori FROM computers
        INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
        UNION ALL
        SELECT phones.urun_kodu, marka, model, seri, sf.fiyat, sf.stok, kategori FROM phones
        INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
        UNION ALL
        SELECT televisions.urun_kodu, marka, model, seri, sf.fiyat, sf.stok, kategori FROM televisions
        INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
        UNION ALL
        SELECT tablets.urun_kodu, marka, model, seri, sf.fiyat, sf.stok, kategori FROM tablets
        INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
        UNION ALL
        SELECT smart_watchs.urun_kodu, marka, model, seri, sf.fiyat, sf.stok, kategori FROM smart_watchs
        INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
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
    <title>Ürün Yönetimi</title>
</head>

<body>
    <div class="main-div">
        <?php include("partials/options.php"); ?>
        <div class="dashboard-div">
            <?php include("partials/header.php"); ?>
            <div class="content">
                <div class="control-buttons">
                    <select class="product-select">
                        <option value="0">Tümü</option>
                    </select>
                    <div class="product-buttons">
                        <a href="./add_product.php" class="button-product green-button">Ürün Ekle</a>
                    </div>
                </div>
                <div class="product-list">
                    <table>
                        <tr>
                            <th>Ürün Kodu</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th></th>
                        </tr>
                        <?php foreach ($data as $d) : ?>
                            <tr>
                                <td><?php echo $d["urun_kodu"]; ?></td>
                                <td><?php echo "$d[marka] $d[model] $d[seri]"; ?></td>
                                <td><?php echo "$d[fiyat] TL"; ?></td>
                                <td><?php echo $d["stok"]; ?></td>
                                <td><?php echo $d["kategori"]; ?></td>
                                <td>
                                    <button class="button-product blue-button" onclick="edit_product(<?php echo $d['urun_kodu'] ?>)">Düzenle</button>
                                    <button class="button-product red-button" onclick="delproduct(<?php echo $d['urun_kodu'] ?>)">Sil</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function edit_product(urun_id) {
            window.location.href = "./edit_product.php?product_id=" + urun_id;
        }
        function delproduct(urun_id) {
            const apiurl = "/admin/partials/del_product.php?id=" + urun_id;
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
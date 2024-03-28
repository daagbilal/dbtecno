<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    $sql = "SELECT urun_kodu, marka, model, seri, fiyat, stok, kategori FROM computers
        UNION ALL
        SELECT urun_kodu, marka, model, seri, fiyat, stok, kategori FROM phones
        UNION ALL
        SELECT urun_kodu, marka, model, seri, fiyat, stok, kategori FROM televisions
        UNION ALL
        SELECT urun_kodu, marka, model, seri, fiyat, stok, kategori FROM tablets
        UNION ALL
        SELECT urun_kodu, marka, model, seri, fiyat, stok, kategori FROM smart_watchs";

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
                        <button class="button-product green-button">Ürün Ekle</button>
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
                        <!-- php kodu -->
                        <?php foreach ($data as $d) : ?>
                            <tr>
                                <td><?php echo $d["urun_kodu"]; ?></td>
                                <td><?php echo "$d[marka] $d[model] $d[seri]"; ?></td>
                                <td><?php echo "$d[fiyat] TL"; ?></td>
                                <td><?php echo $d["stok"]; ?></td>
                                <td><?php echo $d["kategori"]; ?></td>
                                <td>
                                    <button class="button-product blue-button btn-primary" data-id="<?php echo $d['urun_kodu'] ?>">Düzenle</button>
                                    <button class="button-product red-button btn-danger">Sil</button>
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
        const editButtons = document.querySelectorAll(".btn-primary");
        const deleteButtons = document.querySelectorAll(".btn-danger");

        editButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const productId = button.dataset.id;

                const url = "edit_product.php";
                const options = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        productId,
                    }),
                };

                fetch(url, options)
                    .then((response) => {
                        if (response.ok) {
                            window.location.href = url;
                        } else {
                            alert("Ürün düzenlenemedi!");
                        }
                    })
                    .catch((error) => {
                        alert("Bir hata oluştu!");
                    });
            });
        });

        deleteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const productId = button.dataset.id;

                const url = "partials/del_product.php";
                const options = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        productId,
                    }),
                };

                fetch(url, options)
                    .then((response) => {
                        if (response.ok) {
                            alert("Ürün başarıyla silindi!");
                        } else {
                            // Hata mesajı göster
                            alert("Ürün silinemedi!");
                        }
                    })
                    .catch((error) => {
                        // Ağ hatası gibi durumlarda hata mesajı göster
                        alert("Bir hata oluştu!");
                    });
            });
        });
    </script>
</body>

</html>
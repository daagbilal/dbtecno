<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    $sql = "SELECT COUNT(id) AS musteriler FROM users;";

    $stmt = mysqli_prepare($baglanti, $sql);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result1 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    // ^^^^^^
    // Günlük Müşteri Sayısı
    // Tarih seçimi
    $tarih = date("Y-m-d"); // Bugünün tarihi

    // SQL sorgusu
    $sql1 = "SELECT COUNT(id) AS login_customer
    FROM users
    WHERE login_time LIKE '$tarih%'";
    $stmt = mysqli_prepare($baglanti, $sql1);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result2 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    // ^^^^^^^^^^
    // Tamamlanan Sipariş Sayısı
    $sql2 = "SELECT COUNT(id) AS aktif_hesaplar
    FROM users WHERE durum = 1";
    $stmt = mysqli_prepare($baglanti, $sql2);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $result3 = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    $sql4 = "SELECT id, ad, soyad, e_posta, telefon, durum, login_time FROM users ORDER BY durum;";
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
    <title>Müşteri Yönetimi</title>
</head>

<body>
    <div class="main-div">
        <?php include("partials/options.php"); ?>
        <div class="dashboard-div">
            <?php include("partials/header.php"); ?>
            <div class="content">
                <div class="info_products">
                    <div class="infobox">
                        <h3>Müşteri Sayısı</h3>
                        <div class="numbers"><?php echo $result1["musteriler"] ?></div>
                    </div>
                    <div class="infobox">
                        <h3>Günlük Giriş Sayısı</h3>
                        <div class="numbers"><?php echo $result2["login_customer"] ?></div>
                    </div>
                    <div class="infobox">
                        <h3>Aktif Hesap Sayısı</h3>
                        <div class="numbers"><?php echo $result3["aktif_hesaplar"] ?></div>
                    </div>
                </div>
                <div class="product-list">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>E-Posta</th>
                            <th>Telefon</th>
                            <th>Hesap Durumu</th>
                            <th>Giriş Tarihi</th>
                            <th></th>

                        </tr>
                        <!-- php kodu -->
                        <?php
                        foreach ($result5 as $result) :
                        ?>
                            <tr>
                                <td><?php echo $result["id"] ?></td>
                                <td><?php echo "$result[ad] $result[soyad]" ?></td>
                                <td><?php echo $result["e_posta"] ?></td>
                                <td><?php echo $result["telefon"] ?></td>
                                <td><?php
                                    $durum = $result["durum"];
                                    if ($durum == 1) {
                                        echo "Aktif";
                                    } else if ($durum == 0) {
                                        echo "Pasif";
                                    }
                                    ?></td>
                                <td><?php echo $result["login_time"] ?></td>
                                <td>
                                    <?php
                                    if ($result["durum"] == 0) {
                                        echo "
                                            <button class='blue-button button-order' onclick = 'hesapdurum(0, $result[id])'>Aktif Et</button>";
                                    } else if ($result["durum"] == 1) {
                                        echo "
                                            <button class='red-button button-order' onclick = 'hesapdurum(1, $result[id])'>Pasif Et</button>";
                                    }
                                    ?>
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
        function hesapdurum(durum, musteri_id) {
            let sdurum = 0
            if (durum == 0) {
                sdurum = "aktif";
            }else if (durum == 1) {
                sdurum = "pasif";
            }
            const apiurl = "/admin/partials/hesapislem.php?id=" + musteri_id + "&islem=" + sdurum;
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
                    console.error("Hata:", error);
                });
        }
    </script>
</body>

</html>
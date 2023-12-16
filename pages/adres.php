<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    if ($_GET["page"] == "adres-duzenle") {
        if (isset($_POST["adres_id"])) {
            $_SESSION["adres_id"] = $_POST["adres_id"];
        }
        $adres_id = $_SESSION["adres_id"];
        $stmt = mysqli_prepare($baglanti, "SELECT * FROM adres WHERE adres_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $adres_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bilgi = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["adres_submit"])) {

            $sql = "UPDATE adres SET ad = ?, soyad = ?, telefon = ?, title = ?, il = ?, ilce = ?, adres = ? WHERE adres_id = ?";

            $stmt = mysqli_prepare($baglanti, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssi", $name, $surname, $phone, $title, $il, $ilce, $adres, $adres_id);

            $name = safe_html($_POST["name"]);
            $surname = safe_html($_POST["surname"]);
            $phone = safe_html($_POST["phone"]);
            $title = safe_html($_POST["title"]);
            $il = safe_html($_POST["il"]);
            $ilce = safe_html($_POST["ilce"]);
            $adres = safe_html($_POST["adres"]);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
} else {
    header("Location: ../index.php");
}
mysqli_close($baglanti);

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Profilim</title>
</head>

<body>
    <div class="address-div">
        <?php if ($_GET["page"] == "adres-duzenle") : ?>
            <form class="address-form" action="adres.php?page=adres-duzenle" method="post">
                <h2>Adres Düzenle</h2>
                <input name="name" type="text" placeholder="Ad" value="<?php if (isset($_POST["adres-submit"])) {
                                                                            echo $_POST["name"];
                                                                        } else {
                                                                            echo $bilgi["ad"];
                                                                        } ?>"><br>
                <input name="surname" type="text" placeholder="Soyad" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                    echo $_POST["surname"];
                                                                                } else {
                                                                                    echo $bilgi["soyad"];
                                                                                } ?>"><br>
                <input name="phone" type="text" placeholder="Telefon(5510001234)" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                                echo $_POST["phone"];
                                                                                            } else {
                                                                                                echo $bilgi["telefon"];
                                                                                            } ?>"><br>
                <input name="title" type="text" placeholder="Adres Başlığı" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                        echo $_POST["title"];
                                                                                    } else {
                                                                                        echo $bilgi["title"];
                                                                                    } ?>"><br>
                <input name="il" type="text" placeholder="İl" value="<?php if (isset($_POST["adres-submit"])) {
                                                                            echo $_POST["il"];
                                                                        } else {
                                                                            echo $bilgi["il"];
                                                                        } ?>"><br>
                <input name="ilce" type="text" placeholder="İlçe" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                echo $_POST["ilce"];
                                                                            } else {
                                                                                echo $bilgi["ilce"];
                                                                            } ?>"><br>
                <textarea name="adres" rows="4" placeholder="Adres"><?php if (isset($_POST["adres-submit"])) {
                                                                        echo $_POST["adres"];
                                                                    } else {
                                                                        echo $bilgi["adres"];
                                                                    } ?></textarea><br>
                <button type="submit" name="adres-submit">Kaydet</button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>
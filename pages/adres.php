<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $message = "";
    if ($_GET["page"] == "adres-ekle") {
        if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["adres-submit"])) {

            $sql = "INSERT INTO adres (musteri_id,title,il,ilce,adres) VALUES (?,?,?,?,?)";

            $stmt = mysqli_prepare($baglanti, $sql);
            mysqli_stmt_bind_param($stmt, "issss", $musteri_id, $title, $il, $ilce, $adres);

            $title = safe_html($_POST["title"]);
            $il = safe_html($_POST["il"]);
            $ilce = safe_html($_POST["ilce"]);
            $adres = safe_html($_POST["adres"]);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: profile.php?page=2");
                exit();
            } else {
                $message = "Bir hata oluştu.";
            }
            mysqli_stmt_close($stmt);
        }
    } elseif ($_GET["page"] == "adres-duzenle") {
        if (isset($_POST["adres-id"])) {
            $_SESSION["adres_id"] = $_POST["adres-id"];
        }
        $adres_id = $_SESSION["adres_id"];
        $stmt = mysqli_prepare($baglanti, "SELECT * FROM adres WHERE adres_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $adres_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bilgi = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["adres-submit"])) {

            $sql = "UPDATE adres SET title = ?, il = ?, ilce = ?, adres = ? WHERE adres_id = ?";

            $stmt = mysqli_prepare($baglanti, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $title, $il, $ilce, $adres, $adres_id);

            $title = safe_html($_POST["title"]);
            $il = safe_html($_POST["il"]);
            $ilce = safe_html($_POST["ilce"]);
            $adres = safe_html($_POST["adres"]);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: profile.php?page=2");
                exit();
            } else {
                $message = "Bir hata oluştu.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        header("Location: profile.php?page=2");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        function del() {
            window.location.href = "../libs/adres_sil.php?adres_id=<?php echo $adres_id ?>";
        }
    </script>
    <title>Profilim</title>
</head>

<body>
    <div class="address-div">
        <?php if ($_GET["page"] == "adres-duzenle") : ?>
            <div class="address-form">
                <form action="adres.php?page=adres-duzenle" method="post">
                    <h2>Adres Güncelle</h2>
                    <input name="title" type="text" placeholder="Adres Başlığı" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                            echo $_POST["title"];
                                                                                        } else {
                                                                                            echo $bilgi["title"];
                                                                                        } ?>" required><br>
                    <input name="il" type="text" placeholder="İl" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                echo $_POST["il"];
                                                                            } else {
                                                                                echo $bilgi["il"];
                                                                            } ?>" required><br>
                    <input name="ilce" type="text" placeholder="İlçe" value="<?php if (isset($_POST["adres-submit"])) {
                                                                                    echo $_POST["ilce"];
                                                                                } else {
                                                                                    echo $bilgi["ilce"];
                                                                                } ?>" required><br>
                    <textarea name="adres" rows="4" placeholder="Adres" required><?php if (isset($_POST["adres-submit"])) {
                                                                                        echo $_POST["adres"];
                                                                                    } else {
                                                                                        echo $bilgi["adres"];
                                                                                    } ?></textarea><br>
                    <span><?php echo $message ?></span>
                    <button type="submit" name="adres-submit">Güncelle</button>
                </form>
                <button onclick="del()">Adres Sil</button>
            </div>
        <?php endif; ?>
        <?php if ($_GET["page"] == "adres-ekle") : ?>
            <form class="address-form" action="adres.php?page=adres-ekle" method="post">
                <h2>Adres Ekle</h2>
                <input name="title" type="text" placeholder="Adres Başlığı" required><br>
                <input name="il" type="text" placeholder="İl" required><br>
                <input name="ilce" type="text" placeholder="İlçe" required><br>
                <textarea name="adres" rows="4" placeholder="Adres" required></textarea><br>
                <span><?php echo $message ?></span>
                <button type="submit" name="adres-submit">Kaydet</button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>
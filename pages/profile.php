<?php
require("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];

    $result = mysqli_query($baglanti, "SELECT id,ad,soyad,dogum_tarih,cinsiyet FROM users WHERE id = '$musteri_id'");
    $bilgi = mysqli_fetch_assoc($result);

    $pswdErr = $newpswdErr = $pswdmessage = "";

    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-user"])) {

        $stmt = mysqli_prepare($baglanti, "UPDATE users SET ad = ?, soyad = ?, dogum_tarih = ?, cinsiyet = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $ad, $soyad, $dogum_tarih, $cinsiyet, $musteri_id);

        $ad = safe_html($_POST["ad"]);
        $soyad = safe_html($_POST["soyad"]);
        $dogum_tarih = safe_html($_POST["tarih"]);
        $cinsiyet = safe_html($_POST["cinsiyet"]);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION["ad"] = $ad;
        $_POST = array();
    }

    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-pswd"])) {
        $mevcut_sifre = safe_html($_POST["password"]);

        $stmt = mysqli_prepare($baglanti, "SELECT sifre FROM users WHERE id= ?");
        mysqli_stmt_bind_param($stmt, "i", $musteri_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if (password_verify($mevcut_sifre, $user["sifre"])) {
            $newpswd = safe_html($_POST["newpassword"]);
            $renewpswd = safe_html($_POST["renewpassword"]);

            if ($mevcut_sifre != $newpswd) {

                if (($newpswd == $renewpswd)) {
                    if (strlen($newpswd) < 8) {
                        $newpswdErr = "Lütfen en az 8 haneli şifre oluşturunuz.<br>";
                    } elseif (strlen($newpswd) > 15) {
                        $newpswdErr = "En fazla 15 haneli şifre oluşturabilirsiniz.<br>";
                    } else {
                        $hash_pswd = password_hash($newpswd, PASSWORD_DEFAULT);

                        $stmt = mysqli_prepare($baglanti, "UPDATE users SET sifre= ? WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "si", $hash_pswd, $musteri_id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        $pswdmessage = "Şifreniz değiştirildi.";
                    }
                } else {
                    $newpswdErr = "Lütfen yeni şifrenizi aynı giriniz.<br>";
                }
            } else {
                $newpswdErr = "Yeni şifreniz mevcut şifre ile aynı olamaz.<br>";
            }
        } else {
            $pswdErr = "Hatalı şifre girildi.<br>";
        }
    }
} else {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <h2 style="text-align: center;">Kullanıcı Bilgilerim</h2>
    <div class="profile-content">
        <?php include("../parts/user_menu.php"); ?>
        <div class="user-pr">
            <form action="profile.php" method="post">
                <h3>Üyelik Bilgilerim</h3>
                <label for="name">Ad:</label><br>
                <input type="text" name="ad" id="name" value="<?php if (isset($_POST["update-user"])) {
                                                                    echo $ad;
                                                                } else {
                                                                    echo $bilgi["ad"];
                                                                } ?>"><br>
                <label for="surname">Soyad:</label><br>
                <input type="text" name="soyad" id="surname" value="<?php if (isset($_POST["update-user"])) {
                                                                        echo $soyad;
                                                                    } else {
                                                                        echo $bilgi["soyad"];
                                                                    } ?>"><br>
                <label for="date">Doğum Tarihi:</label><br>
                <input type="date" name="tarih" id="date" value="<?php if (isset($_POST["update-user"])) {
                                                                        echo $dogum_tarih;
                                                                    } else {
                                                                        echo $bilgi["dogum_tarih"];
                                                                    } ?>"><br>
                <span>Cinsiyet:</span><br>
                <input type="radio" name="cinsiyet" id="erkek" value="Erkek" <?php if (isset($_POST["update-user"]) && $cinsiyet == "Erkek") {
                                                                                    echo 'checked';
                                                                                } elseif ($bilgi["cinsiyet"] == "Erkek") {
                                                                                    echo 'checked';
                                                                                } ?>><label for="erkek">Erkek</label>
                <input type="radio" name="cinsiyet" id="kadın" value="Kadın" <?php if (isset($_POST["update-user"]) && $cinsiyet == "Kadın") {
                                                                                    echo 'checked';
                                                                                } elseif ($bilgi["cinsiyet"] == "Kadın") {
                                                                                    echo 'checked';
                                                                                } ?>><label for="kadın">Kadın</label><br>
                <button type="submit" name="update-user">Güncelle</button>
            </form>
        </div>
        <div class="pswd">
            <form action="profile.php" method="post">
                <h3>Şifre Güncelleme</h3>
                <label for="password">Mevcut Şifre:</label><br>
                <input type="password" name="password" id="password" required><br>
                <span class="uyari"><?php echo $pswdErr ?></span>
                <label for="newpassword">Yeni Şifre:</label><br>
                <input type="password" name="newpassword" id="newpassword" required><br>
                <span class="uyari"><?php echo $newpswdErr ?></span>
                <label for="renewpassword">Yeni Şifre(Tekrar):</label><br>
                <input type="password" name="renewpassword" id="renewpassword" required><br>
                <span class="uyari"><?php echo $pswdmessage ?></span>
                <button type="submit" name="update-pswd">Şifreyi Güncelle</button>
            </form>
        </div>
    </div>

    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/footer.php") ?>

</body>

</html>
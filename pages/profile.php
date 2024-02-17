<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $stmt = mysqli_prepare($baglanti, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $musteri_id);
    $musteri_id = $_SESSION["musteri_id"];
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bilgi = mysqli_fetch_assoc($result);
} else {
    header("Location: ../index.php");
}
?>
<?php

if ($_GET["page"] == 1) {

    $pswdErr = $newpswdErr = $pswdmessage = $message = "";

    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-pswd"])) {
        $mevcut_sifre = safe_html($_POST["password"]);

        $stmt = mysqli_prepare($baglanti, "SELECT sifre FROM users WHERE id= ?");
        mysqli_stmt_bind_param($stmt, "i", $musteri_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        $newpswd = safe_html($_POST["newpassword"]);
        $renewpswd = safe_html($_POST["renewpassword"]);

        if (password_verify($mevcut_sifre, $user["sifre"])) {
            if ($mevcut_sifre != $newpswd) {
                if ($newpswd == $renewpswd) {
                    if (strlen($newpswd) < 8) {
                        $pswdErr = "Şifreniz en az 8 haneli olmalı.<br>";
                    } elseif (strlen($newpswd) > 15) {
                        $pswdErr = "Şifreniz en fazla 15 haneli olmalı.<br>";
                    } else {
                        $hash_pswd = password_hash($newpswd, PASSWORD_DEFAULT);
                        $stmt = mysqli_prepare($baglanti, "UPDATE users SET sifre= ? WHERE id= ?");
                        mysqli_stmt_bind_param($stmt, "si", $hash_pswd, $musteri_id);
                        if (mysqli_stmt_execute($stmt)) {
                            $pswdmessage = "Şifreniz değiştirildi.<br>";
                        } else {
                            $pswdmessage = "Bir hata oluştu.";
                        }
                        mysqli_stmt_close($stmt);
                        mysqli_close($baglanti);
                    }
                } else {
                    $pswdErr = "Yeni şifreniz eşleşmiyor.<br>";
                }
            } else {
                $newpswdErr = "Lütfen farklı bir şifre oluşturun.<br>";
            }
        } else {
            $pswdErr = "Yanlış şifre girdiniz.<br>";
        }
    }

    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-user"])) {

        $stmt = mysqli_prepare($baglanti, "UPDATE users SET ad = ?, soyad = ?, dogum_tarih = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $ad, $soyad, $dogum_tarih, $musteri_id);

        $ad = safe_html($_POST["ad"]);
        $soyad = safe_html($_POST["soyad"]);
        $dogum_tarih = safe_html($_POST["tarih"]);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Bilgileriniz değiştirildi.";

            $_SESSION["ad"] = $ad;
        } else {
            $message = "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
    }
} elseif ($_GET["page"] == 2) {
    $phone = $email = "";
    $phoneErr = $emailErr = $message = "";
    $stmt = mysqli_prepare($baglanti, "SELECT adres_id,title,adres FROM adres WHERE musteri_id= ?");
    mysqli_stmt_bind_param($stmt, "i", $musteri_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $address = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-contact"])) {

        if (empty($_POST["phone"])) {
            $phoneErr = "Lütfen telefon numaranızı giriniz.";
        } elseif (!filter_var($_POST["phone"], FILTER_VALIDATE_INT)) {
            $phoneErr = "Telefon numarası sayısal değer içermeli.";
        } elseif (!preg_match('/^\d{10}$/', $_POST["phone"])) {
            $phoneErr = "Telefon Numaranız 10 haneli olmalı.";
        } else {
            $phone = safe_html($_POST["phone"]);
        }
        if (empty($_POST["email"])) {
            $emailErr = "Lütfen e-posta adresi giriniz.";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Geçersiz e-posta biçimi.";
        } else {
            $sql = "SELECT id FROM users WHERE e_posta=?";

            if ($stmt = mysqli_prepare($baglanti, $sql)) {
                $param_email = safe_html($_POST["email"]);
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $emailErr = "E-Posta zaten kayıtlı.";
                    } else {
                        $email = safe_html($_POST["email"]);
                    }
                } else {
                    echo mysqli_error($baglanti);
                    echo "Bir Hata Oluştu.";
                }
            }
        }

        if (empty($phoneErr) && (empty($emailErr))) {
            $stmt = mysqli_prepare($baglanti, "UPDATE users SET telefon = ?, e_posta = ? WHERE id= ?");
            mysqli_stmt_bind_param($stmt, "ssi", $param_phone, $param_email, $musteri_id);

            $param_phone = $phone;
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                $message = "Bilgileriniz değiştirildi.";
                $_SESSION["email"] = $email;
                $_SESSION["telefon"] = $phone;
            } else {
                $message = "Bir hata oluştu.";
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function add() {
            window.location.href = "adres.php?page=adres-ekle";
        }
    </script>
</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <h2 style="text-align: center;">Kullanıcı Bilgilerim</h2>
    <div class="profile-content">
        <?php include("../parts/user_menu.php"); ?>
        <?php if ($_GET["page"] == 1) : ?>
            <div class="user-pr">
                <form action="profile.php?page=1" method="post">
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
                    <span class="uyari"><?php echo $message ?></span>

                    <button type="submit" name="update-user">Güncelle</button>
                </form>
            </div>
            <div class="pswd">
                <form action="profile.php?page=1" method="post">
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
        <?php endif; ?>
        <?php if ($_GET["page"] == 2) : ?>
            <div class="user-pr">
                <form action="profile.php?page=2" method="post">
                    <h3>İletişim Bilgilerim</h3>
                    <label for="phone">Telefon Numarası:</label><br>
                    <input type="text" name="phone" id="phone" value="<?php if (isset($_POST["update-contact"])) {
                                                                            echo $phone;
                                                                        } else {
                                                                            echo $bilgi["telefon"];
                                                                        } ?>"><br>
                    <span><?php echo $phoneErr ?></span>
                    <label for="email">E-Posta Adresi:</label><br>
                    <input type="text" name="email" id="email" value="<?php if (isset($_POST["update-contact"])) {
                                                                            echo $email;
                                                                        } else {
                                                                            echo $bilgi["e_posta"];
                                                                        } ?>"><br>
                    <span><?php echo $emailErr ?></span>
                    <span><?php echo $message ?></span>
                    <button type="submit" name="update-contact">Güncelle</button>
                </form>
            </div>
            <div class="address">
                <div class="_address">
                    <h3>Adreslerim</h3>
                    <button onclick="add()">Adres Ekle</button>
                    <div class="all_address">
                        <?php if (!empty($address)) : ?>
                            <?php foreach ($address as $adres) : ?>
                                <div class="adres">
                                    <form action="adres.php?page=adres-duzenle" method="post">
                                        <div class="address_title"><b><?php echo $adres["title"] ?></b></div>
                                        <div class="address_text"><?php echo $adres["adres"] ?></div>
                                        <input type="hidden" name="adres-id" value="<?php echo $adres["adres_id"] ?>">
                                        <button type="submit" name="adres-duzenle">Düzenle</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php include("../parts/footer.php") ?>

</body>

</html>
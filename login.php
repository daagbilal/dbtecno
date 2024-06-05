<?php
require_once("parts/config.php");
require("libs/functions.php");
session_start();
if (isLoggedIn()) {
    header("Location: index.php");
}



$emailErr = $passwordErr = $loginErr = "";
$email = $password = "";

if (($_SERVER["REQUEST_METHOD"]) == "POST") {

    if (empty($_POST["email"])) {
        $emailErr = "Lütfen e-posta adresi giriniz.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Geçersiz e-posta biçimi.";
    } else {
        $email = safe_html($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Lütfen şifre giriniz.";
    } else {
        $password = safe_html($_POST["password"]);
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $sql = "SELECT id,ad,soyad,e_posta,telefon,sifre FROM users WHERE e_posta=? && durum = 1";

        if ($stmt = mysqli_prepare($baglanti, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $ad, $soyad, $email, $telefon, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION["loggedIn"] = true;
                            $_SESSION["musteri_id"] = $id;
                            $_SESSION["ad"] = $ad;
                            $_SESSION["soyad"] = $soyad;
                            $_SESSION["email"] = $email;
                            $_SESSION["telefon"] = $telefon;
                            $_SESSION["login_time"] = date('Y-m-d H:i:s');
                            $stmt = mysqli_prepare($baglanti, "UPDATE users SET login_time=? WHERE id=?");
                            mysqli_stmt_bind_param($stmt, "si", $login_time, $id);

                            $login_time = $_SESSION["login_time"];
                            $id = $_SESSION["musteri_id"];

                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);
                            mysqli_close($baglanti);

                            header("Location: index.php");
                        } else {
                            $loginErr = "Parola yanlış girildi.";
                        }
                    }
                } else {
                    $loginErr = "E-Posta yanlış girildi.";
                }
            } else {
                $loginErr = "Bir hata oluştu.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo "Giriş Yap" ?>
    </title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login">
        <div class="log">
            <div class="header">
                <a href="index.php"><img src="logo/2.png" alt="LOGO"></a>
            </div>
            <?php echo "<h3>Hoşgeldiniz...</h3>" ?>

            <form action="login.php" method="post" novalidate class="login-form">
                <input type="email" id="email" name="email" placeholder="E-Posta" value="<?php echo $email ?>"><br>
                <span class="uyari"><?php echo $emailErr ?></span>
                <br>
                <input type="password" id="password" name="password" placeholder="Şifre"><br>
                <span class="uyari"><?php echo $passwordErr ?></span>
                <br>
                <?php if (!empty($loginErr)) {
                    echo "<div class= 'uyari'>" . $loginErr . "</div>";
                } ?>
                <br>
                <div style="display: flex; justify-content: space-evenly; margin-top: 20px;">
                    <a href="#">Şifremi Unuttum</a>
                    <a href="signup.php">Üye Ol</a>
                </div>
                <br>
                <button type="submit">Giriş Yap</button>
            </form>

        </div>
    </div>
</body>

</html>
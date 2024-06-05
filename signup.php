<?php
require_once("parts/config.php");
require("libs/functions.php");
session_start();
if (isLoggedIn()) {
    header("Location: index.php");
}

$fnameErr = $lnameErr = $phoneErr = $emailErr = $passwordErr = "";
$fname = $lname = $phone = $email = $password = "";

if (($_SERVER["REQUEST_METHOD"]) == "POST") {
    if (empty($_POST["fname"])) {
        $fnameErr = "Lütfen adınızı giriniz.";
    } else {
        $fname = safe_html($_POST["fname"]);
    }
    if (empty($_POST["lname"])) {
        $lnameErr = "Lütfen soyadınızı giriniz.";
    } else {
        $lname = safe_html($_POST["lname"]);
    }
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
    if (empty($_POST["password"]) or empty($_POST["repassword"])) {
        $passwordErr = "Lütfen şifre giriniz.";
    } elseif ($_POST["password"] != $_POST["repassword"]) {
        $passwordErr = "Lütfen şifrenizi aynı giriniz.";
    } else {
        if (strlen($_POST["password"]) < 8) {
            $passwordErr = "Lütfen en az 8 haneli şifre oluşturunuz.";
        } elseif (strlen($_POST["password"]) > 15) {
            $passwordErr = "En fazla 15 haneli şifre oluşturabilirsiniz.";
        } else {
            $password = safe_html($_POST["password"]);
        }
    }

    if (empty($fnameErr) && empty($lnameErr) && empty($phoneErr) && empty($emailErr) && empty($passwordErr)) {
        $sql = "INSERT INTO users (ad,soyad,telefon,e_posta,sifre,recording_time,login_time) VALUES (?,?,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($baglanti, $sql)) {
            $param_fname = $fname;
            $param_lname = $lname;
            $param_phone = $phone;
            $param_email = $email;
            $param_time = date('Y-m-d H:i:s');
            $param_login_time = $param_time;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "sssssss", $param_fname, $param_lname, $param_phone, $param_email, $param_password, $param_time, $param_login_time);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($baglanti);

                header("Location: login.php");
            } else {
                echo mysqli_error($baglanti);
                echo "<br>";
                echo "Hata Oluştu";
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
        <?php echo "Müşterimiz Olun" ?>
    </title>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <div class="login">
        <div class="log">
            <div class="header">
                <a href="index.php"><img src="logo/2.png" alt="LOGO"></a>
            </div>
            <?php echo "<h3>Müşterimiz Olun...</h3>" ?>
            <form action="signup.php" method="post" novalidate class="login-form">
                <input type="text" id="fname" name="fname" placeholder="Ad" value="<?php echo $fname ?>"><br>
                <div class="uyari"><?php echo $fnameErr ?></div>
                <br>
                <input type="text" id="lname" name="lname" placeholder="Soyad" value="<?php echo $lname ?>"><br>
                <div class="uyari"><?php echo $lnameErr ?></div>
                <br>
                <input type="text" id="number" name="phone" placeholder="Telefon Numarası(5510001234)" value="<?php echo $phone ?>"><br>
                <div class="uyari"><?php echo $phoneErr ?></div>
                <br>
                <input type="email" id="email" name="email" placeholder="E-Posta" value="<?php echo $email ?>"><br>
                <div class="uyari"><?php echo $emailErr ?></div>
                <br>
                <input type="password" id="password-1" name="password" placeholder="Yeni Şifre"><br>
                <div class="uyari"><?php echo $passwordErr ?></div>
                <br>
                <input type="password" id="password-2" name="repassword" placeholder="Yeni Şifre(Tekrar)"><br>
                <div class="uyari"><?php echo $passwordErr ?></div>
                <br>
                <button type="submit">Üye Ol</button>
            </form>
        </div>
    </div>
</body>

</html>
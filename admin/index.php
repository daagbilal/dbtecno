<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isadminLoggedIn()) {
    header("Location: panel.php");
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
        $sql = "SELECT id,ad,soyad,e_posta,sifre FROM admins WHERE e_posta=?";

        if ($stmt = mysqli_prepare($baglanti, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $ad, $soyad, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {

                            $_SESSION["adminLoggedIn"] = true;
                            $_SESSION["admin_id"] = $id;
                            $_SESSION["admin_ad"] = $ad;
                            $_SESSION["admin_soyad"] = $soyad;
                            $_SESSION["admin_email"] = $email;
                            
                            mysqli_stmt_close($stmt);
                            mysqli_close($baglanti);

                            header("Location: panel.php");
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
        <?php echo "Admin Girişi" ?>
    </title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login">
        <div class="log">
            <div class="header">
                <a href="../index.php"><img src="../logo/2.png" alt="LOGO"></a>
            </div>
            <?php echo "<h3>Admin Girişi</h3>" ?>

            <form action="" method="post" novalidate class="login-form">
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
                <br>
                <button type="submit">Giriş Yap</button>
            </form>

        </div>
    </div>
</body>

</html>
<?php
require_once("../parts/config.php");
require("../libs/functions.php");
require("../libs/classes.php");
session_start();
if (isAdminLoggedIn()) {
    if ((($_SERVER["REQUEST_METHOD"]) == "GET") && isset($_GET["product_id"])) {
        $urun_kodu = $_GET["product_id"];
        if ($urun_kodu[0] == "1") {
            $stmt = mysqli_prepare($baglanti, "SELECT * FROM computers INNER JOIN stokfiyat ON computers.urun_kodu = stokfiyat.urun_kodu WHERE computers.urun_kodu = ?");
            mysqli_stmt_bind_param($stmt, "i", $urun_kodu);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bilgi = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else if ($urun_kodu[0] == "2") {
            $stmt = mysqli_prepare($baglanti, "SELECT * FROM phones INNER JOIN stokfiyat ON phones.urun_kodu = stokfiyat.urun_kodu WHERE phones.urun_kodu = ?");
            mysqli_stmt_bind_param($stmt, "i", $urun_kodu);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bilgi = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else if ($urun_kodu[0] == "3") {
            $stmt = mysqli_prepare($baglanti, "SELECT * FROM televisions INNER JOIN stokfiyat ON televisions.urun_kodu = stokfiyat.urun_kodu WHERE televisions.urun_kodu = ?");
            mysqli_stmt_bind_param($stmt, "i", $urun_kodu);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bilgi = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else if ($urun_kodu[0] == "4") {
            $stmt = mysqli_prepare($baglanti, "SELECT * FROM tablets INNER JOIN stokfiyat ON tablets.urun_kodu = stokfiyat.urun_kodu WHERE tablets.urun_kodu = ?");
            mysqli_stmt_bind_param($stmt, "i", $urun_kodu);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bilgi = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else if ($urun_kodu[0] == "5") {
            $stmt = mysqli_prepare($baglanti, "SELECT * FROM smart_watchs INNER JOIN stokfiyat ON smart_watchs.urun_kodu = stokfiyat.urun_kodu WHERE smart_watchs.urun_kodu = ?");
            mysqli_stmt_bind_param($stmt, "i", $urun_kodu);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $bilgi = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
    }
    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["update-submit"])) {
        $urun_kodu = $_POST['urun_id'];
        $UrunDuzenle = new EditProduct();
        if ($urun_kodu[0] == "1") {
            $UrunDuzenle->BilgisayarDuzenle($baglanti, $urun_kodu);
        } else if ($urun_kodu[0] == "2") {
            $UrunDuzenle->TelefonDuzenle($baglanti, $urun_kodu);
        } else if ($urun_kodu[0] == "3") {
            $UrunDuzenle->TelevizyonDuzenle($baglanti, $urun_kodu);
        } else if ($urun_kodu[0] == "4") {
            $UrunDuzenle->TabletDuzenle($baglanti, $urun_kodu);
        } else if ($urun_kodu[0] == "5") {
            $UrunDuzenle->SaatDuzenle($baglanti, $urun_kodu);
        }
    }
} else {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Ürün Yönetimi</title>
</head>

<body>
    <div class="product-div">
        <div class="product-form">
            <form action="" method="post">
                <h2>Ürün Güncelle</h2>
                <?php if ($urun_kodu[0] == "1") : ?>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["resim_adi"];
                                                                                        } else {
                                                                                            echo $bilgi["resim_adi"];
                                                                                        } ?>" required><br>
                    <input name="marka" type="text" placeholder="Marka" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["marka"];
                                                                                } else {
                                                                                    echo $bilgi["marka"];
                                                                                } ?>" required><br>
                    <input name="model" type="text" placeholder="Model" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["model"];
                                                                                } else {
                                                                                    echo $bilgi["model"];
                                                                                } ?>" required><br>
                    <input name="seri" type="text" placeholder="Seri" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["seri"];
                                                                                } else {
                                                                                    echo $bilgi["seri"];
                                                                                } ?>"><br>
                    <input name="kategori" type="text" placeholder="Kategori" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["kategori"];
                                                                                        } else {
                                                                                            echo $bilgi["kategori"];
                                                                                        } ?>" required><br>
                    <input name="urun_tipi" type="text" placeholder="Ürün Tipi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["urun_tipi"];
                                                                                        } else {
                                                                                            echo $bilgi["urun_tipi"];
                                                                                        } ?>" required><br>
                    <input name="ekran_karti" type="text" placeholder="Ekran Kartı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["ekran_karti"];
                                                                                            } else {
                                                                                                echo $bilgi["ekran_karti"];
                                                                                            } ?>" required><br>
                    <input name="ram" type="text" placeholder="Ram" value="<?php if (isset($_POST["update-submit"])) {
                                                                                echo $_POST["ram"];
                                                                            } else {
                                                                                echo $bilgi["ram"];
                                                                            } ?>" required><br>
                    <input name="ekran_k_hafiza" type="text" placeholder="Ekran Kartı Hafızası" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                            echo $_POST["ekran_k_hafiza"];
                                                                                                        } else {
                                                                                                            echo $bilgi["ekran_k_hafiza"];
                                                                                                        } ?>" required><br>
                    <input name="ekran_k_tipi" type="text" placeholder="Ekran Kartı Tipi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["ekran_k_tipi"];
                                                                                                    } else {
                                                                                                        echo $bilgi["ekran_k_tipi"];
                                                                                                    } ?>" required><br>
                    <input name="ram_tipi" type="text" placeholder="Ram Tipi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["ram_tipi"];
                                                                                        } else {
                                                                                            echo $bilgi["ram_tipi"];
                                                                                        } ?>" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["hafiza"];
                                                                                    } else {
                                                                                        echo $bilgi["hafiza"];
                                                                                    } ?>" required><br>
                    <input name="renk" type="text" placeholder="Renk" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["renk"];
                                                                                } else {
                                                                                    echo $bilgi["renk"];
                                                                                } ?>" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["isletim_sistemi"];
                                                                                                    } else {
                                                                                                        echo $bilgi["isletim_sistemi"];
                                                                                                    } ?>" required><br>
                    <input name="maks_islemci_hiz" type="text" placeholder="Maks. İşlemci Hızı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                            echo $_POST["maks_islemci_hiz"];
                                                                                                        } else {
                                                                                                            echo $bilgi["maks_islemci_hiz"];
                                                                                                        } ?>" required><br>
                    <input name="bellek_hizi" type="text" placeholder="Bellek Hızı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["bellek_hizi"];
                                                                                            } else {
                                                                                                echo $bilgi["bellek_hizi"];
                                                                                            } ?>" required><br>
                    <input name="islemci_nesli" type="text" placeholder="İşlemci Nesli" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                    echo $_POST["islemci_nesli"];
                                                                                                } else {
                                                                                                    echo $bilgi["islemci_nesli"];
                                                                                                } ?>" required><br>
                    <input name="islemci" type="text" placeholder="İşlemci" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["islemci"];
                                                                                    } else {
                                                                                        echo $bilgi["islemci"];
                                                                                    } ?>" required><br>
                    <input name="islemci_modeli" type="text" placeholder="İşlemci Modeli" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["islemci_modeli"];
                                                                                                    } else {
                                                                                                        echo $bilgi["islemci_modeli"];
                                                                                                    } ?>" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyut" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["ekran_boyut"];
                                                                                            } else {
                                                                                                echo $bilgi["ekran_boyut"];
                                                                                            } ?>" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["mgzurl"];
                                                                                    } else {
                                                                                        echo $bilgi["mgzurl"];
                                                                                    } ?>" required><br>
                    <input type="hidden" name="urun_id" value="<?php echo $urun_kodu; ?>">
                <?php endif; ?>
                <?php if ($urun_kodu[0] == "2") : ?>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["resim_adi"];
                                                                                        } else {
                                                                                            echo $bilgi["resim_adi"];
                                                                                        } ?>" required><br>
                    <input name="marka" type="text" placeholder="Marka" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["marka"];
                                                                                } else {
                                                                                    echo $bilgi["marka"];
                                                                                } ?>" required><br>
                    <input name="model" type="text" placeholder="Model" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["model"];
                                                                                } else {
                                                                                    echo $bilgi["model"];
                                                                                } ?>" required><br>
                    <input name="seri" type="text" placeholder="Seri" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["seri"];
                                                                                } else {
                                                                                    echo $bilgi["seri"];
                                                                                } ?>"><br>
                    <input name="kategori" type="text" placeholder="Kategori" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["kategori"];
                                                                                        } else {
                                                                                            echo $bilgi["kategori"];
                                                                                        } ?>" required><br>
                    <input name="renk" type="text" placeholder="Renk" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["renk"];
                                                                                } else {
                                                                                    echo $bilgi["renk"];
                                                                                } ?>" required><br>
                    <input name="yuz_tanima" type="text" placeholder="Yüz Tanıma" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["yuz_tanima"];
                                                                                            } else {
                                                                                                echo $bilgi["yuz_tanima"];
                                                                                            } ?>" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["ekran_boyut"];
                                                                                            } else {
                                                                                                echo $bilgi["ekran_boyut"];
                                                                                            } ?>" required><br>
                    <input name="kamera" type="text" placeholder="Kamera" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["kamera"];
                                                                                    } else {
                                                                                        echo $bilgi["kamera"];
                                                                                    } ?>" required><br>
                    <input name="pil_gucu" type="text" placeholder="Pil Gücü" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["pil_gucu"];
                                                                                        } else {
                                                                                            echo $bilgi["pil_gucu"];
                                                                                        } ?>" required><br>
                    <input name="on_kamera" type="text" placeholder="Ön Kamera" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["on_kamera"];
                                                                                        } else {
                                                                                            echo $bilgi["on_kamera"];
                                                                                        } ?>" required><br>
                    <input name="ram" type="text" placeholder="Ram" value="<?php if (isset($_POST["update-submit"])) {
                                                                                echo $_POST["ram"];
                                                                            } else {
                                                                                echo $bilgi["ram"];
                                                                            } ?>" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["hafiza"];
                                                                                    } else {
                                                                                        echo $bilgi["hafiza"];
                                                                                    } ?>" required><br>
                    <input name="kablosuz_sarj" type="text" placeholder="Kablosuz Şarj" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                    echo $_POST["kablosuz_sarj"];
                                                                                                } else {
                                                                                                    echo $bilgi["kablosuz_sarj"];
                                                                                                } ?>" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["isletim_sistemi"];
                                                                                                    } else {
                                                                                                        echo $bilgi["isletim_sistemi"];
                                                                                                    } ?>" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["mgzurl"];
                                                                                    } else {
                                                                                        echo $bilgi["mgzurl"];
                                                                                    } ?>" required><br>
                    <input type="hidden" name="urun_id" value="<?php echo $urun_kodu; ?>">
                <?php endif; ?>
                <?php if ($urun_kodu[0] == "3") : ?>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["resim_adi"];
                                                                                        } else {
                                                                                            echo $bilgi["resim_adi"];
                                                                                        } ?>" required><br>
                    <input name="marka" type="text" placeholder="Marka" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["marka"];
                                                                                } else {
                                                                                    echo $bilgi["marka"];
                                                                                } ?>" required><br>
                    <input name="model" type="text" placeholder="Model" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["model"];
                                                                                } else {
                                                                                    echo $bilgi["model"];
                                                                                } ?>" required><br>
                    <input name="seri" type="text" placeholder="Seri" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["seri"];
                                                                                } else {
                                                                                    echo $bilgi["seri"];
                                                                                } ?>"><br>
                    <input name="kategori" type="text" placeholder="Kategori" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["kategori"];
                                                                                        } else {
                                                                                            echo $bilgi["kategori"];
                                                                                        } ?>" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["ekran_boyut"];
                                                                                            } else {
                                                                                                echo $bilgi["ekran_boyut"];
                                                                                            } ?>" required><br>
                    <input name="smarttv" type="text" placeholder="Smart TV" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["smarttv"];
                                                                                    } else {
                                                                                        echo $bilgi["smarttv"];
                                                                                    } ?>" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["isletim_sistemi"];
                                                                                                    } else {
                                                                                                        echo $bilgi["isletim_sistemi"];
                                                                                                    } ?>" required><br>
                    <input name="goruntu" type="text" placeholder="Görüntü" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["goruntu"];
                                                                                    } else {
                                                                                        echo $bilgi["goruntu"];
                                                                                    } ?>" required><br>
                    <input name="model_yil" type="text" placeholder="Model Yılı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["model_yil"];
                                                                                        } else {
                                                                                            echo $bilgi["model_yil"];
                                                                                        } ?>" required><br>
                    <input name="cozunurluk" type="text" placeholder="Çözünürlük" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["cozunurluk"];
                                                                                            } else {
                                                                                                echo $bilgi["cozunurluk"];
                                                                                            } ?>" required><br>
                    <input name="enerji_sinifi" type="text" placeholder="Enerji Sınıfı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                    echo $_POST["enerji_sinifi"];
                                                                                                } else {
                                                                                                    echo $bilgi["enerji_sinifi"];
                                                                                                } ?>" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["mgzurl"];
                                                                                    } else {
                                                                                        echo $bilgi["mgzurl"];
                                                                                    } ?>" required><br>
                    <input type="hidden" name="urun_id" value="<?php echo $urun_kodu; ?>">
                <?php endif; ?>
                <?php if ($urun_kodu[0] == "4") : ?>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["resim_adi"];
                                                                                        } else {
                                                                                            echo $bilgi["resim_adi"];
                                                                                        } ?>" required><br>
                    <input name="marka" type="text" placeholder="Marka" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["marka"];
                                                                                } else {
                                                                                    echo $bilgi["marka"];
                                                                                } ?>" required><br>
                    <input name="model" type="text" placeholder="Model" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["model"];
                                                                                } else {
                                                                                    echo $bilgi["model"];
                                                                                } ?>" required><br>
                    <input name="seri" type="text" placeholder="Seri" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["seri"];
                                                                                } else {
                                                                                    echo $bilgi["seri"];
                                                                                } ?>"><br>
                    <input name="kategori" type="text" placeholder="Kategori" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["kategori"];
                                                                                        } else {
                                                                                            echo $bilgi["kategori"];
                                                                                        } ?>" required><br>
                    <input name="renk" type="text" placeholder="Renk" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["renk"];
                                                                                } else {
                                                                                    echo $bilgi["renk"];
                                                                                } ?>" required><br>
                    <input name="kalem" type="text" placeholder="Kalem" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["kalem"];
                                                                                } else {
                                                                                    echo $bilgi["kalem"];
                                                                                } ?>" required><br>
                    <input name="ram" type="text" placeholder="Ram" value="<?php if (isset($_POST["update-submit"])) {
                                                                                echo $_POST["ram"];
                                                                            } else {
                                                                                echo $bilgi["ram"];
                                                                            } ?>" required><br>
                    <input name="pil_gucu" type="text" placeholder="Pil Gücü" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["pil_gucu"];
                                                                                        } else {
                                                                                            echo $bilgi["pil_gucu"];
                                                                                        } ?>" required><br>
                    <input name="isletim_sistemi" type="text" placeholder="İşletim Sistemi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                        echo $_POST["isletim_sistemi"];
                                                                                                    } else {
                                                                                                        echo $bilgi["isletim_sistemi"];
                                                                                                    } ?>" required><br>
                    <input name="ekran_boyut" type="text" placeholder="Ekran Boyutu" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["ekran_boyut"];
                                                                                            } else {
                                                                                                echo $bilgi["ekran_boyut"];
                                                                                            } ?>" required><br>
                    <input name="hafiza" type="text" placeholder="Hafıza" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["hafiza"];
                                                                                    } else {
                                                                                        echo $bilgi["hafiza"];
                                                                                    } ?>" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["mgzurl"];
                                                                                    } else {
                                                                                        echo $bilgi["mgzurl"];
                                                                                    } ?>" required><br>
                    <input type="hidden" name="urun_id" value="<?php echo $urun_kodu; ?>">
                <?php endif; ?>
                <?php if ($urun_kodu[0] == "5") : ?>
                    <input name="resim_adi" type="text" placeholder="Resim Adı" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["resim_adi"];
                                                                                        } else {
                                                                                            echo $bilgi["resim_adi"];
                                                                                        } ?>" required><br>
                    <input name="marka" type="text" placeholder="Marka" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["marka"];
                                                                                } else {
                                                                                    echo $bilgi["marka"];
                                                                                } ?>" required><br>
                    <input name="model" type="text" placeholder="Model" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["model"];
                                                                                } else {
                                                                                    echo $bilgi["model"];
                                                                                } ?>" required><br>
                    <input name="seri" type="text" placeholder="Seri" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["seri"];
                                                                                } else {
                                                                                    echo $bilgi["seri"];
                                                                                } ?>"><br>
                    <input name="kategori" type="text" placeholder="Kategori" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["kategori"];
                                                                                        } else {
                                                                                            echo $bilgi["kategori"];
                                                                                        } ?>" required><br>
                    <input name="kamera" type="text" placeholder="Kamera" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["kamera"];
                                                                                    } else {
                                                                                        echo $bilgi["kamera"];
                                                                                    } ?>" required><br>
                    <input name="titresim" type="text" placeholder="Titreşim" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["titresim"];
                                                                                        } else {
                                                                                            echo $bilgi["titresim"];
                                                                                        } ?>" required><br>
                    <input name="gps" type="text" placeholder="GPS" value="<?php if (isset($_POST["update-submit"])) {
                                                                                echo $_POST["gps"];
                                                                            } else {
                                                                                echo $bilgi["gps"];
                                                                            } ?>" required><br>
                    <input name="sesli_gorusme" type="text" placeholder="Sesli Görüşme" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                    echo $_POST["sesli_gorusme"];
                                                                                                } else {
                                                                                                    echo $bilgi["sesli_gorusme"];
                                                                                                } ?>" required><br>
                    <input name="su_gecirme" type="text" placeholder="Su Geçirme" value="<?php if (isset($_POST["update-submit"])) {
                                                                                                echo $_POST["su_gecirme"];
                                                                                            } else {
                                                                                                echo $bilgi["su_gecirme"];
                                                                                            } ?>" required><br>
                    <input name="uyku" type="text" placeholder="Uyku Takibi" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["uyku"];
                                                                                    } else {
                                                                                        echo $bilgi["uyku"];
                                                                                    } ?>" required><br>
                    <input name="adim" type="text" placeholder="Adım Ölçer" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["adim"];
                                                                                    } else {
                                                                                        echo $bilgi["adim"];
                                                                                    } ?>" required><br>
                    <input name="kalp" type="text" placeholder="Kalp Ölçer" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["kalp"];
                                                                                    } else {
                                                                                        echo $bilgi["kalp"];
                                                                                    } ?>" required><br>
                    <input name="cinsiyet" type="text" placeholder="Cinsiyet" value="<?php if (isset($_POST["update-submit"])) {
                                                                                            echo $_POST["cinsiyet"];
                                                                                        } else {
                                                                                            echo $bilgi["cinsiyet"];
                                                                                        } ?>" required><br>
                    <input name="renk" type="text" placeholder="Renk" value="<?php if (isset($_POST["update-submit"])) {
                                                                                    echo $_POST["renk"];
                                                                                } else {
                                                                                    echo $bilgi["renk"];
                                                                                } ?>" required><br>
                    <input name="mgzurl" type="text" placeholder="Ürün URL" value="<?php if (isset($_POST["update-submit"])) {
                                                                                        echo $_POST["mgzurl"];
                                                                                    } else {
                                                                                        echo $bilgi["mgzurl"];
                                                                                    } ?>" required><br>
                    <input type="hidden" name="urun_id" value="<?php echo $urun_kodu; ?>">
                <?php endif; ?>
                <button type="submit" name="update-submit">Güncelle</button>
            </form>
        </div>
    </div>
</body>

</html>
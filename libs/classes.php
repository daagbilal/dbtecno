<?php

class AddProduct
{
    public function BilgisayarEkle($baglanti, $urun_kodu)
    {
        $sql = "INSERT INTO computers (resim_adi, marka, model, seri, kategori, urun_tipi, ekran_karti, ram, ekran_k_hafiza, ekran_k_tipi, ram_tipi, hafiza, renk, isletim_sistemi, maks_islemci_hiz, bellek_hizi, islemci_nesli, islemci, islemci_modeli, ekran_boyut, urun_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql1 = "INSERT INTO stokfiyat (urun_kodu, stok, fiyat, mgzurl) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);
        mysqli_stmt_bind_param($stmt, "sssssssisssississssii", $resim_adi, $marka, $model, $seri, $kategori, $urun_tipi, $ekran_karti, $ram, $ekran_k_hafiza, $ekran_k_tipi, $ram_tipi, $hafiza, $renk, $isletim_sistemi, $maks_islemci_hiz, $bellek_hizi, $islemci_nesli, $islemci, $islemci_modeli, $ekran_boyut, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "iiis", $urun_kodu, $stok, $fiyat, $mgzurl);
        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $urun_tipi = safe_html($_POST["urun_tipi"]);
        $ekran_karti = safe_html($_POST["ekran_karti"]);
        $ram = safe_html($_POST["ram"]);
        $ekran_k_hafiza = safe_html($_POST["ekran_k_hafiza"]);
        $ekran_k_tipi = safe_html($_POST["ekran_k_tipi"]);
        $ram_tipi = safe_html($_POST["ram_tipi"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $renk = safe_html($_POST["renk"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $maks_islemci_hiz = safe_html($_POST["maks_islemci_hiz"]);
        $bellek_hizi = safe_html($_POST["bellek_hizi"]);
        $islemci_nesli = safe_html($_POST["islemci_nesli"]);
        $islemci = safe_html($_POST["islemci"]);
        $islemci_modeli = safe_html($_POST["islemci_modeli"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $stok = safe_html($_POST["stok"]);
        $fiyat = safe_html($_POST["fiyat"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);

        mysqli_close($baglanti);
    }
    public function TelefonEkle($baglanti, $urun_kodu)
    {
        $sql = "INSERT INTO phones (resim_adi, marka, model, seri, kategori, renk, yuz_tanima, ekran_boyut, kamera, pil_gucu, on_kamera, ram, hafiza, kablosuz_sarj, isletim_sistemi, urun_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql1 = "INSERT INTO stokfiyat (urun_kodu, stok, fiyat, mgzurl) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiissi", $resim_adi, $marka, $model, $seri, $kategori, $renk, $yuz_tanima, $ekran_boyut, $kamera, $pil_gucu, $on_kamera, $ram, $hafiza, $kablosuz_sarj, $isletim_sistemi, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "iiis", $urun_kodu, $stok, $fiyat, $mgzurl);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $renk = safe_html($_POST["renk"]);
        $yuz_tanima = safe_html($_POST["yuz_tanima"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $kamera = safe_html($_POST["kamera"]);
        $pil_gucu = safe_html($_POST["pil_gucu"]);
        $on_kamera = safe_html($_POST["on_kamera"]);
        $ram = safe_html($_POST["ram"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $kablosuz_sarj = safe_html($_POST["kablosuz_sarj"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $stok = safe_html($_POST["stok"]);
        $fiyat = safe_html($_POST["fiyat"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function TelevizyonEkle($baglanti, $urun_kodu)
    {
        $sql = "INSERT INTO televisions (resim_adi, marka, model, seri, kategori, ekran_boyut, smarttv, isletim_sistemi, goruntu, model_yil, cozunurluk, enerji_sinifi, urun_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql1 = "INSERT INTO stokfiyat (urun_kodu, stok, fiyat, mgzurl) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssisssissi", $resim_adi, $marka, $model, $seri, $kategori, $ekran_boyut, $smarttv, $isletim_sistemi, $goruntu, $model_yil, $cozunurluk, $enerji_sinifi, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "iiis", $urun_kodu, $stok, $fiyat, $mgzurl);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $smarttv = safe_html($_POST["smarttv"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $goruntu = safe_html($_POST["goruntu"]);
        $model_yil = safe_html($_POST["model_yil"]);
        $cozunurluk = safe_html($_POST["cozunurluk"]);
        $enerji_sinifi = safe_html($_POST["enerji_sinifi"]);
        $stok = safe_html($_POST["stok"]);
        $fiyat = safe_html($_POST["fiyat"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function TabletEkle($baglanti, $urun_kodu)
    {
        $sql = "INSERT INTO tablets (resim_adi, marka, model, seri, kategori, renk, kalem, ram, pil_gucu, isletim_sistemi, ekran_boyut, hafiza, urun_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql1 = "INSERT INTO stokfiyat (urun_kodu, stok, fiyat, mgzurl) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssssiisiii", $resim_adi, $marka, $model, $seri, $kategori, $renk, $kalem, $ram, $pil_gucu, $isletim_sistemi, $ekran_boyut, $hafiza, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "iiis", $urun_kodu, $stok, $fiyat, $mgzurl);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $renk = safe_html($_POST["renk"]);
        $kalem = safe_html($_POST["kalem"]);
        $ram = safe_html($_POST["ram"]);
        $pil_gucu = safe_html($_POST["pil_gucu"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $stok = safe_html($_POST["stok"]);
        $fiyat = safe_html($_POST["fiyat"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function SaatEkle($baglanti, $urun_kodu)
    {
        $sql = "INSERT INTO smart_watchs (resim_adi, marka, model, seri, kategori, kamera, titresim, gps, sesli_gorusme, su_gecirme, uyku, adim, kalp, cinsiyet, renk, urun_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql1 = "INSERT INTO stokfiyat (urun_kodu, stok, fiyat, mgzurl) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);
        mysqli_stmt_bind_param($stmt, "sssssssssssssssi", $resim_adi, $marka, $model, $seri, $kategori, $kamera, $titresim, $gps, $sesli_gorusme, $su_gecirme, $uyku, $adim, $kalp, $cinsiyet, $renk, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "iiis", $urun_kodu, $stok, $fiyat, $mgzurl);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $kamera = safe_html($_POST["kamera"]);
        $titresim = safe_html($_POST["titresim"]);
        $gps = safe_html($_POST["gps"]);
        $sesli_gorusme = safe_html($_POST["sesli_gorusme"]);
        $su_gecirme = safe_html($_POST["su_gecirme"]);
        $uyku = safe_html($_POST["uyku"]);
        $adim = safe_html($_POST["adim"]);
        $kalp = safe_html($_POST["kalp"]);
        $cinsiyet = safe_html($_POST["cinsiyet"]);
        $renk = safe_html($_POST["renk"]);
        $stok = safe_html($_POST["stok"]);
        $fiyat = safe_html($_POST["fiyat"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
}

class EditProduct
{
    public function BilgisayarDuzenle($baglanti, $urun_kodu)
    {
        $sql = "UPDATE computers SET resim_adi = ?, marka = ?, model = ?, seri = ?, kategori = ?, urun_tipi = ?, ekran_karti = ?, ram = ?, ekran_k_hafiza = ?, ekran_k_tipi = ?, ram_tipi = ?, hafiza = ?, renk = ?, isletim_sistemi = ?, maks_islemci_hiz = ?, bellek_hizi = ?, islemci_nesli = ?, islemci = ?, islemci_modeli = ?, ekran_boyut = ? WHERE urun_kodu = ?";
        $sql1 = "UPDATE stokfiyat SET mgzurl = ? WHERE urun_kodu = ?";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);
        mysqli_stmt_bind_param($stmt, "sssssssisssississssii", $resim_adi, $marka, $model, $seri, $kategori, $urun_tipi, $ekran_karti, $ram, $ekran_k_hafiza, $ekran_k_tipi, $ram_tipi, $hafiza, $renk, $isletim_sistemi, $maks_islemci_hiz, $bellek_hizi, $islemci_nesli, $islemci, $islemci_modeli, $ekran_boyut, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "si", $mgzurl, $urun_kodu);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $urun_tipi = safe_html($_POST["urun_tipi"]);
        $ekran_karti = safe_html($_POST["ekran_karti"]);
        $ram = safe_html($_POST["ram"]);
        $ekran_k_hafiza = safe_html($_POST["ekran_k_hafiza"]);
        $ekran_k_tipi = safe_html($_POST["ekran_k_tipi"]);
        $ram_tipi = safe_html($_POST["ram_tipi"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $renk = safe_html($_POST["renk"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $maks_islemci_hiz = safe_html($_POST["maks_islemci_hiz"]);
        $bellek_hizi = safe_html($_POST["bellek_hizi"]);
        $islemci_nesli = safe_html($_POST["islemci_nesli"]);
        $islemci = safe_html($_POST["islemci"]);
        $islemci_modeli = safe_html($_POST["islemci_modeli"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $mgzurl = $_POST["mgzurl"];

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function TelefonDuzenle($baglanti, $urun_kodu)
    {
        $sql = "UPDATE phones SET resim_adi = ?, marka = ?, model = ?, seri = ?, kategori = ?, renk = ?, yuz_tanima = ?, ekran_boyut = ?, kamera = ?, pil_gucu = ?, on_kamera = ?, ram = ?, hafiza = ?, kablosuz_sarj = ?, isletim_sistemi = ? WHERE urun_kodu = ?";
        $sql1 = "UPDATE stokfiyat SET mgzurl = ? WHERE urun_kodu = ?";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssssiiiiiissi", $resim_adi, $marka, $model, $seri, $kategori, $renk, $yuz_tanima, $ekran_boyut, $kamera, $pil_gucu, $on_kamera, $ram, $hafiza, $kablosuz_sarj, $isletim_sistemi, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "si", $mgzurl, $urun_kodu);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $renk = safe_html($_POST["renk"]);
        $yuz_tanima = safe_html($_POST["yuz_tanima"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $kamera = safe_html($_POST["kamera"]);
        $pil_gucu = safe_html($_POST["pil_gucu"]);
        $on_kamera = safe_html($_POST["on_kamera"]);
        $ram = safe_html($_POST["ram"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $kablosuz_sarj = safe_html($_POST["kablosuz_sarj"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $mgzurl = $_POST["mgzurl"];


        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function TelevizyonDuzenle($baglanti, $urun_kodu)
    {
        $sql = "UPDATE televisions SET resim_adi = ?, marka = ?, model = ?, seri = ?, kategori = ?, ekran_boyut = ?, smarttv = ?, isletim_sistemi = ?, goruntu = ?, model_yil = ?, cozunurluk = ?, enerji_sinifi = ? WHERE urun_kodu = ?";
        $sql1 = "UPDATE stokfiyat SET mgzurl = ? WHERE urun_kodu = ?";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssisssissi", $resim_adi, $marka, $model, $seri, $kategori, $ekran_boyut, $smarttv, $isletim_sistemi, $goruntu, $model_yil, $cozunurluk, $enerji_sinifi, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "si", $mgzurl, $urun_kodu);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $smarttv = safe_html($_POST["smarttv"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $goruntu = safe_html($_POST["goruntu"]);
        $model_yil = safe_html($_POST["model_yil"]);
        $cozunurluk = safe_html($_POST["cozunurluk"]);
        $enerji_sinifi = safe_html($_POST["enerji_sinifi"]);
        $mgzurl = $_POST["mgzurl"];


        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function TabletDuzenle($baglanti, $urun_kodu)
    {
        $sql = "UPDATE tablets SET resim_adi = ?, marka = ?, model = ?, seri = ?, kategori = ?, renk = ?, kalem = ?, ram = ?, pil_gucu = ?, isletim_sistemi = ?, ekran_boyut = ?, hafiza = ? WHERE urun_kodu = ?";
        $sql1 = "UPDATE stokfiyat SET mgzurl = ? WHERE urun_kodu = ?";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssssiisiii", $resim_adi, $marka, $model, $seri, $kategori, $renk, $kalem, $ram, $pil_gucu, $isletim_sistemi, $ekran_boyut, $hafiza, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "si", $mgzurl, $urun_kodu);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $renk = safe_html($_POST["renk"]);
        $kalem = safe_html($_POST["kalem"]);
        $ram = safe_html($_POST["ram"]);
        $pil_gucu = safe_html($_POST["pil_gucu"]);
        $isletim_sistemi = safe_html($_POST["isletim_sistemi"]);
        $ekran_boyut = safe_html($_POST["ekran_boyut"]);
        $hafiza = safe_html($_POST["hafiza"]);
        $mgzurl = $_POST["mgzurl"];


        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
    public function SaatDuzenle($baglanti, $urun_kodu)
    {
        $sql = "UPDATE smart_watchs SET resim_adi = ?, marka = ?, model = ?, seri = ?, kategori = ?, kamera = ?, titresim = ?, gps = ?, sesli_gorusme = ?, su_gecirme = ?, uyku = ?, adim = ?, kalp = ?, cinsiyet = ?, renk = ? WHERE urun_kodu = ?";
        $sql1 = "UPDATE stokfiyat SET mgzurl = ? WHERE urun_kodu = ?";

        $stmt = mysqli_prepare($baglanti, $sql);
        $stmt1 = mysqli_prepare($baglanti, $sql1);

        mysqli_stmt_bind_param($stmt, "sssssssssssssssi", $resim_adi, $marka, $model, $seri, $kategori, $kamera, $titresim, $gps, $sesli_gorusme, $su_gecirme, $uyku, $adim, $kalp, $cinsiyet, $renk, $urun_kodu);
        mysqli_stmt_bind_param($stmt1, "si", $mgzurl, $urun_kodu);

        $resim_adi = safe_html($_POST["resim_adi"]);
        $marka = safe_html($_POST["marka"]);
        $model = safe_html($_POST["model"]);
        $seri = safe_html($_POST["seri"]);
        $kategori = safe_html($_POST["kategori"]);
        $kamera = safe_html($_POST["kamera"]);
        $titresim = safe_html($_POST["titresim"]);
        $gps = safe_html($_POST["gps"]);
        $sesli_gorusme = safe_html($_POST["sesli_gorusme"]);
        $su_gecirme = safe_html($_POST["su_gecirme"]);
        $uyku = safe_html($_POST["uyku"]);
        $adim = safe_html($_POST["adim"]);
        $kalp = safe_html($_POST["kalp"]);
        $cinsiyet = safe_html($_POST["cinsiyet"]);
        $renk = safe_html($_POST["renk"]);
        $mgzurl = $_POST["mgzurl"];


        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt1)) {
            header("Location: ./product.php");
            exit();
        } else {
            echo "Bir hata oluştu.";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt1);
        mysqli_close($baglanti);
    }
}

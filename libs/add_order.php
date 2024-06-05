<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    if (isset($_POST["order_submit"])) {
        $adres_id = $_POST["adres"];
        $adres_stmt = mysqli_prepare($baglanti, "SELECT il,ilce,adres FROM adres WHERE musteri_id = ? AND adres_id = ?");
        mysqli_stmt_bind_param($adres_stmt, "ii", $musteri_id, $adres_id);
        if (mysqli_stmt_execute($adres_stmt)) {
            $adres_result = mysqli_stmt_get_result($adres_stmt);
            mysqli_stmt_close($adres_stmt);
            $adres = mysqli_fetch_assoc($adres_result);
        }

        $stmt = mysqli_prepare($baglanti, "SELECT urun_kodu, fiyat, miktar
        FROM (
            SELECT computers.urun_kodu, sf.fiyat, sepet.miktar
            FROM computers
            INNER JOIN sepet ON computers.urun_kodu = sepet.urun_kodu
            INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
            WHERE musteri_id = ?
            UNION ALL
            SELECT phones.urun_kodu, sf.fiyat, sepet.miktar
            FROM phones
            INNER JOIN sepet ON phones.urun_kodu = sepet.urun_kodu
            INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
            WHERE musteri_id = ?
            UNION ALL
            SELECT televisions.urun_kodu, sf.fiyat, sepet.miktar
            FROM televisions
            INNER JOIN sepet ON televisions.urun_kodu = sepet.urun_kodu
            INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
            WHERE musteri_id = ?
            UNION ALL
            SELECT tablets.urun_kodu, sf.fiyat, sepet.miktar
            FROM tablets
            INNER JOIN sepet ON tablets.urun_kodu = sepet.urun_kodu
            INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
            WHERE musteri_id = ?
            UNION ALL
            SELECT smart_watchs.urun_kodu, sf.fiyat, sepet.miktar
            FROM smart_watchs
            INNER JOIN sepet ON smart_watchs.urun_kodu = sepet.urun_kodu
            INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
            WHERE musteri_id = ?
        ) AS combined_result;
        ");
        mysqli_stmt_bind_param($stmt, "iiiii", $musteri_id, $musteri_id, $musteri_id, $musteri_id, $musteri_id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($products as $product) {
                $sql = "INSERT INTO orders (musteri_id,urun_kodu,birim_fiyat,fiyat,miktar,adres,add_time) VALUES (?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($baglanti, $sql);
                mysqli_stmt_bind_param($stmt, "iiiiiss", $musteri_id, $urun_kodu, $urun_fiyat, $fiyat, $miktar, $address, $add_time);
                $urun_kodu = $product["urun_kodu"];
                $urun_fiyat = $product["fiyat"];
                $fiyat = ($product["fiyat"] * $product["miktar"]);
                $miktar = $product["miktar"];
                $address = "$adres[adres] $adres[ilce]/$adres[il]";
                $add_time = date('Y-m-d H:i:s');
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    $sql1 = "UPDATE stokfiyat SET stok = stok - $miktar WHERE urun_kodu = ?";
                    $stmt1 = mysqli_prepare($baglanti, $sql1);
                    mysqli_stmt_bind_param($stmt1, "i", $urun_kodu);
                    if (mysqli_stmt_execute($stmt1)) {
                        mysqli_stmt_close($stmt1);
                    }
                }
            }
            $del_stmt = mysqli_prepare($baglanti, "DELETE FROM sepet WHERE musteri_id= ?");
            mysqli_stmt_bind_param($del_stmt, "i", $musteri_id);
            if (mysqli_stmt_execute($del_stmt)) {
                mysqli_stmt_close($del_stmt);
                mysqli_close($baglanti);
                header("Location: ../pages/siparis.php");
                exit();
            }
        }
    } else {
        mysqli_close($baglanti);
        header("Location: ../index.php");
        exit();
    }
} else {
    mysqli_close($baglanti);
    header("Location: ../login.php");
    exit();
}

<?php
require_once("../parts/config.php");
require("functions.php");
session_start();
if (isLoggedIn()) {
    $mesaj = "";
    $urun_id = safe_html($_GET['product_id']);
    $sql0 = "SELECT stok From stokfiyat Where urun_kodu = ? && stok = 0";
    $stmt0 = mysqli_prepare($baglanti, $sql0);
    mysqli_stmt_bind_param($stmt0, "i", $urun_id);
    mysqli_stmt_execute($stmt0);
    mysqli_stmt_store_result($stmt0);
    if (mysqli_stmt_num_rows($stmt0) == 0) {
        $sql = "INSERT INTO sepet (musteri_id, urun_kodu, miktar, add_time) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($baglanti, $sql);
        $musteri_id = $_SESSION["musteri_id"];
        $miktar = 1;
        $add_time = date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, "iiis", $musteri_id, $urun_id, $miktar, $add_time);

        if (mysqli_stmt_execute($stmt)) {
            $mesaj = "Ürün sepete eklendi.";
        }
    } else {
        $mesaj = "Ürün tükendi!";
    }
    exit(json_encode(['mesaj' => $mesaj]));
} else {
    header("Location: ../login.php");
}

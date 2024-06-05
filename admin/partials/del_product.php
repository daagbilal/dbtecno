<?php
require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();
if (isset($_GET['id']) && isAdminLoggedIn()) {
    $productId = $_GET['id']; // veya $productId = $_POST['id'];
    $sql = "";
    if ($productId[0] == 1) {
        $sql = "DELETE FROM computers WHERE urun_kodu = ?";
    } else if ($productId[0] == 2) {
        $sql = "DELETE FROM phones WHERE urun_kodu = ?";
    } else if ($productId[0] == 3) {
        $sql = "DELETE FROM televisions WHERE urun_kodu = ?";
    } else if ($productId[0] == 4) {
        $sql = "DELETE FROM tablets WHERE urun_kodu = ?";
    } else if ($productId[0] == 5) {
        $sql = "DELETE FROM smart_watchs WHERE urun_kodu = ?";
    }
    $sql1 = "DELETE FROM stokfiyat WHERE urun_kodu = ?";

    $stmt = mysqli_prepare($baglanti, $sql);
    $stmt1 = mysqli_prepare($baglanti, $sql1);
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_bind_param($stmt1, "i", $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt1);
    $mesaj = "";
    if (mysqli_affected_rows($baglanti) < 1) {
        $mesaj = "Ürün Silindi.";
    } else {
        $mesaj = "Ürün silme işlemi başarısız!";
    }
    mysqli_close($baglanti);
    exit(json_encode(['mesaj' => $mesaj]));
}

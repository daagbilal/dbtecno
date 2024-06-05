<?php
require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();
if (isAdminLoggedIn()) {
    if (($_SERVER["REQUEST_METHOD"]) == "POST" && isset($_POST["stokguncelle"])) {
        $stok = $_POST["guncelstok"];
        $urun_k = $_POST["urun_id"];
        $sql = "UPDATE stokfiyat SET stok = ? WHERE urun_kodu = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $stok, $urun_k);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../inventory.php");
            exit();
        } else {
            echo "<script>alert('Bir hata oluştu!')</script>";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: ../index.php");
    exit();
}
mysqli_close($baglanti);

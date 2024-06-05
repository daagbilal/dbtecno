<?php
require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();
if (isset($_GET['id']) && isAdminLoggedIn()) {
    $id = $_GET["id"];
    $mesaj = "";
    if ($_GET["islem"] == "aktif") {
        $sql = "UPDATE users Set durum = 1 Where id = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $mesaj = "Hesap Aktifleştirildi.";
        }
    } else if ($_GET["islem"] == "pasif") {
        $sql = "UPDATE users Set durum = 0 Where id = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $mesaj = "Hesap Pasifleştirildi.";
        }
    }
    exit(json_encode(['mesaj' => $mesaj]));
}

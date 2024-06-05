<?php
require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();
if (isset($_GET['id']) && isAdminLoggedIn()) {
    $siparis_id = $_GET["id"];
    $sql = "UPDATE orders Set durum = 3 Where siparis_id = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "i", $siparis_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $mesaj = "";
    if (mysqli_affected_rows($baglanti) < 1) {
        $mesaj = 'İşlem başarıyla tamamlandı!';
    } else {
        $mesaj = 'Kargolama İşlemi Başarısız!';
    }
    exit(json_encode(['mesaj' => $mesaj]));
}

<?php
session_start();
require_once("../parts/config.php");
require_once("functions.php");

if (isset($_POST["product_id"]) && isLoggedIn()) {
    $urun_kodu = $_POST["product_id"];
    $musteri_id = $_SESSION["musteri_id"];

    $sql = "DELETE FROM `sepet` WHERE urun_kodu = $urun_kodu AND musteri_id = $musteri_id;";

    $result = mysqli_query($baglanti, $sql);

    if ($result) {
        header("Location: ../pages/sepet.php");
    }

    mysqli_close($baglanti);
}

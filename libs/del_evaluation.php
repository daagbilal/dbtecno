<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isset($_POST["product_id"]) && isLoggedIn()) {
    $urun_kodu = $_POST["product_id"];
    $musteri_id = $_SESSION["musteri_id"];

    $sql = "DELETE FROM evaluations WHERE urun_kodu = ? AND musteri_id = ?;";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $urun_kodu, $musteri_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/evaluations.php");
        mysqli_stmt_close($stmt);
    }
} else {
    header("location: ../login.php");
}

mysqli_close($baglanti);

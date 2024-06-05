<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    if (isset($_GET["adres_id"])) {
        $adres_id = $_GET["adres_id"];

        $sql = "DELETE FROM adres WHERE adres_id = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "i", $adres_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($baglanti);
            header("Location: ../pages/profile.php?page=2");
            exit();
        }
    } else {
        header("Location: ../pages/profile.php?page=2");
    }
} else {
    header("Location: ../index.php");
}

<?php
require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();

if (isAdminLoggedIn()) {
    $data = json_decode(file_get_contents('php://input'), true)['productId'];
    $sql = "DELETE FROM computers WHERE urun_kodu = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "i", $data);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../product.php");
        exit();
    }
    
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($baglanti);

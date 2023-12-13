<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    if ((($_SERVER["REQUEST_METHOD"]) == "POST") && isset($_POST["adres_duzenle"])) {
        $stmt = mysqli_prepare($baglanti, "SELECT * FROM adres WHERE adres_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $adres_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bilgi = mysqli_fetch_assoc($result);
    }
} else {
    header("Location: ../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>
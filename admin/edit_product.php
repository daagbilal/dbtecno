<?php
    require_once("../parts/config.php");
    require("../libs/functions.php");
    session_start();
    if (isAdminLoggedIn()) {
        
    }else {
        header("Location: index.php");
        exit();
    }
    mysqli_close($baglanti);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Düzenle</title>
</head>
<body>
    
</body>
</html>
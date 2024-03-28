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
    <link rel="stylesheet" href="panel.css">
    <title>Ürün Yönetimi</title>
</head>
<body>
<div class="main-div">
        <?php include("partials/options.php");?>
        <div class="dashboard-div">
            <?php include("partials/header.php");?>
            <div class="content">
                
            </div>
        </div>
    </div>
</body>
</html>
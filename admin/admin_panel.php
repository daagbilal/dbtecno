<?php 
    require_once("../parts/config.php");
    require("../libs/functions.php");
    session_start();
    if (isAdminLoggedIn()) {

    }else {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/panel.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="main-div">
        <div class="options-div">
            <ul>
                <li><a href="admin_panel.php">Ana Sayfa</a></li>
                <li><a href="product.php">Ürün Yönetimi</a></li>
                <li><a href="order.php">Sipariş Yönetimi</a></li>
                <li><a href="customer.php">Müşteri Yönetimi</a></li>
                <li><a href="inventory.php">Stok Yönetimi</a></li>
                <li><a href="admin.php">Kullanıcı Yönetimi</a></li>
                <li><a href="log_out.php">Çıkış Yap</a></li>
            </ul>
        </div>
        <div class="dashboard-div">

        </div>
    </div>
</body>
</html>
<?php

function db_product($baglanti, string $product_ctg, $id)
{
    $stmt = mysqli_prepare($baglanti, "SELECT * FROM $product_ctg WHERE urun_kodu= ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($result);
}

function db_products($baglanti, string $product_ctg)
{
    $products_category = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM $product_ctg");
    return mysqli_fetch_all($products_category, MYSQLI_ASSOC);
}

function db_products_ctg($baglanti, string $product_ctg)
{
    $products = mysqli_query($baglanti, "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat,degerlendirme FROM $product_ctg ORDER BY degerlendirme DESC, marka ASC LIMIT 5");
    return mysqli_fetch_all($products, MYSQLI_ASSOC);
}

function isLoggedIn()
{
    return (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true);
}

function safe_html($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

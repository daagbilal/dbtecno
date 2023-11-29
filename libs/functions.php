<?php

function db_product($baglanti, string $product_ctg, $id)
{
    $result_urun = mysqli_query($baglanti, "SELECT * FROM $product_ctg WHERE urun_kodu=" . $id);
    return mysqli_fetch_assoc($result_urun);
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

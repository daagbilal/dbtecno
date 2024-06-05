<?php

function db_products($baglanti, string $product_ctg)
{
    $products_category = mysqli_query($baglanti, "SELECT pc.urun_kodu,pc.resim_adi,pc.marka,pc.model,pc.seri,sf.fiyat
    FROM $product_ctg pc
    INNER JOIN stokfiyat sf ON pc.urun_kodu = sf.urun_kodu
    ");

    return mysqli_fetch_all($products_category, MYSQLI_ASSOC);
}

function db_products_ctg($baglanti, string $product_ctg)
{
    $products = mysqli_query($baglanti, "SELECT pc.urun_kodu, pc.resim_adi, pc.marka, pc.model, pc.seri, sf.fiyat, AVG(ev.puan) AS degerlendirme
    FROM $product_ctg pc
    INNER JOIN evaluations ev ON pc.urun_kodu = ev.urun_kodu
    INNER JOIN stokfiyat sf ON pc.urun_kodu = sf.urun_kodu
    GROUP BY pc.urun_kodu, pc.resim_adi, pc.marka, pc.model, pc.seri, sf.fiyat
    ORDER BY degerlendirme DESC, pc.marka ASC
    LIMIT 5;
    ");
    return mysqli_fetch_all($products, MYSQLI_ASSOC);
}

function isAdminLoggedIn()
{
    return (isset($_SESSION["adminLoggedIn"]) && $_SESSION["adminLoggedIn"] == true);
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

<?php
session_start();

$_SESSION["adminLoggedIn"] = false;
$_SESSION["admin_id"] = "";
$_SESSION["admin_ad"] = "";
$_SESSION["admin_soyad"] = "";
$_SESSION["admin_email"] = "";

header("Location: index.php");
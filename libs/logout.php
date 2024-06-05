<?php
session_start();

$_SESSION["loggedIn"] = false;
$_SESSION["musteri_id"] = "";
$_SESSION["ad"] = "";
$_SESSION["soyad"] = "";
$_SESSION["email"] = "";
$_SESSION["telefon"] = "";
$_SESSION["login_time"] = "";

header("Location: ../index.php");

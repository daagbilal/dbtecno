<?php
// dbtecnoc_user
// Nr&jm^aaOFX~
// dbtecnoc_db

$servername = "localhost";
$username = "dbtecnoc_user";
$password = "Nr&jm^aaOFX~";
$dbname = "dbtecnoc_db";

$baglanti = new mysqli($servername, $username, $password, $dbname);

if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

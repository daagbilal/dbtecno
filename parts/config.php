<?php
// dbtecnoc_user
// Nr&jm^aaOFX~
// dbtecnoc_db

$baglanti = new mysqli("localhost", "dbtecnoc_user", "Nr&jm^aaOFX~", "dbtecnoc_db");

if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

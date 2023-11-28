<?php

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

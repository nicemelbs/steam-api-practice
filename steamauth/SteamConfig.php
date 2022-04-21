<?php
//Version 4.0
use app\core\Application;

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];

$steamauth['apikey'] = $_ENV['STEAM_API_KEY']; // Your Steam WebAPI-Key found at https://steamcommunity.com/dev/apikey
$steamauth['domainname'] = $base_url; // The main URL of your website displayed in the login page
$steamauth['logoutpage'] = "/"; // Page to redirect to after a successfull logout (from the directory the
// SteamAuth-folder is located in) - NO slash at the beginning!
$steamauth['loginpage'] = "/profile"; // Page to redirect to after a successfull login (from the directory the
// SteamAuth-folder is located in) - NO slash at the beginning!

// System stuff
if (empty($steamauth['apikey'])) {
    die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>SteamAuth:<br>Please supply an API-Key!<br>Find this in steamauth/SteamConfig.php, Find the '<b>\$steamauth['apikey']</b>' Array. </div>");
}
if (empty($steamauth['domainname'])) {
    $steamauth['domainname'] = $_SERVER['SERVER_NAME'];
}
if (empty($steamauth['logoutpage'])) {
    $steamauth['logoutpage'] = $_SERVER['PHP_SELF'];
}
if (empty($steamauth['loginpage'])) {
    $steamauth['loginpage'] = $_SERVER['PHP_SELF'];
}
?>

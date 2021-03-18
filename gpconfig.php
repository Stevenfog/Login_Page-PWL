<?php
session_start();
// Include Librari Google Client (API)
include_once 'libraries/google-client/Google_Client.php';
include_once 'libraries/google-client/contrib/Google_Oauth2Service.php';
$client_id ='82491352614-vphd6o2if0qut8grsvlsu20p2fr867av.apps.googleusercontent.com'; // Google client ID
$client_secret = 'YLg-LN8a9VlfSPU2F9-_GhoI'; // Google Client Secret
$redirect_url = 'http://localhost/tugas_login/google.php'; // Callback URL
// Call Google API
$gclient = new Google_Client();
$gclient->setApplicationName('Login'); //  Nama Aplikasi 
$gclient->setClientId($client_id); // Client ID
$gclient->setClientSecret($client_secret); // Client Secret
$gclient->setRedirectUri($redirect_url); // URL untuk Redirect setelah berhasil login
$google_oauthv2 = new Google_Oauth2Service($gclient);
?>
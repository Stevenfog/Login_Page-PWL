<?php
// Include file gpconfig
include_once 'gpconfig.php';
if(isset($_GET['code'])){
  $gclient->authenticate($_GET['code']);
  $_SESSION['token'] = $gclient->getAccessToken();
  header('Location: ' . filter_var($redirect_url, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['token'])) {
  $gclient->setAccessToken($_SESSION['token']);
}
if ($gclient->getAccessToken()) {
  include 'koneksi.php';
  // Get user profile data from google
  $gpuserprofile = $google_oauthv2->userinfo->get();
  $nama = $gpuserprofile['given_name']." ".$gpuserprofile['family_name']; // Ambil nama dari Akun Google
  $email = $gpuserprofile['email']; // Ambil email Akun Google nya
  
  $sql = $pdo->prepare("SELECT id, username, nama FROM user WHERE email=:a");
  $sql->bindParam(':a', $email);
  $sql->execute();
  $user = $sql->fetch(); 
  if(empty($user)){ 
    
    $ex = explode('@', $email); 
    $username = $ex[0];
    
    $sql = $pdo->prepare("INSERT INTO user(username, nama, email) VALUES(:username,:nama,:email)");
    $sql->bindParam(':username', $username);
    $sql->bindParam(':nama', $nama);
    $sql->bindParam(':email', $email);
    $sql->execute(); 
    $id = $pdo->lastInsertId(); 
  }else{
    $id = $user['id']; 
    $username = $user['username']; 
    $nama = $user['nama']; 
  }
  $_SESSION['id'] = $id;
  $_SESSION['username'] = $username;
  $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    header("location: welcome.php");
} else {
  $authUrl = $gclient->createAuthUrl();
  header("location: ".$authUrl);
}
?>

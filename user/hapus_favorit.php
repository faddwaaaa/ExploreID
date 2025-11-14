<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['hapus'])) {
  $user_id = $_SESSION['user_id'];
  $wisata_id = (int)$_POST['wisata_id'];

  $query = "DELETE FROM favorit WHERE user_id=$user_id AND wisata_id=$wisata_id";
  mysqli_query($koneksi, $query);
}

header("Location: favorit.php");
exit();
?>

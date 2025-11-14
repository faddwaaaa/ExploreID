<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
  exit();
}

if (isset($_POST['favorit'])) {
  $user_id = (int)$_SESSION['user_id'];
  $wisata_id = (int)$_POST['wisata_id'];

  // pastikan data wisata valid
  $cek_wisata = mysqli_query($koneksi, "SELECT wisata_id FROM wisata WHERE wisata_id = $wisata_id");
  if (mysqli_num_rows($cek_wisata) === 0) {
    echo "<script>alert('Data wisata tidak ditemukan!'); history.back();</script>";
    exit();
  }

  // cek apakah sudah ada di favorit
  $cek_favorit = mysqli_query($koneksi, "SELECT * FROM favorit WHERE user_id = $user_id AND wisata_id = $wisata_id");
  if (mysqli_num_rows($cek_favorit) > 0) {
    echo "<script>alert('Destinasi ini sudah ada di favorit Anda!'); history.back();</script>";
    exit();
  }

  // simpan ke favorit
  $query = mysqli_query($koneksi, "INSERT INTO favorit (user_id, wisata_id) VALUES ($user_id, $wisata_id)");
  if ($query) {
    echo "<script>alert('Destinasi berhasil ditambahkan ke favorit!'); history.back();</script>";
  } else {
    echo "<script>alert('Gagal menambahkan ke favorit!'); history.back();</script>";
  }
}

?>

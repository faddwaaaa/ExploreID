<?php
session_start();
include '../koneksi.php';

$user_id = $_SESSION['user_id'];

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];

// Ambil data lama
$result = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($result);

// Jika password baru diisi → ubah
if (!empty($password)) {
    $hashed_password = md5($password);
    $password_query = ", password='$hashed_password'";
} else {
    $password_query = "";
}

// Upload foto jika ada
if (!empty($_FILES['foto']['name'])) {
    $foto_name = time() . '_' . $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $folder = "../uploads/" . $foto_name;
    move_uploaded_file($foto_tmp, $folder);

    $foto_query = ", gambar='$foto_name'";
} else {
    $foto_query = "";
}

$update = mysqli_query($koneksi, "
    UPDATE users 
    SET nama='$nama', email='$email' 
    $password_query 
    $foto_query 
    WHERE user_id='$user_id'
");

if ($update) {
    echo "<script>alert('Profil berhasil diperbarui!'); window.location='profile.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui profil!'); window.location='profile.php';</script>";
}
?>

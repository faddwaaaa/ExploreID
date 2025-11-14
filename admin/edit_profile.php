<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$sql = mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'");
$admin = mysqli_fetch_assoc($sql);

// Jika update disubmit
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        mysqli_query($koneksi, "UPDATE admin SET password='$password' WHERE admin_id='$admin_id'");
    }

    mysqli_query($koneksi, "UPDATE admin SET nama='$nama', email='$email' WHERE admin_id='$admin_id'");

    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $foto);
        mysqli_query($koneksi, "UPDATE admin SET gambar='$foto' WHERE admin_id='$admin_id'");
    }

    echo "<script>alert('Profil berhasil diperbarui!'); window.location='profil.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Profil | ExploreID</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(180deg, #EAF1FF, #134BC3);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 60px 20px;
}

/* Kartu utama */
.edit-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(25px);
    border-radius: 25px;
    padding: 50px 70px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.1);
    width: 420px; /* Lebar lebih besar */
    animation: fadeIn 0.8s ease-in-out;
    margin-top: 40px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    font-family: 'Abril Fatface';
    color: #134BC3;
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
}

.image-preview {
    text-align: center;
    margin-bottom: 30px;
}

.image-preview img {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 4px solid #134BC3;
    object-fit: cover;
    box-shadow: 0 0 10px rgba(19,75,195,0.3);
}

/* Input */
.input-group {
    margin-bottom: 22px;
}

.input-group label {
    display: block;
    font-weight: 600;
    color: #134BC3;
    margin-bottom: 8px;
    font-size: 15px;
}

.input-group input[type="text"],
.input-group input[type="email"],
.input-group input[type="password"],
.input-group input[type="file"] {
    width: 100%;
    padding: 14px 16px;
    border-radius: 12px;
    border: 2px solid #134BC3;
    font-size: 15px;
    box-sizing: border-box;
    outline: none;
    transition: 0.3s;
}

.input-group input:focus {
    border-color: #0e3b9b;
    box-shadow: 0 0 6px rgba(19,75,195,0.4);
}

/* Tombol */
button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    font-weight: 500;
    color: white;
    cursor: pointer;
    transition: 0.3s ease;
    font-size: 16px;
}

.btn-save {
    background-color: #134BC3;
    margin-top: 10px;
}

.btn-save:hover {
    background-color: #0e3b9b;
}

.btn-back {
    background-color: #EC0909;
    margin-top: 15px;
}

.btn-back:hover {
    background-color: #b90606;
}
</style>
</head>

<body>

<div class="edit-card">
    <h2>Edit Profil</h2>

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="image-preview">
            <img src="../uploads/<?= $admin['gambar'] ?>" alt="Foto Profil">
        </div>

        <div class="input-group">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($admin['nama']) ?>" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
        </div>

        <div class="input-group">
            <label>Password Baru (opsional)</label>
            <input type="password" name="password" placeholder="Isi jika ingin mengganti password">
        </div>

        <div class="input-group">
            <label>Foto Baru (opsional)</label>
            <input type="file" name="foto" accept="image/*">
        </div>

        <button class="btn-save" name="update"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
        <button type="button" class="btn-back" onclick="window.location.href='profil.php'"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
    </form>
</div>

</body>
</html>

<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'"));

$wisata_id = $_GET['wisata_id'] ?? 0;
$wisata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM wisata WHERE wisata_id='$wisata_id'"));

if (!$wisata) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='destinasi.php';</script>";
    exit;
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

if (isset($_POST['update'])) {
    $nama = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $kategori_id = $_POST['kategori_id'];
    $lokasi = $_POST['lokasi'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $path = "../uploads/" . $gambar;
        move_uploaded_file($tmp, $path);
        $gambar_sql = ", gambar='$gambar'";
    } else {
        $gambar_sql = "";
    }

    $query = "
        UPDATE wisata 
        SET kategori_id='$kategori_id', nama_wisata='$nama', lokasi='$lokasi', deskripsi='$deskripsi' $gambar_sql
        WHERE wisata_id='$wisata_id'
    ";
    mysqli_query($koneksi, $query);

    echo "<script>alert('Data berhasil diperbarui!'); window.location='destinasi.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Update Destination</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #F4F6FA;
}
.sidebar {
    width: 230px;
    background: #134BC3;
    height: 100vh;
    position: fixed;
    padding-top: 30px;
    color: white;
}
.sidebar h2 {
    text-align: center;
    font-family: 'Abril Fatface';
    margin-bottom: 30px;
    font-size: 28px;
}
.sidebar a {
    display: block;
    padding: 14px 25px;
    color: white;
    text-decoration: none;
    font-size: 15px;
    transition: 0.2s;
}
.sidebar a:hover {
    background: #FFFFFF;
    color: #134BC3;
}
.sidebar a:hover i {
    color: #134BC3;
}
.main {
    margin-left: 230px;
    padding: 25px 40px;
}

.header {
    background: white;
    padding: 15px 25px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header h1 {
    font-family: 'Abril Fatface';
    font-size: 32px;
    color: #134BC3;
    margin: 0;
}

.header img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
}

/* FORM WRAPPER */
.card {
    background: white;
    border-radius: 12px;
    padding: 20px 35px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 25px;
    width: 100%;
    box-sizing: border-box;
}
.card h2 {
    font-family: 'Abril Fatface';
    margin-top: 0px;
    margin-bottom: 25px;
    font-size: 25px;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}

label {
    font-weight: 500;
    margin-bottom: 6px;
}
input, textarea, select {
    width: 100%;
    box-sizing: border-box;
    padding: 12px 14px;
    border: 1.5px solid #134BC3;
    border-radius: 6px;
    outline: none;
    font-size: 15px;
}
textarea {
    resize: vertical;
    height: 120px;
}

.btn-submit {
    width: 100%;
    background: #134BC3;
    color: white;
    border: none;
    padding: 14px 0;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 16px;
    margin-top: 20px;
    transition: 0.2s;
}
.btn-submit:hover {
    background: #0F3EA0;
}
</style>

</head>
<body>
<div class="sidebar">
    <h2>ExploreID</h2>
    <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="destinasi.php"><i class="fa-solid fa-map-location-dot"></i> Manage Destinations</a>
    <a href="kategori.php"><i class="fa-solid fa-tags"></i> Categories</a>
    <a href="akun.php"><i class="fa-solid fa-users"></i> Accounts</a>
    <a href="komentar.php"><i class="fa-solid fa-comment"></i> Comments</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>


<div class="main">
    <div class="header">
        <h1>
            <span style="color:#000000;">Destination</span> 
            <span style="color:#134BC3;">Management</span>
        </h1>
        <a href="profil.php"><img src="../uploads/<?= $admin['gambar']; ?>" alt="Profil Admin"></a>
    </div>

    <div class="card">
        <h2><span style="color:#134BC3;">Update</span> <span style="color:#000;">Destination</span></h2>

        <form method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-container">
                <div class="form-group">
                    <label>Nama Wisata</label>
                    <input type="text" name="nama_wisata" value="<?= htmlspecialchars($wisata['nama_wisata']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" required><?= htmlspecialchars($wisata['deskripsi']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori_id" required>
                            <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                                <option value="<?= $k['kategori_id']; ?>" <?= $k['kategori_id'] == $wisata['kategori_id'] ? 'selected' : ''; ?>>
                                    <?= $k['nama_kategori']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" value="<?= htmlspecialchars($wisata['lokasi']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Gambar (kosongkan jika tidak diganti)</label>
                    <input type="file" name="gambar" accept="image/*">
                </div>
            </div>

            <button type="submit" name="update" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</div>
</body>
</html>

<?php
include "../koneksi.php";
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'"));

// Ambil ID destinasi dari URL
$wisata_id = $_GET['wisata_id'] ?? 0;

// Ambil data destinasi dari database
$query = "
    SELECT w.*, k.nama_kategori 
    FROM wisata w
    JOIN kategori k ON w.kategori_id = k.kategori_id
    WHERE w.wisata_id = '$wisata_id'
";
$wisata = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

if (!$wisata) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='destinasi.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Detail Destinasi</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #F4F6FA;
}

/* Sidebar */
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
    background: white;
    color: #134BC3;
}

/* Main content */
.main {
    margin-left: 230px;
    padding: 20px;
}

.header {
    background: white;
    padding: 15px 25px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
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

.sub-header {
    margin: 10px 0 25px 0;
}

.sub-header h2 {
    font-family: 'Abril Fatface';
    font-size: 25px;
    margin-left: 25px;
}

/* Card */
.card {
    background: white;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 1000px;
    margin: 0 auto;
}

/* Layout gambar dan info */
.destination-detail {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 25px;
    flex-wrap: wrap;
}

/* Gambar */
.image-section {
    flex: 0 0 350px;
    text-align: center;
}

.image-section img {
    width: 100%;
    height: auto;
    max-height: 260px;
    border-radius: 20px;
    object-fit: cover;
}

/* Tombol-tombol */
.btn-container {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.btn {
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    color: white;
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-edit { background: #17AC4B; }
.btn-edit:hover { background: #17824F; }

.btn-hapus { background: #EC0909; }
.btn-hapus:hover { background: #C52E3B; }

.btn-kembali { background: #134BC3; }
.btn-kembali:hover { background: #0F3EA0; }

/* Info teks */
.info {
    flex: 1 1 500px;
    min-width: 300px;
    overflow-wrap: break-word;
}

.info h3 {
    font-family: 'Abril Fatface';
    font-size: 24px;
    color: #000;
    margin-bottom: 6px;
}

.meta {
    margin: 8px 0 12px 0;
}

.meta div {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    margin-bottom: 5px;
}

.meta i {
    width: 18px;
    text-align: center;
}

.meta .fa-tags { color: #FFA500; }
.meta .fa-location-dot { color: #EC0909; }

.info p {
    color: #000;
    line-height: 1.6;
    text-align: justify;
}

/* Responsif biar tetap rapi di layar kecil */
@media (max-width: 900px) {
    .destination-detail {
        flex-direction: column;
        align-items: center;
    }

    .image-section,
    .info {
        flex: 1 1 100%;
        max-width: 100%;
    }

    .image-section img {
        max-width: 100%;
    }

    .btn-container {
        justify-content: center;
    }
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
            <span style="color:#000;">Manage</span>
            <span style="color:#134BC3;">Destinations</span>
        </h1>
        <a href="profil.php"><img src="../uploads/<?= $admin['gambar']; ?>" alt="Profil Admin"></a>
    </div>

    <div class="sub-header">
        <h2>
            <span style="color:#134BC3;">Destination</span>
            <span style="color:#000;">Details</span>
        </h2>
    </div>
    <div class="card">
        <div class="destination-detail">
            <div class="image-section">
                <img src="../uploads/<?= $wisata['gambar']; ?>" alt="<?= $wisata['nama_wisata']; ?>">
                <div class="btn-container">
                    <a href="edit_destinasi.php?wisata_id=<?= $wisata['wisata_id']; ?>" class="btn btn-edit"><i class="fa-solid fa-pen"></i> Edit</a>
                    <a href="hapus_destinasi.php?wisata_id=<?= $wisata['wisata_id']; ?>" onclick="return confirm('Yakin ingin menghapus destinasi ini?')" class="btn btn-hapus"><i class="fa-solid fa-trash"></i> Hapus</a>
                    <a href="destinasi.php" class="btn btn-kembali"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                </div>
            </div>

            <div class="info">
                <h3><?= $wisata['nama_wisata']; ?></h3>
                <div class="meta">
                    <div><i class="fa-solid fa-tags"></i><?= $wisata['nama_kategori']; ?></div>
                    <div><i class="fa-solid fa-location-dot"></i><?= $wisata['lokasi']; ?></div>
                </div>
                <p><?= nl2br($wisata['deskripsi']); ?></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>

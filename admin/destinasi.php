<?php
include "../koneksi.php";
session_start();

// ambil data admin buat header profil
$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'"));

// tambah data wisata
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $kategori_id = $_POST['kategori_id'];
    $lokasi = $_POST['lokasi'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../uploads/" . $gambar;
    move_uploaded_file($tmp, $path);

    $query = "INSERT INTO wisata (kategori_id, nama_wisata, lokasi, deskripsi, gambar)
              VALUES ('$kategori_id', '$nama', '$lokasi', '$deskripsi', '$gambar')";
    mysqli_query($koneksi, $query);
}

// ambil kategori untuk dropdown
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

// ambil daftar wisata untuk tabel
$wisata = mysqli_query($koneksi, "
    SELECT w.*, k.nama_kategori 
    FROM wisata w
    JOIN kategori k ON w.kategori_id = k.kategori_id
    ORDER BY w.wisata_id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Destinations</title>
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
        padding: 20px;
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
    .card {
        background: white;
        border-radius: 12px;
        padding: 20px 35px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }
    .card h2 {
        font-family: 'Abril Fatface';
        color: #134BC3;
        margin-top: 0px;
        margin-bottom: 18px;
        font-size: 25px;
    }
    .form-group {
        margin-bottom: 12px;
    }
    label { 
        font-weight: 500; 
        display: block; 
        margin-bottom: 5px; 
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
        height: 90px;
    }
    .form-row {
        display: flex; 
        gap: 15px; 
    }
    .form-row .form-group {
        flex: 1; 
    }
    button {
        width: 100%; /* tombol tetap panjang */
        background: #134BC3;
        color: white;
        border: none;
        padding: 12px 0;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        margin-top: 10px;
        transition: background 0.2s;
    }

    button:hover {
        background: #0F3EA0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: white;
    }
    th, td {
        border-bottom: 1px solid #ddd;
        text-align: left;
        padding: 10px;
    }
    th {
        background: #F0F3F8;
        color: #000;
        font-weight: 600;
    }
    td:last-child {
        text-align: center;
    }
    .btn-detail {
        background: #134BC3;
        color: white;
        margin-left: -33px;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-detail:hover {
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
        <h2>
            <span style="color:#134BC3;">Create</span> 
            <span style="color:#000000;">a New</span> 
            <span style="color:#134BC3;">Destination</span>
        </h2>
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label>Nama Wisata</label>
                <input type="text" name="nama_wisata" placeholder="Contoh: Pulau Komodo" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Tulis deskripsi wisata..." required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php while ($row = mysqli_fetch_assoc($kategori)): ?>
                            <option value="<?= $row['kategori_id']; ?>"><?= $row['nama_kategori']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" placeholder="Kabupaten Ende, Nusa Tenggara Timur" required>
                </div>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>

            <button type="submit" name="submit">Tambah Wisata</button>
        </form>
    </div>

    <div class="card">
        <h2>
            <span style="color:#134BC3;">Destination </span>
            <span style="color:#000000;">List</span>
        </h2>
        <table>
                <tr>
                    <th>No</th>
                    <th>Nama Wisata</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1; while ($w = mysqli_fetch_assoc($wisata)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $w['nama_wisata']; ?></td>
                    <td><?= $w['nama_kategori']; ?></td>
                    <td><?= $w['lokasi']; ?></td>
                    <td>
                        <a href="detail.php?wisata_id=<?= $w['wisata_id']; ?>" class="btn btn-detail">Detail</a>
                    </td>
                </tr>
                <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>

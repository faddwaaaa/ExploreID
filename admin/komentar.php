<?php
include "../koneksi.php";
session_start();

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'"));

// Ambil semua komentar
$komentar = mysqli_query($koneksi, "
    SELECT komentar.*, 
           users.nama AS user_nama,
           users.gambar AS user_gambar,
           admin.nama AS admin_nama,
           admin.gambar AS admin_gambar,
           wisata.nama_wisata
    FROM komentar
    LEFT JOIN users ON komentar.user_id = users.user_id
    LEFT JOIN admin ON komentar.admin_id = admin.admin_id
    LEFT JOIN wisata ON komentar.wisata_id = wisata.wisata_id
    ORDER BY komentar.timestamp DESC
");

// Hapus komentar
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM komentar WHERE komentar_id = $id");
    echo "<script>alert('Komentar berhasil dihapus!'); window.location='komentar.php';</script>";
    exit();
}

// Tambah komentar oleh admin
if (isset($_POST['submit_komentar'])) {
    $wisata_id = $_POST['wisata_id'];
    $komentar_text = $_POST['komentar'];
    $admin_id = $_SESSION['admin_id'];

    mysqli_query($koneksi, "
        INSERT INTO komentar (wisata_id, admin_id, user_id, komentar, timestamp)
        VALUES ('$wisata_id', '$admin_id', NULL, '$komentar_text', NOW())
    ");

    echo "<script>alert('Komentar admin berhasil ditambahkan!'); window.location='komentar.php';</script>";
    exit();
}

// Ambil daftar wisata untuk dropdown
$wisata_list = mysqli_query($koneksi, "SELECT * FROM wisata ORDER BY nama_wisata ASC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin - Comments</title>
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
        font-family: 'Jomhuria';
        margin-bottom: 30px;
        font-size: 30px;
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
        margin: 0;
    }

    .header img {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
    }

    table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 7px rgba(0,0,0,0.1);
}

    /* Header tabel */
    th {
        background: #E6E8EC;
        padding: 14px 10px;
        font-weight: 600;
        text-align: center;
        color: #333;
        font-size: 15px;
    }

    /* Isi tabel */
    td {
        padding: 12px 10px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    /* Hover */
    tr:hover td {
        background: #f7faff;
    }

    /* Profil img */
    .profile-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .btn-delete {
        background: #ff3b3b;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
    }
    .btn-delete:hover {
        background: #c30000;
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
            <span style="color:#134BC3;">Comments</span> 
            <span style="color:#000000;">Management</span>
        </h1>
        <a href="profil.php"><img src="../uploads/<?= $admin['gambar']; ?>" alt="Profil Admin"></a>
    </div>

    <div class="card" style="background:white; padding:20px; border-radius: 12px; margin-bottom:25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="font-family: 'Abril Fatface'; color:#134BC3; margin-top:0;">Add <span style="color: #000000;">Admin</span> Comment</h2>

        <form action="" method="POST">
            <div class="form-group" style="margin-bottom:12px;">
                <label>Pilih Wisata</label>
                <select name="wisata_id" required 
                    style="width:100%; padding:10px; border:1.5px solid #134BC3; border-radius:6px;">
                    <option value="">-- Pilih Wisata --</option>
                    <?php while ($w = mysqli_fetch_assoc($wisata_list)) : ?>
                        <option value="<?= $w['wisata_id']; ?>"><?= $w['nama_wisata']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label>Komentar Admin</label>
                <textarea name="komentar" placeholder="Tulis komentar admin..." required
                    style="width:100%; padding:12px; border:1.5px solid #134BC3; border-radius:6px; height:80px;"></textarea>
            </div>

            <button type="submit" name="submit_komentar"
                style="background:#134BC3; color:white; padding:12px; border:none; border-radius:8px; width:100%; cursor:pointer; font-weight:bold;">
                Tambah Komentar
            </button>
        </form>
    </div>

    <table>
        <tr>
            <th>Profil</th>
            <th>Nama</th>
            <th>Komentar</th>
            <th>Wisata</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($komentar)) { ?>
        <tr>
            <td>
                <img class="profile-img" 
                     src="../uploads/<?= $row['user_gambar'] ?: $row['admin_gambar'] ?>" 
                     alt="">
            </td>

            <td><?= $row['user_nama'] ?: $row['admin_nama'] ?></td>
            <td><?= $row['komentar'] ?></td>
            <td><?= $row['nama_wisata'] ?></td>
            <td><?= $row['timestamp'] ?></td>
            <td>
                <a class="btn-delete" 
                   href="?hapus=<?= $row['komentar_id'] ?>" 
                   onclick="return confirm('Hapus komentar ini?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

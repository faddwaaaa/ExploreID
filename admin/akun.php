<?php
include "../koneksi.php";
session_start();

// ambil data admin aktif untuk header profil
$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'"));

// ambil semua data admin & user
$data_admin = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY nama ASC");
$data_user = mysqli_query($koneksi, "SELECT * FROM users ORDER BY nama ASC");

// hapus akun
if (isset($_GET['hapus_admin'])) {
    $hapus_id = $_GET['hapus_admin'];
    mysqli_query($koneksi, "DELETE FROM admin WHERE admin_id='$hapus_id'");
    header("Location: akun.php");
}
if (isset($_GET['hapus_user'])) {
    $hapus_id = $_GET['hapus_user'];
    mysqli_query($koneksi, "DELETE FROM users WHERE user_id='$hapus_id'");
    header("Location: akun.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Manage Accounts</title>
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
    padding: 25px 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

.card h2 {
    font-family: 'Abril Fatface';
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 25px;
    color: #000;
}
.card h2 span {
    color: #134BC3;
}

/* tabel */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}
th, td {
    padding: 12px 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
th {
    background: #F0F3F8;
    color: #000;
    font-weight: 600;
}
td:last-child {
    text-align: center;
}

/* tombol hapus */
.btn-hapus {
    background: #E53935;
    margin-left: -35px;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-hapus:hover {
    background: #C62828;
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
        <h1><span style="color:#000">Manage</span> <span style="color:#134BC3;">Accounts</span></h1>
        <a href="profil.php"><img src="../uploads/<?= $admin['gambar']; ?>" alt="Profil"></a>
    </div>

    <!-- ADMIN -->
    <div class="card">
        <h2><span>Admin</span> Accounts</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($a = mysqli_fetch_assoc($data_admin)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($a['nama']); ?></td>
                <td><?= htmlspecialchars($a['email']); ?></td>
                <td><?= htmlspecialchars($a['password']); ?></td>
                <td>
                    <a href="akun.php?hapus_admin=<?= $a['admin_id']; ?>" onclick="return confirm('Yakin ingin menghapus admin ini?');">
                        <button class="btn-hapus"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- USERS -->
    <div class="card">
        <h2><span>User</span> Accounts</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($u = mysqli_fetch_assoc($data_user)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($u['nama']); ?></td>
                <td><?= htmlspecialchars($u['email']); ?></td>
                <td><?= htmlspecialchars($u['password']); ?></td>
                <td>
                    <a href="akun.php?hapus_user=<?= $u['user_id']; ?>" onclick="return confirm('Yakin ingin menghapus user ini?');">
                        <button class="btn-hapus"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>

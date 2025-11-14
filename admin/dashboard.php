<?php
session_start();
include "../koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Ambil data admin
$sql = mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$admin_id'");
$admin = mysqli_fetch_assoc($sql);

// Hitung jumlah
$destinations = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM wisata"))['total'];
$user_count  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users"))['total'];
$admin_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin"))['total'];
$accounts = $user_count + $admin_count;
$categories = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];
$comments = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM komentar"))['total'];


// Activity log
$log = mysqli_query($koneksi, "SELECT * FROM activity_log ORDER BY waktu DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
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
            background: #FFFFFF;
            color: #134BC3;  /* font menjadi biru */
        }

        .sidebar a:hover i {
            color: #134BC3; /* icon ikut biru */
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

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 40px;
            text-align: center;
            position: relative;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-icon {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 45px;
            color: #134BC3;
            opacity: 0.9;
        }

        .card h2 {
            margin: 0;
            font-size: 40px;
            color: #000;
            margin-right: 85px;
        }

        .card p {
            margin-top: 8px;
            font-size: 16px;
            color: #676767ff;
            margin-right: 85px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 7px rgba(0,0,0,0.1);
            table-layout: fixed;
        }

        th {
            background: #cdcdcdff;
            color: #000;
            padding: 12px;
            text-align: center;
            word-wrap: break-word; 
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            word-wrap: break-word; 
        }

        tr:hover {
            background: #f0f4ff;
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
            <span style="color:#000000;">Selamat Datang,</span> 
            <span style="color:#134BC3;"><?= $admin['nama']; ?></span>
            <span style="color:#000000;">!</span>
        </h1>
        <a href="profil.php"><img src="../uploads/<?= $admin['gambar']; ?>" alt="Profil Admin"></a>
    </div>

    <div class="cards">
        <div class="card">
            <h2><?= $destinations ?></h2>
            <p>Destinations</p>
            <a href="destinasi.php"><i class="fa-solid fa-map-location-dot card-icon"></i></a>
        </div>

        <div class="card">
            <h2><?= $accounts ?></h2>
            <p>Accounts</p>
            <a href="akun.php"><i class="fa-solid fa-users card-icon"></i></a>
        </div>

        <div class="card">
            <h2><?= $categories ?></h2>
            <p>Categories</p>
            <a href="kategori.php"><i class="fa-solid fa-tags card-icon"></i></a>
        </div>

        <div class="card">
            <h2><?= $comments ?></h2>
            <p>Comments</p>
            <a href="komentar.php"><i class="fa-solid fa-comment card-icon"></i></a>
        </div>

    </div>

    <h2 style="margin-left: 10px; margin-bottom: 10px; font-family: 'Abril Fatface'; color:#134BC3; font-size: 25px;">
        <span style="color:#000000;">Recent</span>
        <span style="color:#134BC3;">Activity</span>
        <span style="color:#000000;">Section</span>
    </h2>

    <table>
        <tr>
            <th>Waktu</th>
            <th>Aksi</th>
            <th>ID Admin</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($log)) { ?>
        <tr>
            <td><?= $row['waktu'] ?></td>
            <td><?= $row['aksi'] ?></td>
            <td><?= $row['admin_id'] ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>

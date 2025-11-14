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
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Admin | ExploreID</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(180deg, #EAF1FF, #134BC3);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.profile-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 40px 60px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    text-align: center;
    width: 420px;
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.profile-card img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 4px solid #134BC3;
    object-fit: cover;
    margin-bottom: 20px;
    box-shadow: 0 0 10px rgba(19,75,195,0.3);
}

.profile-card h2 {
    font-family: 'Abril Fatface';
    color: #134BC3;
    font-size: 26px;
    margin-bottom: 15px;
}

.info {
    text-align: left;
    margin-top: 20px;
}

.info p {
    font-size: 15px;
    margin: 10px 0;
    color: #333;
}

.label {
    font-weight: 600;
    color: #134BC3;
}

.btn-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    gap: 12px;
}

button {
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 500;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-back {
    background-color: #134BC3;
}

.btn-back:hover {
    background-color: #0e3b9b;
}

.btn-edit {
    background-color: #EC0909;
}

.btn-edit:hover {
    background-color: #b90606;
}
</style>
</head>
<body>

<div class="profile-card">
    <img src="../uploads/<?= $admin['gambar'] ?>" alt="Foto Admin">
    <h2>Profil Admin</h2>

    <div class="info">
        <p><span class="label">Admin ID:</span> <?= htmlspecialchars($admin['admin_id']) ?></p>
        <p><span class="label">Nama:</span> <?= htmlspecialchars($admin['nama']) ?></p>
        <p><span class="label">Email:</span> <?= htmlspecialchars($admin['email']) ?></p>
        <p><span class="label">Password:</span> <?= htmlspecialchars($admin['password']) ?></p>
    </div>

    <div class="btn-container">
        <button class="btn-back" onclick="window.location.href='dashboard.php'"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
        <button class="btn-edit" onclick="window.location.href='edit_profile.php'"><i class="fa-solid fa-pen-to-square"></i> Edit Profil</button>
    </div>
</div>

</body>
</html>

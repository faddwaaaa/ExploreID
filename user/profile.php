<?php
session_start();
include '../koneksi.php';
include 'navbar.php';

// Ambil data user dari session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id = '$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil User | ExploreID</title>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #fafafa;
            padding-top: 80px;
        }
        .profile-container {
            text-align: center;
            padding: 50px 20px;
        }
        .profile-container h1 {
            font-family: 'Abril Fatface';
            font-size: 32px;
            margin-bottom: 10px;
        }
        .profile-container h1 span {
            color: #134BC3;
        }
        .profile-container p {
            color: #555;
            margin-bottom: 40px;
        }
        .profile-card {
            background: #fff;
            display: inline-flex;
            align-items: center;
            gap: 25px;
            padding: 25px 40px;
            border-radius: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #E8E8E8;
        }
        .profile-info {
            text-align: left;
        }
        .profile-info h2 {
            font-family: 'Abril Fatface';
            margin: 0;
        }
        .profile-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .profile-info strong {
            color: #999;
        }
        .edit-btn {
            margin-top: 20px;
            padding: 10px 25px;
            border: none;
            background-color: #134BC3;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .edit-btn:hover {
            background-color: #0d3a94;
        }
        /* Form edit profil */
        .edit-form {
            display: none;
            margin: 40px auto;
            max-width: 400px;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .edit-form input[type="text"], 
        .edit-form input[type="email"], 
        .edit-form input[type="password"], 
        .edit-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .edit-form input[type="submit"] {
            width: 100%;
            background-color: #134BC3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .edit-form input[type="submit"]:hover {
            background-color: #0d3a94;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1>Welcome Back, <span><?= htmlspecialchars($user['nama']) ?></span>!</h1>
    <p>Lihat dan kelola destinasi favoritmu, simpan kenangan perjalanan,<br>dan lanjutkan petualanganmu di ExploreID.</p>

    <div class="profile-card">
        <img src="../uploads/<?= $user['gambar'] ?>" alt="Foto Profil">
        <div class="profile-info">
            <h2><?= htmlspecialchars($user['nama']) ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Password:</strong> <?= htmlspecialchars($user['password']) ?></p>
            <button class="edit-btn" id="editBtn">Edit Profil</button>
        </div>
    </div>


    <!-- Form Edit Profil -->
    <form class="edit-form" id="editForm" action="update_profile.php" method="POST" enctype="multipart/form-data">
        <h3 style="text-align:center; margin-bottom:15px;">Edit Profil</h3>
        <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" placeholder="Nama Lengkap" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
        <label for="foto">Foto Profil:</label>
        <input type="file" name="foto" accept="image/*">
        <input type="submit" value="Simpan Perubahan">
    </form>
</div>

<?php include 'footer.php'; ?>

<script>
    const editBtn = document.getElementById('editBtn');
    const editForm = document.getElementById('editForm');

    editBtn.addEventListener('click', () => {
        editForm.style.display = editForm.style.display === 'block' ? 'none' : 'block';
        editBtn.textContent = editForm.style.display === 'block' ? 'Batal Edit' : 'Edit Profil';
    });
</script>

</body>
</html>

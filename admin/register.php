<?php
include "../koneksi.php";

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/" . $foto);

    $query = "INSERT INTO admin (nama, email, password, gambar) 
              VALUES ('$nama', '$email', '$password', '$foto')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: login.php?success=1");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Register</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(#FFFFFF, #134BC3);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 360px;
        background: rgba(255, 255, 255, 0.7);
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        text-align: center;
        box-sizing: border-box;
    }

    h2 {
        font-family: 'Abril Fatface', cursive;
        color: #134BC3;
        margin-bottom: 8px;
    }

    p {
        font-size: 14px;
        color: #444;
        margin-bottom: 16px;
    }

    .input-group {
        position: relative;
        width: 100%;
        margin-top: 10px;
    }

    .input-group input,
    .input-file {
        width: 100%;
        padding: 12px 12px 12px 42px;
        background: #EEEEEE;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .input-file {
        padding-left: 12px;
    }

    .input-group i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #134BC3;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 16px;
        border: none;
        border-radius: 10px;
        background: #134BC3;
        color: white;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }

    button:hover {
        background: #0d3a94;
    }

    .login-link {
        margin-top: 12px;
        font-size: 14px;
    }

    .login-link a {
        color: #134BC3;
        text-decoration: none;
    }

</style>
</head>
<body>

<div class="container">    
    <h2><span style="color: #000;">Let's Get</span> <span style="color: #134BC3;">Started</span></h2>
    <p>Buat akunmu dan mulai menjelajahi destinasi favoritmu.</p>

    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="nama" placeholder="Name" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-image"></i>
            <input type="file" name="foto" class="input-file" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Confirm Password" required>
        </div>

        <button type="submit" name="submit">Sign Up</button>

        <div class="login-link">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </form>
</div>

</body>
</html>
<?php
session_start();
include "../koneksi.php";
include "navbar.php";

if (!isset($_GET['id'])) {
    header("Location: destination.php");
    exit;
}

$wisata_id = (int)$_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT w.*, k.nama_kategori 
    FROM wisata w 
    JOIN kategori k ON w.kategori_id = k.kategori_id 
    WHERE wisata_id = $wisata_id
");

if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='destination.php';</script>";
    exit;
}

$wisata = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Wisata - <?= htmlspecialchars($wisata['nama_wisata']); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #F4F6FA;
    padding-top: 80px;
}

/* === Judul utama halaman === */
.text-judul {
    text-align: center;
    font-family: 'Abril Fatface';
    font-size: 38px;
    margin-top: 50px;
    margin-bottom: 10px;
}

.text-judul span { 
    color: #134BC3; 
}

.text-info p {
    text-align: center;
    color: #444;
    font-size: 15px;
    margin-bottom: 40px;
}

/* === Container utama === */
.container {
    max-width: 1100px;
    margin: 40px auto;
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    position: relative;
}

/* === Tombol navigasi atas === */
.top-buttons {
    position: absolute;
    top: 25px;
    left: 25px;
    right: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Tombol kembali & favorit */
.icon-btn {
    border: 2px solid #134BC3;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.icon-btn i {
    font-size: 20px;
    color: #134BC3;
    transition: color 0.3s;
}

.icon-btn:hover {
    background: #134BC3;
}

.icon-btn:hover i {
    color: white;
}

/* === Konten utama === */
.detail-content {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 25px;
    margin-top: 60px;
}

/* Gambar */
.image-section {
    flex: 0 0 350px;
    text-align: center;
}

.image-section img {
    width: 100%;
    height: auto;
    border-radius: 18px;
    object-fit: cover;
}

/* Info */
.info-section {
    flex: 1 1 500px;
    min-width: 300px;
}

/* Bedakan h2 di info-section agar tidak kena style global */
.info-section h3 {
    font-family: 'Abril Fatface';
    font-size: 26px;
    color: #000;
    margin: 0 0 10px;
}

.meta {
    margin-bottom: 15px;
}

.meta div {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    margin-bottom: 5px;
}

.meta .fa-tags { color: #FFA500; }
.meta .fa-location-dot { color: #EC0909; }

.info-section p {
    text-align: justify;
    line-height: 1.6;
    color: #000;
}

/* Responsif */
@media (max-width: 900px) {
    .detail-content {
        flex-direction: column;
        align-items: center;
    }
    .image-section, .info-section {
        flex: 1 1 100%;
        max-width: 100%;
    }
    .icon-btn {
        width: 42px;
        height: 42px;
    }
}
</style>
</head>
<body>
    
    <h2 class="text-judul">Detail <span>Wisata</span></h2>
    <div class="text-info">
        <p>Lihat lebih dekat pesona setiap destinasi pilihanmu.</p>
    </div>

<div class="container">

    <div class="top-buttons">
        <a href="destination.php" class="icon-btn" title="Kembali">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="tambah_favorit.php" method="POST" style="display:inline;">
                <input type="hidden" name="wisata_id" value="<?= $wisata_id; ?>">
                <button type="submit" name="favorit" class="icon-btn" title="Tambahkan ke Favorit">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </form>
        <?php else: ?>
            <a href="login.php" class="icon-btn" title="Login untuk menyimpan favorit">
                <i class="fa-regular fa-heart"></i>
            </a>
        <?php endif; ?>
    </div>

    <div class="detail-content">
        <div class="image-section">
            <img src="../uploads/<?= htmlspecialchars($wisata['gambar']); ?>" alt="<?= htmlspecialchars($wisata['nama_wisata']); ?>">
        </div>
        <div class="info-section">
            <h3><?= htmlspecialchars($wisata['nama_wisata']); ?></h3>
            <div class="meta">
                <div><i class="fa-solid fa-tags"></i> <?= htmlspecialchars($wisata['nama_kategori']); ?></div>
                <div><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($wisata['lokasi']); ?></div>
            </div>
            <p><?= nl2br(htmlspecialchars($wisata['deskripsi'])); ?></p>
        </div>
    </div>
</div>
<!-- ======= BAGIAN KOMENTAR ======= -->
<div class="container" style="margin-top:30px;">

    <h2 style="font-family:'Abril Fatface'; margin-bottom:10px;">Komentar</h2>
    <p style="color:#666; margin-top:0;">Pendapat pengunjung tentang destinasi ini.</p>

    <?php
    // Ambil komentar berdasarkan wisata_id
    $qKomentar = mysqli_query($koneksi, "
        SELECT k.*, 
            u.nama AS user_nama,
            a.nama AS admin_nama
        FROM komentar k
        LEFT JOIN users u ON k.user_id = u.user_id
        LEFT JOIN admin a ON k.admin_id = a.admin_id
        WHERE k.wisata_id = $wisata_id
        ORDER BY k.timestamp DESC
    ");

    if (mysqli_num_rows($qKomentar) == 0) {
        echo "<p style='color:#777;'>Belum ada komentar.</p>";
    }
    ?>

    <!-- List komentar -->
    <?php while ($km = mysqli_fetch_assoc($qKomentar)) : ?>
        <div style="
            background:#fff;
            padding:18px;
            border-radius:12px;
            margin-bottom:15px;
            box-shadow:0 2px 6px rgba(0,0,0,0.08);
        ">
            <strong>
                <?= $km['user_id'] ? htmlspecialchars($km['user_nama']) : "Admin • " . htmlspecialchars($km['admin_nama']) ?>
            </strong>
            <span style="color:#999; font-size:13px;">
                • <?= date("d M Y H:i", strtotime($km['timestamp'])) ?>
            </span>

            <p style="margin-top:8px; color:#333;">
                <?= nl2br(htmlspecialchars($km['komentar'])); ?>
            </p>
        </div>
    <?php endwhile; ?>


    <!-- Form Tambah Komentar -->
    <div style="margin-top:25px;">
        <?php if (isset($_SESSION['user_id'])) : ?>
            <form action="proses_komentar.php" method="POST">
                <input type="hidden" name="wisata_id" value="<?= $wisata_id ?>">

                <textarea name="komentar" required
                    placeholder="Tulis komentar kamu..."
                    style="
                        width:100%; 
                        height:110px; 
                        padding:12px; 
                        font-size:15px; 
                        border-radius:10px; 
                        border:1px solid #ccc;
                        resize:none;
                    "
                ></textarea>

                <button type="submit" name="kirim" 
                    style="
                        margin-top:10px;
                        background:#134BC3;
                        color:white;
                        padding:10px 22px;
                        border:none;
                        border-radius:8px;
                        font-size:15px;
                        cursor:pointer;
                        transition:.3s;
                    "
                >Kirim</button>
            </form>
        <?php else : ?>
            <p style="margin-top:15px; color:#555;">
                <a href="login.php" style="color:#134BC3; font-weight:600;">
                    Login untuk menulis komentar
                </a>
            </p>
        <?php endif; ?>
    </div>

</div>

<?php include "footer.php"; ?>
</body>
</html>

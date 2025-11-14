<?php
session_start();
include "../koneksi.php";
include "navbar.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$query = "
  SELECT w.*
  FROM favorit f
  JOIN wisata w ON f.wisata_id = w.wisata_id
  WHERE f.user_id = $user_id
  ORDER BY f.wisata_id DESC
";
$result = mysqli_query($koneksi, $query);

$komentar_query = mysqli_query($koneksi,
    "SELECT wisata_id, COUNT(*) AS total 
     FROM komentar 
     GROUP BY wisata_id"
);

$komentar_count = [];
while ($k = mysqli_fetch_assoc($komentar_query)) {
    $komentar_count[$k['wisata_id']] = $k['total'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Favorite | ExploreID</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  padding-top: 80px;
}

.container {
  padding: 20px 100px;
}

h2 {
  text-align: center;
  font-family: 'Abril Fatface', cursive;
  font-size: 38px;
  margin-bottom: 10px;
}

h2 span {
  color: #134BC3;
}

.text-info p {
  text-align: center;
  color: #444;
  font-size: 15px;
  line-height: 1.6;
  max-width: 650px;
  margin: 0 auto 40px;
}

.card-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 30px;
}

.card-wisata {
  width: 240px;
  background: white;
  border-radius: 25px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  text-align: center;
  transition: all 0.3s ease;
  border: 4px solid transparent;
  position: relative;
}

.card-wisata:hover {
  transform: translateY(-8px);
  border-color: #134BC3;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  border: 2px solid #134BC3;
}

.card-wisata img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-top-left-radius: 25px;
  border-top-right-radius: 25px;
}

.card-wisata h4 {
  margin: 10px 0 8px;
  font-size: 16px;
  font-weight: 600;
  color: #000;
}

.card-wisata a.detail-btn {
  display: inline-block;
  background: #134BC3;
  color: white;
  text-decoration: none;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 500;
}

.love-btn {
  position: absolute;
  bottom: 10px;
  right: 10px;
  background: white;
  border: none;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.love-btn i {
  color: #e63946;
  font-size: 18px;
}

@media (max-width: 900px) {
  .container {
    padding: 40px 30px;
  }
}
</style>
</head>
<body>
<div class="container">
  <h2>Your <span>Favorite</span> Destinations, All in <span>One Place</span></h2>
  <div class="text-info">
    <p>Temukan kembali destinasi yang paling Anda sukai — keindahan yang selalu ingin Anda kunjungi lagi.</p>
  </div>

  <div class="card-container">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="card-wisata">
          <div style="position:relative;">
            <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama_wisata']); ?>">
                <div style="
                    position:absolute;
                    top:10px;
                    left:10px;
                    display:flex;
                    align-items:center;
                    gap:5px;
                    z-index: 10;
                ">
                    <i class="fa-solid fa-comment"
                      style="
                            color:white;
                            font-size:15px;
                            background:#134BC3;
                            padding:6px;
                            border-radius:6px;
                        ">
                    </i>

                    <span style="
                        font-size:13px;
                        font-weight:600;
                        color:#134BC3;
                        background:white;
                        padding:4px 8px;
                        border-radius:6px;
                    ">
                        <?= $komentar_count[$row['wisata_id']] ?? 0 ?>
                    </span>
                </div>  
            <form action="hapus_favorit.php" method="POST" style="position:absolute; bottom:10px; right:10px;">
              <input type="hidden" name="wisata_id" value="<?= $row['wisata_id']; ?>">
              <button type="submit" name="hapus" class="love-btn">
                <i class="fa-solid fa-heart"></i>
              </button>
            </form>
          </div>
          <div style="padding:15px;">
            <h4><?= htmlspecialchars($row['nama_wisata']); ?></h4>
            <a href="detail.php?id=<?= $row['wisata_id']; ?>" class="detail-btn">Detail Wisata</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; color:#555;">Belum ada destinasi favorit.</p>
    <?php endif; ?>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

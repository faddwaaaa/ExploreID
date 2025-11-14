<?php
session_start();
include "../koneksi.php";
include "navbar.php";

$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori");

$where = "";
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $where .= " AND nama_wisata LIKE '%$search%'";
}
if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
    $kategori_id = (int)$_GET['kategori'];
    $where .= " AND kategori_id = $kategori_id";
}

$query = "SELECT * FROM wisata WHERE 1 $where ORDER BY wisata_id DESC";
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
<title>Destinasi | ExploreID</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  padding-top: 80px;
}

.container {
  padding: 20px 60px;
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

.filter-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-bottom: 50px;
  flex-wrap: wrap;
  position: relative;
}

.search-box {
  position: relative;
}

.search-box input {
  padding: 12px 45px 12px 18px;
  border: 2px solid #134BC3;
  border-radius: 30px;
  font-size: 14px;
  outline: none;
  width: 240px;
  transition: all 0.3s ease;
}

.search-box input:focus {
  box-shadow: 0 0 0 3px rgba(19, 75, 195, 0.15);
}

.search-box i {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #134BC3;
  font-size: 16px;
}

.dropdown {
  position: relative;
}

.dropdown-btn {
  background-color: #134BC3;
  color: #fff;
  border: none;
  padding: 12px 25px;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background 0.3s;
}

.dropdown-btn:hover {
  background-color: #0d3a94;
}

.dropdown-content {
  display: none;
  position: absolute;
  top: 50px;
  left: 0;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  min-width: 180px;
  z-index: 99;
  opacity: 0;
  transform: translateY(-10px);
  transition: all 0.25s ease;
}

.dropdown-content.show {
  display: block;
  opacity: 1;
  transform: translateY(0);
}

.dropdown-content button {
  display: block;
  width: 100%;
  text-align: left;
  background: none;
  border: none;
  padding: 10px 15px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  color: #333;
}

.dropdown-content button:hover {
  background-color: #134BC3;
  color: white;
}

.filter-bar button.submit-btn {
  background: #134BC3;
  color: white;
  padding: 10px 22px;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.3s;
}

.filter-bar button.submit-btn:hover {
  background: #0d3a94;
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

@media (max-width: 900px) {
  .container {
    padding: 40px 30px;
  }
}
</style>
</head>
<body>
<div class="container">
  <h2>East Nusa Tenggara, <span>Beyond</span> the <span>Horizon</span></h2>
  <div class="text-info">
    <p>Keindahan tak terbatas yang menggabungkan panorama alam spektakuler dengan kekayaan budaya yang menginspirasi perjalanan Anda.</p>
  </div>

  <form method="GET" class="filter-bar">
    <div class="search-box">
      <input type="text" name="search" placeholder="Cari wisata..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
      <i class="fa fa-search"></i>
    </div>

    <div class="dropdown">
      <button type="button" class="dropdown-btn">
        <?= isset($_GET['kategori']) && $_GET['kategori'] != '' ?htmlspecialchars(mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE kategori_id=" . (int)$_GET['kategori']))['nama_kategori']) : 'Pilih Kategori'; ?>
        <i class="fa fa-chevron-down"></i>
      </button>
      <div class="dropdown-content">
        <button type="submit" name="kategori" value="">Semua Kategori</button>
        <?php
        $kategori_query2 = mysqli_query($koneksi, "SELECT * FROM kategori");
        while ($kat = mysqli_fetch_assoc($kategori_query2)) :
        ?>
          <button type="submit" name="kategori" value="<?= $kat['kategori_id']; ?>">
            <?= htmlspecialchars($kat['nama_kategori']); ?>
          </button>
        <?php endwhile; ?>
      </div>
    </div>
    <button type="submit" class="submit-btn">Cari</button>
  </form>

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
            <?php if (isset($_SESSION['user_id'])): ?>
              <form action="tambah_favorit.php" method="POST" style="position:absolute; bottom:10px; right:10px;">
                <input type="hidden" name="wisata_id" value="<?= $row['wisata_id']; ?>">
                <button type="submit" name="favorit" class="love-btn">
                  <i class="fa-regular fa-heart" style="color:#134BC3; font-size:18px;"></i>
                </button>
              </form>
            <?php else: ?>
              <a href="login.php" class="love-btn">
                <i class="fa-regular fa-heart" style="color:#134BC3; font-size:18px;"></i>
              </a>
            <?php endif; ?>
          </div>
          <div style="padding:15px;">
            <h4><?= htmlspecialchars($row['nama_wisata']); ?></h4>
            <a href="detail.php?id=<?= $row['wisata_id']; ?>" class="detail-btn">Detail Wisata</a>
            <div style="position:absolute; top:10px; left:10px; display:flex; align-items:center; gap:5px;">
              <i class="fa-solid fa-comment" style="color:white; font-size:15px; 
                  background:#134BC3; padding:6px; border-radius:6px;"></i>

              <span style="font-size:13px; font-weight:600; color:#134BC3;
                  background:white; padding:4px 8px; border-radius:6px;">
                  <?= $komentar_count[$row['wisata_id']] ?? 0 ?>
              </span>
          </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; color:#555;">Tidak ada destinasi ditemukan.</p>
    <?php endif; ?>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const dropdownBtn = document.querySelector('.dropdown-btn');
  const dropdownMenu = document.querySelector('.dropdown-content');

  dropdownBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  document.addEventListener('click', function(e) {
    if (!dropdownBtn.contains(e.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
});
</script>
<?php include "footer.php"; ?>
</body>
</html>

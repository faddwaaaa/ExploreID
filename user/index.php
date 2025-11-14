<?php
include "../koneksi.php";

$query = "SELECT * FROM wisata ORDER BY wisata_id DESC LIMIT 4";
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
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home | ExploreID</title>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background-color: #fff;
        overflow-x: hidden;
        padding-top: 80px;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.9s ease-out;
    }
    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 90px 100px;
        background: #fff;
    }

    .hero-text {
        max-width: 520px;
    }

    .hero-text h1 {
        font-family: 'Abril Fatface', cursive;
        font-size: 48px;
        line-height: 1.2;
        margin: 0;
        color: #000;
    }

    .hero-text h1 span {
        color: #134BC3;
    }

    .hero-text p {
        margin-top: 20px;
        color: #444;
        line-height: 1.6;
        font-size: 16px;
    }

    .hero-buttons {
        margin-top: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .hero-buttons a {
        text-decoration: none;
        font-weight: 500;
    }

    .btn-explore {
        background: #134BC3;
        color: white;
        padding: 10px 24px;
        border-radius: 25px;
        font-size: 15px;
        transition: background 0.3s;
    }

    .btn-explore:hover {
        background: #0d3a94;
    }

    .btn-play {
        background: #134BC3;
        color: white;
        padding: 10px 13px;
        border-radius: 50%;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-images {
        position: relative;
        width: 700px;
        height: 480px;
    }

    .hero-images img {
        position: absolute;
        width: 340px;
        height: 220px;
        object-fit: cover;
        border-radius: 25px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .hero-images img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .hero-images img:nth-child(1) {
        top: 0;
        left: 140px;
    }

    .hero-images img:nth-child(2) {
        top: 130px;
        right: 40px;
    }

    .hero-images img:nth-child(3) {
        bottom: 0;
        left: 80px;
    }

    @media (max-width: 900px) {
        .hero {
            flex-direction: column;
            text-align: center;
            gap: 40px;
            padding: 60px 30px;
        }

        .hero-images {
            width: 100%;
            height: 300px;
        }

        .hero-images img {
            width: 45%;
            height: 150px;
        }
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

    .card-wisata:hover a {
        background: #134BC3;
    }

    .card-wisata img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    
    .garis-hr hr {
        width: 90%;
        margin: 20px auto;
        border: none;
        border-top: 1px solid #000;
    }

    .garis hr{
        width: 90%;
        margin: 30px auto;
        border: none;
        border-top: 1px solid #000;
    }

    section img[alt="Blog NTT"] {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    section img[alt="Blog NTT"]:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
</style>
</head>
<body>

<section class="hero fade-in">
    <div class="hero-text">
        <h1>Discover the <br><span>Beauty</span> of <br>East Nusa Tenggara!</h1>
        <p>Eksplorasi keindahan alam, tradisi unik, dan destinasi menakjubkan di Nusa Tenggara Timur.</p>
        <div class="hero-buttons">
            <a href="destination.php" class="btn-explore">Explore More</a>
            <a href="https://www.youtube.com/playlist?list=PLIBIOGNqCSPD-DjokRuhLlF9U0truRvRA" class="btn-play"><i class="fa-solid fa-play"></i></a>
        </div>
    </div>
    <div class="hero-images">
        <img src="images/foto1.jpg" alt="">
        <img src="images/foto2.jpg" alt="">
        <img src="images/foto3.jpg" alt="">
    </div>
</section>

<div class="garis-hr fade-in"><hr></div>

<!-- EXPLORE NTT SECTION -->
<section class="fade-in" style="padding: 20px 80px;">
    <h2 style="text-align:center; font-family: 'Abril Fatface'; font-size:32px; margin-bottom:10px;">
        Explore <span style="color:#134BC3;">NTT</span>
    </h2>
    <p style="text-align:center; color:#555; margin-bottom:40px;">
        Dari pantai eksotis hingga budaya yang kaya, inspirasi perjalanan ada di sini.
    </p>

    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:30px;">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="card-wisata fade-in">
                    <div style="position:relative;">
                        <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                             alt="<?= htmlspecialchars($row['nama_wisata']); ?>">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="tambah_favorit.php" method="POST" style="position:absolute; bottom:10px; right:10px;">
                                <input type="hidden" name="wisata_id" value="<?= $row['wisata_id']; ?>">
                                <button type="submit" name="favorit" style="background:white; border:none; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 3px 8px rgba(0,0,0,0.15);">
                                    <i class="fa-regular fa-heart" style="color:#134BC3; font-size:18px;"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" style="position:absolute; bottom:10px; right:10px; background:white; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 8px rgba(0,0,0,0.15); text-decoration:none;">
                                <i class="fa-regular fa-heart" style="color:#134BC3; font-size:18px;"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div style="padding:15px;">
                        <h4 style="margin:10px 0 8px; font-size:16px; font-weight:600; color:#000;">
                            <?= htmlspecialchars($row['nama_wisata']); ?>
                        </h4>
                        <a href="detail.php?id=<?= $row['wisata_id']; ?>" 
                           style="display:inline-block; background:#134BC3; color:white; text-decoration:none; padding:6px 14px; border-radius:20px; font-size:14px; font-weight:500;">
                           Detail Wisata
                        </a>
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
            <p style="text-align:center; color:#555;">Belum ada destinasi yang ditambahkan.</p>
        <?php endif; ?>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="destination.php" style="color:#000; font-weight:500; text-decoration:none;">See more</a>
    </div>
</section>

<div class="garis fade-in"><hr></div>

<!-- OUR BLOG SECTION -->
<section class="fade-in" style="padding: 20px 80px;">
    <h2 style="text-align:center; font-family: 'Abril Fatface'; font-size:32px; margin-bottom:15px;">
        <span style="color:#134BC3;">Our</span> Blog
    </h2>
    <p style="text-align:center; color:#555; margin-bottom:50px;">
        Kenali Lebih Dekat Dunia yang Tersaji di Sini
    </p>

    <div style="display:flex; align-items:center; justify-content:center; gap:40px; flex-wrap:wrap;">
        <img src="images/blog.jpg" alt="Blog NTT" style="width:420px; height:260px; object-fit:cover; border-radius:25px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
        <div style="max-width:450px;">
            <h3 style="font-family:'Abril Fatface'; font-size:22px; margin-bottom:10px;">Mengenal Lebih Dekat Nusa Tenggara Timur</h3>
            <p style="color:#444; line-height:1.6; margin-bottom:20px;">
                Laman ini menjadi ruang untuk berbagi pengetahuan, cerita, dan rekomendasi destinasi di NTT. 
                Dari laut yang jernih, pulau-pulau eksotis, hingga budaya yang kaya makna, semua tersaji untuk memberi gambaran luas tentang keindahan Nusa Tenggara Timur.
            </p>
            <a href="about.php" style="text-decoration:none; color:#000; font-weight:600; font-size:14px;">Read more →</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
const fadeEls = document.querySelectorAll('.fade-in');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
}, { threshold: 0.2 });

fadeEls.forEach(el => observer.observe(el));
</script>

</body>
</html>

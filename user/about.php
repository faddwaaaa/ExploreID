<?php
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | ExploreID</title>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #000;
            padding-top: 80px;
        }

        h2 {
            font-family: 'Abril Fatface', cursive;
            text-align: center;
            font-size: 38px;
            margin: 40px 0 10px;
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
                
        .image-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .image-row img {
            width: 240px;
            height: 160px;
            object-fit: cover;
            border-radius: 25px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-row img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .garis hr {
            width: 90%;
            margin: 40px auto;
            border: none;
            border-top: 1px solid #000;
        }

        .journey {
            text-align: center;
            margin-bottom: 50px;
        }

        .journey h2 {
            font-family: 'Abril Fatface', cursive;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .journey h2 span {
            color: #134BC3;
        }

        .journey-content {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 40px;
            flex-wrap: wrap;
            max-width: 900px;
            margin: 0 auto;
            text-align: left;
            position: relative;
            padding: 30px;
        }

        .divider {
            width: 1px;
            background-color: #000000a0;
            margin: 0 20px;
        }

        @media (max-width: 768px) {
            .divider {
                display: none;
            }
        }

        .journey-item {
            flex: 1;
            min-width: 280px;
        }

        .journey-item h4 {
            font-family: 'Abril Fatface', cursive;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .journey-item p {
            text-align: left;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .choose {
            text-align: center;
            margin-bottom: 80px;
        }

        .choose h2 {
            font-family: 'Abril Fatface', cursive;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .choose h2 span {
            color: #134BC3;
        }

        .choose-boxes {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .choose-item {
            flex: 1;
            min-width: 250px;
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: relative;
            border-top: 4px solid #134BC3;
            border-bottom: 4px solid #134BC3;
            transition: transform 0.4s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        
        .choose-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .choose-item h4 {
            font-family: 'Abril Fatface', cursive;
            font-size: 20px;
            margin-bottom: 15px;
            margin-top: 20px;
        }

        .choose-item p {
            text-align: center;
            color: #555;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }

        @media (max-width: 768px) {
            .journey-content {
                flex-direction: column;
                align-items: center;
            }

            .choose-boxes {
                flex-direction: column;
                align-items: center;
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- Who We Are -->
    <h2 class="fade-in">Who <span>We</span> Are</h2>
    <div class="text-info fade-in">
        <p>Website ini hadir sebagai ruang berbagi informasi dan inspirasi pariwisata, khususnya tentang keindahan alam dan budaya di Nusa Tenggara Timur.</p>
    </div>

    <div class="image-row fade-in">
        <img src="images/about1.jpg" alt="">
        <img src="images/about2.jpg" alt="">
        <img src="images/about3.jpg" alt="">
        <img src="images/about4.jpg" alt="">
    </div>

    <div class="garis fade-in">
        <hr>
    </div>

    <!-- Our Journey -->
    <div class="journey fade-in">
        <h2>Our <span>Journey</span> & <span>Inspiration</span></h2>
        <div class="journey-content">
            <div class="journey-item">
                <h4>The Vision & Mission</h4>
                <p>Kami percaya bahwa setiap perjalanan dimulai dari sebuah cerita. Karena itu, kami berusaha menyajikan informasi pariwisata yang tidak hanya menarik, tetapi juga memberi wawasan tentang keunikan destinasi, budaya, dan tradisi lokal.</p>
            </div>

            <div class="divider"></div>

            <div class="journey-item">
                <h4>What We Share</h4>
                <p>Di sini, Anda dapat menemukan rekomendasi wisata alam, sejarah, budaya, serta cerita menarik yang dapat menambah pengetahuan Anda sebelum berkunjung langsung.</p>
            </div>
        </div>
    </div>

    <div class="garis fade-in">
        <hr>
    </div>

    <!-- Why Choose Us -->
    <div class="choose fade-in">
        <h2>Why <span>Choose</span> Us</h2>
        <div class="choose-boxes">
            <div class="choose-item">
                <h4>Trusted Information</h4>
                <p>Disusun dari sumber yang akurat dan terpercaya.</p>
            </div>
            <div class="choose-item">
                <h4>Culture & Nature</h4>
                <p>Menyajikan destinasi populer sekaligus sisi lokal yang jarang diketahui.</p>
            </div>
            <div class="choose-item">
                <h4>Travel Inspiration</h4>
                <p>Memberi gambaran untuk rencana perjalanan Anda.</p>
            </div>
        </div>
    </div>

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

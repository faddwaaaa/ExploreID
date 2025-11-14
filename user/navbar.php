<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 60px;
    border-bottom: 1px solid #00000030;
    font-family: 'Inter', sans-serif;
    background-color: white;
">

    <!-- Kiri: Logo -->
    <div style="flex: 1; font-weight: 700; font-size: 20px; font-family: 'Abril Fatface'; text-align: left; padding-left: 5px;">
        ExploreID
    </div>

    <!-- Tengah: Menu Navigasi -->
    <ul style="
        flex: 1;
        display: flex;
        justify-content: center;
        gap: 33px;
        list-style: none;
        margin: 0;
        padding: 0;
    ">
        <li>
            <a href="index.php" 
               style="text-decoration: none; color: <?= ($current_page == 'index.php') ? '#134BC3' : '#000' ?>; font-weight: 500; transition: color 0.3s;"
               onmouseover="this.style.color='#134BC3'" 
               onmouseout="this.style.color='<?= ($current_page == 'index.php') ? '#134BC3' : '#000' ?>'">
               Home
            </a>
        </li>
        <li>
            <a href="about.php" 
               style="text-decoration: none; color: <?= ($current_page == 'about.php') ? '#134BC3' : '#000' ?>; transition: color 0.3s;"
               onmouseover="this.style.color='#134BC3'" 
               onmouseout="this.style.color='<?= ($current_page == 'about.php') ? '#134BC3' : '#000' ?>'">
               About
            </a>
        </li>
        <li>
            <a href="destination.php" 
               style="text-decoration: none; color: <?= ($current_page == 'destination.php') ? '#134BC3' : '#000' ?>; transition: color 0.3s;"
               onmouseover="this.style.color='#134BC3'" 
               onmouseout="this.style.color='<?= ($current_page == 'destination.php') ? '#134BC3' : '#000' ?>'">
               Destination
            </a>
        </li>
    </ul>

    <!-- Kanan: Ikon Favorit & User -->
    <div style="flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 15px; position: relative; padding-right: 120px;">
        <a href="favorit.php">
            <i class="fa-regular fa-heart" 
               style="font-size: 18px; color:#000; transition: color 0.3s;" 
               onmouseover="this.style.color='#134BC3'" 
               onmouseout="this.style.color='#000'"></i>
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-menu" style="position: relative;">
                <i class="fa-regular fa-user" 
                   id="userIcon"
                   style="font-size: 18px; color:#000; cursor:pointer; transition: color 0.3s;"
                   onmouseover="this.style.color='#134BC3'" 
                   onmouseout="this.style.color='#000'"></i>

                <div id="dropdownMenu" 
                     style="display:none; position:absolute; top:35px; right:0; background:white; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.15); padding:10px 0; width:160px; text-align:left; z-index:999;">
                    <a href="profile.php" 
                       style="display:block; padding:8px 15px; text-decoration:none; color:#000; font-size:14px;"
                       onmouseover="this.style.background='#f0f0f0'" 
                       onmouseout="this.style.background='transparent'">
                       Edit Profil
                    </a>
                    <a href="logout.php" 
                       style="display:block; padding:8px 15px; text-decoration:none; color:#c00; font-size:14px;"
                       onmouseover="this.style.background='#f0f0f0'" 
                       onmouseout="this.style.background='transparent'">
                       Logout
                    </a>
                </div>
            </div>

            <script>
                const userIcon = document.getElementById('userIcon');
                const dropdown = document.getElementById('dropdownMenu');

                userIcon.addEventListener('click', () => {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });

                window.addEventListener('click', (e) => {
                    if (!e.target.closest('.user-menu')) {
                        dropdown.style.display = 'none';
                    }
                });
            </script>

        <?php else: ?>
            <a href="login.php" style="text-decoration: none; background:#134BC3; color:white; padding:8px 16px; border-radius:20px; font-size:14px; transition: background 0.3s;" 
               onmouseover="this.style.background='#0d3a94'" 
               onmouseout="this.style.background='#134BC3'">
               Login
            </a>
        <?php endif; ?>
    </div>
</nav>

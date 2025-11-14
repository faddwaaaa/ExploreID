<?php
include "../koneksi.php";
session_start();

$wisata_id = $_POST['wisata_id'];
$komentar = $_POST['komentar'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

// admin tidak komentar dari sini, hanya user
$admin_id = NULL;

if ($komentar == "") {
    echo "<script>alert('Komentar tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO komentar (wisata_id, user_id, admin_id, komentar, timestamp)
        VALUES ('$wisata_id', '$user_id', NULL, '$komentar', NOW())";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: detail.php?id=$wisata_id&komen=sukses");
} else {
    echo "Gagal menyimpan komentar";
}
?>

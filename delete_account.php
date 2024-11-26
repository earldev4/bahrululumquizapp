<?php
session_start();
include 'includes/db.php';

if (isset($_GET['user_nis'])) {
    $user_nis = $_GET['user_nis'];

    // Gunakan prepared statement MySQLi untuk menghapus data
    $stmt = $db->prepare("DELETE FROM akun_users WHERE user_nis = ?");
    $stmt->bind_param("s", $user_nis);
    $stmt->execute();

    // Redirect ke admin_dashboard.php setelah berhasil menghapus
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "NIS tidak disertakan!";
    exit();
}
?>
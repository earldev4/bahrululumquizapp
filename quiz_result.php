<!-- AGAMA ISLAM 02-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahrul Ulum Quiz App - Kuis Agama Islam 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/quiz_style.css">
    <style>
        @media only screen and (max-width: 768px) {
            .w-50{
                width: 100% !important;
            }
        }
    </style>
</head>
<?php
    session_start();
    if (isset($_SESSION["is_login"]) == false) {
        header("location: login.php");
        exit();
    }
    include 'includes/functions.php';

    $result_quiz = get_data_quiz($_GET['id_quiz'])
?>
<body>
    <header>
        <div class="header-bar header">
            <img src="assets/image/img-icon.png" alt="" class="img-fluid  rounded-circle">
            <h4 class="text">Bahrul Ulum Quiz App - <?= $result_quiz['title'] ?></h4>
        </div>
    </header>
    <div class="container p-4 w-50" style="min-height: 60vh; margin-top: 100px;" id="resultContainer">
        <div class="checkIcon fw-bold bg-aqua text-exercise">✓</div>
        <div class="row p-md-5 p-2 pt-5">
            <h1 class="text-center fw-bold pb-4 text-exercise">SKOR LATIHAN</h1>
            <h1 class="fw-bold text-center w-auto mx-auto py-2 px-3 text-white bg-aqua" id="scoreResult"><?= substr($_SESSION['score'], 0, 5) ?></h1>
            <p class="text-center fs-6 pt-5" id="message">
                <?php 
                    if ($_SESSION['score'] >= 80) {
                        echo "Selamat atas nilai latihan yang bagus! Usaha dan kerja keras kamu benar-benar terlihat dari hasilnya.
                            Terus pertahankan semangat ini, ya! Semoga pencapaian ini jadi motivasi buat latihan-latihan berikutnya.
                            Tetap semangat dan sukses selalu!";
                    }elseif ($_SESSION['score'] >= 60) {
                        echo "Bagus sekali! Nilai Anda sudah cukup memuaskan dan menunjukkan bahwa Anda sudah memahami materi dengan baik. Namun, masih ada ruang untuk peningkatan. Teruslah belajar dan asah kemampuan Anda lebih jauh untuk mencapai hasil yang lebih tinggi lagi!";
                    }elseif ($_SESSION['score'] >= 40) {
                        echo "Anda sudah mendapatkan hasil yang cukup memadai. Ini adalah awal yang baik, tetapi ada beberapa area yang perlu diperbaiki. Jangan berhenti di sini! Dengan usaha ekstra, Anda pasti bisa meningkatkan pemahaman dan mencapai nilai yang lebih tinggi. Semangat terus dalam belajar!";
                    }elseif ($_SESSION['score'] > 0 ) {
                        echo "Hasil Anda saat ini masih di bawah standar, namun ini bukan akhir. Jangan berkecil hati! Setiap langkah yang diambil adalah bagian dari proses belajar. Luangkan waktu untuk merevisi materi dan coba lagi dengan semangat baru. Anda pasti bisa mencapai hasil yang lebih baik!";
                    }else{
                        echo "Anda mendapatkan nilai 0 kali ini. Jangan merasa putus asa, ini adalah kesempatan untuk memulai dari awal. Pelajari kembali materinya, coba pahami kesalahan yang mungkin terjadi, dan lakukan yang terbaik di kesempatan berikutnya. Kegagalan adalah bagian dari keberhasilan jika Anda terus berusaha!";
                    }
                ?>
            </p>
        </div>
        <a class="backButton px-3 py-2 fw-bold bg-aqua text-white" href="dashboard.php">KEMBALI</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>

<?php
session_start();
if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}

include 'includes/db.php';
include 'includes/functions.php';

if (isset($_GET['subject_id']) && is_numeric($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    // Ambil nama subjek untuk ditampilkan di halaman
    $subject_query = "SELECT subject_name FROM subject WHERE subject_id=$subject_id";
    $subject_result = $db->query($subject_query);
    $subject_name = $subject_result->num_rows > 0 ? $subject_result->fetch_assoc()['subject_name'] : 'Unknown Subject';

    // Ambil daftar soal berdasarkan subject_id
    $sql = "SELECT * FROM quiz WHERE subject_id = $subject_id AND status='publish'";
    $result = $db->query($sql);
} else {
    die("Invalid subject ID.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/quizzes_style.css">
</head>
<body>
    <div class="title"><?= htmlspecialchars($subject_name) ?></div>
    <div class="line"></div>
    <a href="dashboard.php" class="button-mulai w-25 my-1">Kembali</a>
    <div class="container">
        <ul class="exercise-list">
            <?php
            if ($result->num_rows > 0) {
                while ($quiz = $result->fetch_assoc()) { ?>
                    <li class='exercise-item'>
                        <div class='exercise-name'><?= $quiz['title']?></div>
                        <div class='date d-flex'><?= $quiz['created_at'] ?></div>
                        <?php if(quiz_status($_SESSION["user_nis"] , $quiz["id_quiz"]) < 1){?>
                            <div class='link'><a href='quiz.php?id_quiz=<?= $quiz['id_quiz'] ?>' class='btn btn-outline-primary'>Kerjakan</a></div>
                        <?php }else{ ?>
                            <div class="btn btn-sm btn-success">Selesai</div>
                        <?php } ?>
                    </li>
            <?php }
            } else {
                echo "<li class='text-center'>Belum ada soal untuk subjek ini.</li>";
            }
            ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
</body>
</html>

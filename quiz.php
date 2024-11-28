<?php
session_start();
if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}

include 'includes/db.php';
include 'includes/functions.php';

$id_quiz = isset($_GET['id_quiz']) ? $_GET['id_quiz'] : '';
$count_question = count_question_quiz($id_quiz);

if (quiz_status($_SESSION["user_nis"], $id_quiz) > 0) {
    header("location: dashboard.php");
}


if (isset($_POST['answer'])) {

    $answer = $_POST['answer'];
    $question_id = $_POST['id_question'];
    $point = $_POST['point'];
    $id_quiz = $_POST['id_quiz'];


    $stmt = $db->prepare("SELECT options FROM questions WHERE id_question=?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result_answer = $result->fetch_assoc();

    $correct_answer = json_decode($result_answer['options'], true);

    $question = get_question_for_quiz($id_quiz);
    $question_index = $_SESSION['question_index']++;

    if ($answer == $correct_answer['answer']) {
        $_SESSION['score'] += $point;
        $status = 'true';
    } else {
        $status = 'false';
    }

    if (isset($question[$_SESSION['question_index']])) {
        $current_question = $question[$_SESSION['question_index']];
    } else {
        if (quiz_status($_SESSION["user_nis"], $id_quiz) > 0) {
            header("location: dashboard.php");
        }else{
            $completed_at = date("Y-m-d H:i:s");
            $score_user = $db->prepare("INSERT INTO quiz_score (user_nis, id_quiz, score, completed_at) VALUES (?, ?, ?, ?)");
            $score_user->bind_param("siis", $_SESSION['user_nis'], $id_quiz, $_SESSION['score'], $completed_at);
            $score_user->execute();
    
            echo json_encode(['redirect' => 'quiz_result.php?id_quiz=' . $id_quiz . '','score'=> $_SESSION['score'], 'status' => $status]);
            exit();
        }
    }

    $response = [
        'status' => $status,
        'score' => $_SESSION['score'],
        'number' => intval($question_index) + 1,
        'gambar' => isset($current_question['image_soal']) ? $current_question['image_soal'] : '',
        'id_question' => $current_question['id_question'],
        'question_text' => $current_question['question_text'],
        'options' => $current_question['options'],
        'redirect' => ''
    ];

    echo json_encode($response);
    exit();
}

function end_quiz($db, $id_quiz)
{

    if (quiz_status($_SESSION["user_nis"], $id_quiz) > 0) {
        header("location: dashboard.php");
    }else{
        $completed_at = date("Y-m-d H:i:s");
        $score_user = $db->prepare("INSERT INTO quiz_score (user_nis, id_quiz, score, completed_at) VALUES (?, ?, ?, ?)");
        $score_user->bind_param("siis", $_SESSION['user_nis'], $id_quiz, $_SESSION['score'], $completed_at);
        $score_user->execute();
    }

    echo json_encode(['redirect' => 'quiz_result.php?id_quiz=' . $id_quiz . '']);
    exit();
}

if (isset($_POST['time_up'])) {
    $id_quiz = $_POST['id_quiz'];
    end_quiz($db, $id_quiz);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahrul Ulum Quiz App - Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/quiz_style.css">
</head>

<?php
$point = $count_question > 0 ? 100 / $count_question : 0;

$data_quiz = get_data_quiz($id_quiz);
$question = get_question_for_quiz($id_quiz);
$subject = get_single_subject($data_quiz['subject_id']);

if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
}

if (isset($question[$_SESSION['question_index']])) {
    $current_question = $question[$_SESSION['question_index']];
} else {
    if (quiz_status($_SESSION["user_nis"], $id_quiz) > 0) {
        header("location: dashboard.php");
    }else{
        $completed_at = date("Y-m-d H:i:s");
        $score_user = $db->prepare("INSERT INTO quiz_score (user_nis, id_quiz, score, completed_at) VALUES (?, ?, ?, ?)");
        $score_user->bind_param("siis", $_SESSION['user_nis'], $id_quiz, $_SESSION['score'], $completed_at);
        $score_user->execute();
    
        header('location: quiz_result.php?id_quiz=' . $id_quiz . '');
        exit();
    }
}
?>

<body>
    <header>
        <div class="header-bar header">
            <img src="assets/image/img-icon.png" alt="" class="img-fluid rounded-circle">
            <h4 class="text">Bahrul Ulum Quiz App - <?= $data_quiz['title'] ?></h4>
        </div>
    </header>

    <div class="container mt-3 p-4">
        <div class="row">
            <div class="numberBox col-md-1 border border-dark pt-3 text-center fw-">
                <p><span id="number"><?= $_SESSION['question_index'] + 1 ?></span>/<?= $count_question ?></p>
            </div>
            <div class="questionBox col-md-9 pt-md-0 py-3 px-5">
                <div class="fw-bold mb-3">Baca Soal Dengan Seksama</div>
                <div class="image_box">
                    <?php if ($current_question['image_soal'] != null) { ?>
                        <img src="assets/image_soal/<?= $current_question['image_soal'] ?>" alt="image_soal"
                            class="image_soal img-fluid border border-dark p-0 mb-3">
                    <?php } ?>
                </div>
                <div id="question" class="lh-base"><?= $current_question['question_text'] ?></div>
                <div class="choice">
                    <?php foreach ($current_question['options']['options'] as $key_opt => $value_opt) { ?>
                        <div class="choiceContainer my-3 d-flex border border-dark p-3"
                            data-question="<?= $current_question['id_question'] ?>" data-quiz="<?= $id_quiz ?>"
                            data-point="<?= $point ?>">
                            <div class="choicePrefix"><?= $key_opt ?></div>
                            <div class="choiceText mx-3 w-100 d-flex align-items-center"><?= $value_opt ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="progressBox col-md-2">
                <div class="timeBar p-3 border border-dark fs-6 mb-3">Waktu <span
                    id="timeBar"><?= $data_quiz['quiz_time'] ?></span></div>
                <div class="scoreBar p-3 border border-dark fs-6 mb-3">Nilai <span
                    id="scoreBar"><?= substr($_SESSION['score'], 0, 5) ?></span>
                </div>
                <audio controls loop autoplay style="width: 100%; transform: scale(0.9);" class="pt-3">
                    <source src="assets/music/<?= $subject['music'] ?>">
                </audio>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        function startTimer() {
            // Ambil waktu yang tersisa dari localStorage (atau 1 jam = 3600 detik jika tidak ada)
            var timeLeft = localStorage.getItem("timeLeft") ? parseInt(localStorage.getItem("timeLeft")) : $('#timeBar').text();

            // Fungsi untuk mengubah detik menjadi format HH:MM:SS
            function formatTime(seconds) {
                var hours = Math.floor(seconds / 3600); // Menghitung jam
                var minutes = Math.floor((seconds % 3600) / 60); // Menghitung menit
                var remainingSeconds = seconds % 60; // Menghitung detik yang tersisa
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0') + ':' +
                    remainingSeconds.toString().padStart(2, '0');
            }

            // Tampilkan langsung waktu yang tersisa dalam format HH:MM:SS
            $("#timeBar").text(formatTime(timeLeft));

            // Fungsi untuk menampilkan waktu mundur
            var countdown = setInterval(function () {
                // Kurangi 1 detik
                timeLeft--;

                // Tampilkan waktu yang baru dalam format HH:MM:SS
                $("#timeBar").text(formatTime(timeLeft));

                // Simpan waktu yang tersisa di localStorage
                localStorage.setItem("timeLeft", timeLeft);

                // Jika waktu habis, tampilkan pesan
                if (timeLeft <= 0) {
                    clearInterval(countdown); // Hentikan countdown
                    $("#timeBar").text(" habis!"); // Tampilkan pesan "Waktu habis!"
                    localStorage.removeItem("timeLeft"); // Menghapus waktu ketika selesai
                    $.ajax({
                        url: 'quiz.php',  // URL tempat Anda ingin memproses data (quiz.php)
                        type: 'POST',
                        data: {
                            time_up: true,
                            id_quiz: <?= $id_quiz ?>  // Kirimkan status bahwa waktu telah habis
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.redirect != '') {
                                location.href = response.redirect;
                            }
                        }
                    });
                }
            }, 1000); // Update setiap detik
        }


        $(document).ready(function () {
            startTimer();

            $('.choice').on('click','.choiceContainer', function(){
                let choice = $(this);
                let answer_user = choice.find('.choicePrefix').text();
                let id_question = choice.data('question');
                let id_quiz = choice.data('quiz');
                let point = choice.data('point');

                $.ajax({
                    type: 'POST',
                    url: 'quiz.php',
                    data: {
                        answer: answer_user,
                        id_question: id_question,
                        point: point,
                        id_quiz: id_quiz
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == 'true') {
                            choice.addClass('bg-success');
                        } else {
                            choice.addClass('bg-danger');
                        }

                        setTimeout(function () {

                            if (response.redirect != '') {
                                $('#scoreBar').text(parseFloat(response.score.toFixed(2)));
                                setTimeout(function(){
                                    location.href = response.redirect;
                                },400);

                            }else{
                                $('#question').empty().append(response.question_text);
                                $('#scoreBar').text(parseFloat(response.score.toFixed(2)));
                                $('#number').text(response.number + 1);
                                if(response.gambar != ''){
                                    $('.image_box').empty().append('<img src="assets/image_soal/'+ response.gambar +'" alt="image_soal" class="image_soal img-fluid border border-dark p-0 mb-3">');
                                }else{
                                    $('.image_box').empty();
                                }

                                $('.choice').empty();

                                let options = response.options.options;

                                Object.entries(options).forEach(function([key, value]) {
                                    $('.choice')
                                    .append('<div class="choiceContainer my-3 d-flex border border-dark p-3" data-question="'+ response.id_question +'" data-quiz="<?= $id_quiz ?>" data-point="<?= $point ?>"><div class="choicePrefix">'+ key +'</div><div class="choiceText mx-3 w-100 d-flex align-items-center">'+ value +'</div></div>');
                                });
                            }
                        }, 600);

                    }
                });
            });
        });
    </script>
</body>

</html>
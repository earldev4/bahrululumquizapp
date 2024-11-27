<?php
    session_start();
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location: index.php");
    }
    include 'includes/functions.php';
    $profile = profile_user($_SESSION["user_nis"]);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
    <?php
        if (isset($_SESSION["is_login"]) == false) {
            header("location: login.php");
            exit();
        }
        if (isset($_SESSION["score"]) && isset($_SESSION["question_index"])) {
            unset($_SESSION["score"], $_SESSION["question_index"]);
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 text-center border-end">
                <img src="./assets/image/img-icon.png" alt="Logo" class="img-fluid rounded-circle mt-3"
                    style="width: 150px;">
                <h4 class="mt-3"><?= $profile["username"]?></h4>
                <?php if($profile["role"] == "admin"){?>
                    <a href="view_account.php" class="button-mulai mt-3">Data Murid</a>
                    <a href="add_users.php" class="button-mulai mt-3">Buat Data Murid</a>
                    <a href="data_subjects.php" class="button-mulai mt-3">Data Subject</a>
                <?php } ?>
                <a href="history_quiz.php" class="button-mulai mt-3">Riwayat</a>
                <form action="dashboard.php" method="POST">
                    <button type="submit" name="logout" class="button-mulai bg-danger mt-3">Logout</button>
                </form>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 p-3">
                <div class="row g-4">
                    <?php
                    $data_subject = get_all_data_subject();

                    if ($data_subject != []) {
                        foreach ($data_subject as $subject) { ?>
                            <div class='col-md-6 col-lg-4'>
                                <div class='card subject-card'>
                                    <div class='card-body'>
                                        <h5 class='card-title text-center'><?= $subject['subject_name'] ?></h5>
                                        <img src='assets/image/<?= $subject['thumbnail']?>' alt='' class='img-fluid rounded'>
                                        <p class='card-text text-center pt-3'>Jelajahi dunia terkait <?= $subject['subject_desc'] ?>! Temukan keajaiban dalam topik ini.</p>
                                        <div class='text-center'>
                                            <a href='quizzes.php?subject_id=<?= $subject['subject_id']?>' class='btn btn-primary start-btn w-100'>MULAI</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } 
                    } else {
                        echo "<li>No subjects available</li>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            localStorage.removeItem("timeLeft");
        });
    </script>
</body>
</html>

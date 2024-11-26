<?php
    session_start();
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location: index.php");
    }
    include 'includes/db.php';
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 text-center border-end">
                <img src="./assets/image/img-icon.png" alt="Logo" class="img-fluid rounded-circle mt-3"
                    style="width: 150px;">
                <h4 class="mt-3"><?= $_SESSION["username"]?></h4>
                <a href="view_account.php" class="button-mulai mt-3">Lihat Data Murid</a>
                <a href="add_users.php" class="button-mulai mt-3">Buat Data Murid</a>
                <a href="add_question.php" class="button-mulai mt-3">Buat Soal</a>
                <form action="users_dashboard.php" method="POST">
                    <button type="submit" name="logout" class="button-mulai bg-danger mt-3">Logout</button>
                </form>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 p-3">
                <div class="row g-4">
                    <?php
                    $sql = "SELECT * FROM subject";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($subject = $result->fetch_assoc()) {
                            echo "
                            <div class='col-md-4'>
                                <div class='card subject-card'>
                                    <div class='card-body'>
                                        <h5 class='card-title text-center'>{$subject['subject_name']}</h5>
                                        <img src='./assets/image/{$subject['subject_name']}.png' alt='' class='img-fluid'>
                                        <p class='card-text text-center'>Jelajahi dunia terkait {$subject['subject_desc']}! Temukan keajaiban dalam topik ini.</p>
                                        <div class='text-center'>
                                            <a href='quizzes.php?subject_id={$subject['subject_id']}' class='btn btn-primary start-btn w-100'>MULAI</a>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<li>No subjects available</li>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
</body>
</html>

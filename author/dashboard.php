<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
    $author_id =1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        :root {
            --hijau: #379777;
            --hijau_gelap: #31876b;
            --kuning: #f4ce14;
            --kuning_gelap: #e2be0a;
            --hitam: #45474b;
            --putih: #f5f7f8;
            --putih_gelap: #d8dfe3;
            --merah: #ee4e4e;
        }

        * {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
        }

        .dashboard {
            width: 83%;
        }

        .title_ikhtisar {
            margin: 20px 0 0 20px;
            color: var(--hitam);
        }

        .box_container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
            gap: 1.5rem;
            justify-content: center;
            align-items: start;
            margin: 30px 20px;
        }

        .box {
            padding: 20px;
            min-width: 250px;
            background-color: var(--putih);
            box-sizing: border-box;
        }

        .jumlah_wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0 30px 0;
        }

        .jumlah_wrap i {
            color: var(--putih);
            -webkit-text-stroke: 2px #515357;
        }

        .wrap_btn {
            background-color: var(--putih_gelap);
            width: 100%;
            padding: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrap_btn:hover {
            background-color: var(--kuning);
            transition: 0.3s;
        }

        .lihat_btn {
            text-decoration: none;
            color: var(--hitam);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include '../components/sidebar_author.php' ?>

    <div class="dashboard">
        <h2 class="title_ikhtisar">Ikhtisar Dashboard</h2>
        <div class="box_container">
            <div class="box">
                <?php
                    $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE author_id = ?");
                    $select_posts->execute([$author_id]);
                    $numbers_of_posts = $select_posts->rowCount();
                ?>
                <p class="judul_card">Total Postingan</p>
                <div class="jumlah_wrap">
                    <h3><?= $numbers_of_posts; ?></h3>
                    <i class="fa-solid fa-file fa-xl"></i>
                </div>
                <div class="wrap_btn">
                    <a href="add_posts.php" class="lihat_btn">Tambah Postingan</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $select_active_posts = $conn->prepare("SELECT * FROM `posts` WHERE author_id = ? AND status = ?");
                    $select_active_posts->execute([$author_id, 'active']);
                    $numbers_of_active_posts = $select_active_posts->rowCount();
                ?>
                <p class="judul_card">Postingan Aktif</p>
                <div class="jumlah_wrap">
                    <h3><?= $numbers_of_active_posts; ?></h3>
                    <i class="fa-solid fa-file-circle-check fa-xl"></i>
                </div>
                <div class="wrap_btn">
                    <a href="list_of_post.php" class="lihat_btn">Lihat Postingan</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $select_deactive_posts = $conn->prepare("SELECT * FROM `posts` WHERE author_id = ? AND status = ?");
                    $select_deactive_posts->execute([$author_id, 'deactive']);
                    $numbers_of_deactive_posts = $select_deactive_posts->rowCount();
                ?>
                <p class="judul_card">Postingan Nonaktif</p>
                <div class="jumlah_wrap">
                    <h3><?= $numbers_of_deactive_posts; ?></h3>
                    <i class="fa-solid fa-file-circle-minus fa-xl"></i>
                </div>
                <div class="wrap_btn">
                    <a href="list_of_post.php" class="lihat_btn">Lihat Postingan</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE author_id = ?");
                    $select_comments->execute([$author_id]);
                    $select_comments->execute();
                    $numbers_of_comments = $select_comments->rowCount();
                ?>
                <p class="judul_card">Total Komentar</p>
                <div class="jumlah_wrap">
                    <h3><?= $numbers_of_comments; ?></h3>
                    <i class="fa-solid fa-message fa-xl"></i>
                </div>
                <div class="wrap_btn">
                    <a href="comments.php" class="lihat_btn">Lihat Komentar</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE author_id = ?");
                    $select_likes->execute([$author_id]);
                    $select_likes->execute();
                    $numbers_of_likes = $select_likes->rowCount();
                ?>
                <p class="judul_card">Total Likes</p>
                <div class="jumlah_wrap">
                    <h3><?= $numbers_of_likes; ?></h3>
                    <i class="fa-solid fa-thumbs-up fa-xl"></i>
                </div>
                <div class="wrap_btn">
                    <a href="list_of_post.php" class="lihat_btn">Lihat Likes</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
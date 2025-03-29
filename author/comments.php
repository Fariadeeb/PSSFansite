<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
}

if(isset($_POST['delete_comment'])){

    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comment->execute([$comment_id]);
    $message[] = 'Komentar berhasil dihapus!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar Slemania</title>
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
        section{
            width: 83%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .comments_section{
            background-color: var(--putih);
            width: 80%;
            padding: 40px;
            color: var(--hitam);
        }
        .comments_title{
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .box{
            margin: 0 0 25px 0;
        }
        .user_comment_profile{
            display: flex;
            align-items: center;
            column-gap: 15px;
        }
        .user_date{
            font-size: 12px;
            margin-top: 5px;
        }
        .user_comment{
            margin: 10px 0;
            background-color: var(--putih_gelap);
            padding: 12px;
        }
        .delete_comment_btn{
            padding: 10px;
            border: none;
            cursor: pointer;
            background-color: var(--merah);
            color: var(--putih);
        }
        .post_from{
            margin-bottom: 8px;
        }
        .post_title{
            font-weight: 600;
            text-decoration: none;
            color: var(--hitam);
        }
    </style> 
</head>
<body>
    <?php include '../components/sidebar_author.php' ?>

    <section>
        <div class="comments_section">
            <p class="comments_title">Komentar Postingan</p>
            <div class="comment_box">
                <?php
                    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE author_id = ?");
                    $select_comments->execute([$author_id]);
                    if($select_comments->rowCount() > 0){
                        while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
                ?>
                
                <div class="box">
                    <?php
                        $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
                        $select_posts->execute([$fetch_comments['post_id']]);
                        while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="post_from">
                        from: <a class="post_title" href="read_posts.php?post_id=<?= $fetch_posts['id']; ?>" >
                            <?= $fetch_posts['title']; ?>
                        </a>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="user_comment_profile">
                        <i class="fas fa-user"></i>
                        <div class="user-info">
                            <span class="user_uname"><?= $fetch_comments['user_name']; ?></span>
                            <div class="user_date"><?= $fetch_comments['date']; ?></div>
                        </div>
                    </div>
                    <div class="user_comment"><?= $fetch_comments['comment']; ?></div>
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?= $fetch_comments['id']; ?>">
                        <button type="submit" class="delete_comment_btn" name="delete_comment" onclick="return confirm('delete this comment?');">delete comment</button>
                    </form>
                </div>
                <?php
                        }
                    }else{
                        echo '<p>Belum ada komentar!</p>';
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
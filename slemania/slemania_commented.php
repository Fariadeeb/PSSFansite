<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
   header('location:home.php');
};

if(isset($_POST['edit_comment'])){
    $edit_comment_id = $_POST['edit_comment_id'];
    $edit_comment_id = filter_var($edit_comment_id, FILTER_SANITIZE_STRING);
    $edit_comment_box = $_POST['edit_comment_box'];
    $edit_comment_box = filter_var($edit_comment_box, FILTER_SANITIZE_STRING);
 
    $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ? ");
    $verify_edit_comment->execute([$edit_comment_id, $edit_comment_box]);
 
    if($verify_edit_comment->rowCount() > 0){
       $message[] = 'Komentar sudah ada sebelumnya!';
    }else{
       $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
       $update_comment->execute([$edit_comment_box, $edit_comment_id]);
       $message[] = 'Berhasil sunting komentar anda!';
    }
}

if(isset($_POST['delete_comment'])){
    $delete_comment_id = $_POST['comment_id'];
    $delete_comment_id = filter_var($delete_comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comment->execute([$delete_comment_id]);
    $message[] = 'Berhasil hapus komentar anda!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Komentar anda</title>
    <style>
        :root {
            --hijau: #379777;
            --hujau_gelap: #31876b;
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
        body{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        section{
            width: 80%;
            margin-inline: auto;
            margin-top: 30px;
            margin-bottom: 30px;
            color: var(--hitam);
            flex: 1;
        }
        footer{
            width: 80%;
            margin-inline: auto;
            display: flex;
            column-gap: 10px;
            background-color: var(--hijau);
            justify-content: center;
            padding: 10px 0;
            color: var(--putih);
            font-size: 14px;
        }
        .comment_title{
            /* margin-bottom: 10px; */
            font-size: 18px;
            color: var(--hitam);
            font-weight: 700;
        }
        .comments_container, .edit_comment_section{
            background-color: var(--putih);
            padding: 30px;
        }
        .comments_box{
            margin: 30px 0;
        }
        .slemania_comment_profile{
            display: flex;
            align-items: center;
            column-gap: 10px;
            margin: 8px 0 10px 0;
        }
        .post_from a{
            text-decoration: none;
            color: var(--hijau);
        }
        .slemania_date{
            font-size: 12px;
            margin-top: 3px;
        }
        .slemania_comment{
            margin-bottom: 10px;
            background-color: var(--putih_gelap);
            padding: 12px;
        }
        .edit_comment_btn, .delete_comment_btn{
            padding: 8px 10px;
            border: 0;
            cursor: pointer;
        }
        .edit_comment_btn{
            background-color: var(--kuning);
        }
        .delete_comment_btn{
            background-color: var(--merah);
        }
        .edit_comment_wrap{
            display: flex;
            column-gap: 5px;
        }
        .edit_comment_wrap textarea{
            flex: 1;
            resize: none;
            padding: 10px 0 0 12px;
            border: 0;
            background-color: var(--putih_gelap);
            outline: none;
            font-size: 14px;
            color: var(--hitam);
        }
        .edit_btn_wrap{
            display: flex;
            flex-direction: column;
            row-gap: 5px;
        }
        .edit_btn_wrap button{
            border: none;
            padding: 10px;
            font-size: 14px;
            background-color: var(--kuning);
        }
        .edit_btn_wrap div{
            text-decoration: none;
            color: var(--hitam);
            padding: 10px;
            font-size: 14px;
            background-color: var(--merah);
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                <div class="message" style="text-align: center; margin-top: 10px;">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <p style="font-size: 20px; font-weight: 700; color: var(--hitam); text-align: center; margin-top: 20px;">Postingan yang Dikometari</p>

    <?php
        if(isset($_POST['open_edit_box'])){
        $comment_id = $_POST['comment_id'];
        $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    ?>
    <section>
        <?php
            $select_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
            $select_edit_comment->execute([$comment_id]);
            $fetch_edit_comment = $select_edit_comment->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="edit_comment_section">
            <p class="comment_title" style="margin-bottom: 10px;">Sunting komentar anda</p>
            <form method="POST" class="edit_comment_wrap">
                <input type="hidden" name="edit_comment_id" value="<?= $fetch_edit_comment['id']; ?>">
                <textarea name="edit_comment_box" required placeholder="please enter your comment"><?= $fetch_edit_comment['comment']; ?></textarea>
                <div class="edit_btn_wrap">
                    <button type="submit" class="inline-btn" name="edit_comment">Sunting komentar</button>
                    <div class="inline-option-btn" onclick="window.location.href = 'slemania_commented.php';">cancel edit</div>
                </div>
            </form>
        </div>
    </section>
    <?php
        }
    ?>

    <section>
        <div class="comments_container">
            <p class="comment_title">Komentarmu pada postingan</p>
            <div class="slemania_comments_container">
                <?php
                    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE slemania_id = ?");
                    $select_comments->execute([$slemania_id]);
                    if($select_comments->rowCount() > 0){
                        while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="comments_box">
                    <?php
                        $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
                        $select_posts->execute([$fetch_comments['post_id']]);
                        while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="post_from"> 
                        Dari:<a href="read_post.php?post_id=<?= $fetch_posts['id']; ?>">
                            <?= $fetch_posts['title']; ?>
                        </a>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="slemania_comment_profile">
                        <i class="fas fa-user"></i>
                        <div class="slemania_info">
                            <span class="slemania_uname"><?= $fetch_comments['slemania_name']; ?></span>
                            <div class="slemania_date"><?= $fetch_comments['date']; ?></div>
                        </div>
                    </div>
                    <div class="slemania_comment"><?= $fetch_comments['comment']; ?></div>
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?= $fetch_comments['id']; ?>">
                        <button type="submit" class="edit_comment_btn" name="open_edit_box">Sunting komentar</button>
                        <button type="submit" class="delete_comment_btn" name="delete_comment" onclick="return confirm('delete this comment?');">Hapus komentar</button>
                    </form>
                </div>
                <?php
                    }
                    }else{
                        echo '<p style="margin-top: 10px;">Anda belum menulis komentar!</p>';
                    }
                ?>
            </div>
        </div>
    </section>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
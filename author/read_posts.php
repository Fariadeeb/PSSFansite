<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
}

if (!isset($_GET['post_id'])) {
    header('location:list_of_post.php');
} else {
    $get_id = $_GET['post_id'];
}

if(isset($_POST['delete'])){
    $delete_id = $_POST['post_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $select_image = $conn ->prepare("SELECT * FROM `posts` WHERE id = ?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
        unlink('../uploaded_img/'.$fetch_image['image']);
    }
    $delete_comments = $conn ->prepare("DELETE FROM `comments` WHERE post_id = ?");
    $delete_comments->execute([$delete_id]);
    $delete_likes = $conn ->prepare("DELETE FROM `likes` WHERE post_id = ?");
    $delete_likes->execute([$delete_id]);
    $delete_post = $conn ->prepare("DELETE FROM `posts` WHERE id = ?");
    $delete_post->execute([$delete_id]);
    $message[] = 'Postingan berhasil dihapus';
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
    <title>Detil Postingan</title>
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
        .read_post{
            margin: 20px;
        }
        .post_wrap, .comments_section{
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            padding: 30px;
            background-color: var(--putih);
            color: var(--hitam);
        }
        .comments_section{
            margin-top: 20px;
        }
        section{
            width: 83%;
            /* margin-left: 20%; */
        }
        img{
            width:100%
        }
        .status_kategori_wrap{
            display: flex;
            column-gap: 5px;
            margin-bottom: 10px;
        }
        .status, .category{
            padding: 5px;
            border: 1px solid black;
            font-size: 10px;
        }
        .title{
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .posts_content{
            margin: 20px 0;
            line-height: 1.4;
            text-align: justify;
        }
        .icons{
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 10px;
            border: 2px solid var(--putih_gelap);
        }
        .likes i{
            color: var(--putih_gelap);
        }
        .comments i{
            color: var(--putih_gelap);
        }
        .btn_wrap{
            display: flex;
            column-gap: 5px;
            margin-top: 10px;
        }
        .edit_btn, .delete_btn{
            border-style: none;
            padding: 10px;
            flex-grow: 1;
            font-size: 14px;
            text-align: center;text-decoration: none;
            color: var(--putih);
            cursor: pointer;
        }
        .edit_btn{
            background-color: var(--kuning);
        }
        .delete_btn{
            background-color: var(--merah);
        }
        .comments_title{
            font-size: 20px;
            font-weight: 700;
        }
        .box{
            margin: 20px 0;
        }
        .user_comment_profile{
            display: flex;
            align-items: center;
        }
        .user_comment_profile i{
            margin-right: 15px;
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
    </style> 
</head>
<body>
    <?php include '../components/sidebar_author.php' ?>

    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>
    <section class="read_post">
        <?php
            $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ? AND author_id = ?");
            $select_posts->execute([$get_id, $author_id]);
            if($select_posts->rowCount() > 0){
            while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                $post_id = $fetch_posts['id'];

                $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $count_post_comments->execute([$post_id]);
                $total_post_comments = $count_post_comments->rowCount();

                $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                $count_post_likes->execute([$post_id]);
                $total_post_likes = $count_post_likes->rowCount();
            
        ?>
        <form action="" method="post" class="post_wrap">
            
            <div class="status_kategori_wrap">
                <div class="status" style="background-color:<?php if($fetch_posts['status'] == 'active'){echo '#379777'; }else{echo '#e2be0a';}; ?>;"><?= $fetch_posts['status']; ?></div>
                <div class="category"><?= $fetch_posts['category']; ?></div>
            </div>
            <div class="title"><?= $fetch_posts['title']; ?></div>
                <?php 
                    if($fetch_posts['image'] != ''){ ?>
                        <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
                <?php } ?>
            <div class="posts_content"><?= $fetch_posts['content']; ?></div>
            <div class="icons">
                <div class="likes"><i class="fas fa-heart"></i><span> <?= $total_post_likes; ?></span></div>
                <div class="comments"><i class="fas fa-comment"></i><span> <?= $total_post_comments; ?></span></div>
            </div>
            <div class="btn_wrap">
                <a href="edit_posts.php?post_id=<?= $post_id; ?>" class="edit_btn">Perbarui Postingan</a>
                <button type="submit" name="delete" class="delete_btn" onclick="return confirm('delete this post?');">Hapus Postingan</button>
            </div>
        </form>
        <?php
                }
            }else{
                echo '<p>Belum ada postingan!';
            }
        ?>
        <div class="comments_section">
            <p class="comments_title">Komentar Postingan</p>
            <div class="comment_box">
                <?php
                    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                    $select_comments->execute([$get_id]);
                    if($select_comments->rowCount() > 0){
                        while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){

                ?>
                <div class="box">
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
                        <button type="submit" class="delete_comment_btn" name="delete_comment" onclick="return confirm('Hapus komentar tersebut?');">Hapus Komentar</button>
                    </form>
                </div>
                <?php
                        }
                    }else{
                        echo '<p style="margin-top: 10px;">Belum ada komentar!</p>';
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
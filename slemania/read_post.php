<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
};

$get_id = $_GET['post_id'];

include '../components/post_likes.php';

if(isset($_POST['add_comment'])){

    $author_id = $_POST['author_id'];
    $author_id = filter_var($author_id, FILTER_SANITIZE_STRING);
    $slemania_name = $_POST['slemania_name'];
    $slemania_name = filter_var($slemania_name, FILTER_SANITIZE_STRING);
    $comment = $_POST['comment'];
    $comment = filter_var($comment, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ? AND author_id = ? AND slemania_id = ? AND slemania_name = ? AND comment = ?");
    $verify_comment->execute([$get_id, $author_id, $slemania_id, $slemania_name, $comment]);

    if($verify_comment->rowCount() > 0){
        $message[] = 'komentar sudah ada sebelumnya!';
    }else{
        $insert_comment = $conn->prepare("INSERT INTO `comments`(post_id, author_id, slemania_id, slemania_name, comment) VALUES(?,?,?,?,?)");
        $insert_comment->execute([$get_id, $author_id, $slemania_id, $slemania_name, $comment]);
        $message[] = 'komentar berhasil ditambahkan!';
    }
}

if(isset($_POST['edit_comment'])){
    $edit_comment_id = $_POST['edit_comment_id'];
    $edit_comment_id = filter_var($edit_comment_id, FILTER_SANITIZE_STRING);
    $edit_comment_box = $_POST['edit_comment_box'];
    $edit_comment_box = filter_var($edit_comment_box, FILTER_SANITIZE_STRING);
 
    $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ? ");
    $verify_edit_comment->execute([$edit_comment_id, $edit_comment_box]);
 
    if($verify_edit_comment->rowCount() > 0){
       $message[] = 'komentar sudah ada sebelumnya!';
    }else{
       $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
       $update_comment->execute([$edit_comment_box, $edit_comment_id]);
       $message[] = 'komentar berhasil disunting!';
    }
}

if(isset($_POST['delete_comment'])){
    $delete_comment_id = $_POST['comment_id'];
    $delete_comment_id = filter_var($delete_comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comment->execute([$delete_comment_id]);
    $message[] = 'komentar berhasil dihapus!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Detil postingan</title>
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
        section{
            width: 80%;
            margin-inline: auto;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .post_wrap{
            padding: 30px;
            background-color: var(--putih);
            color: var(--hitam);
        }
        img{
            width:100%;
            height:500px;
            object-fit: cover;
        }
        .status_kategori_wrap{
            display: flex;
            column-gap: 5px;
            margin-bottom: 10px;
        }
        .status, .category{
            padding: 5px;
            border: 1px solid black;
            font-size: 12px;
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
        .post_icons{
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 10px;
            border: 2px solid var(--putih_gelap);
        }
        .post_icons button{
            background-color: Transparent;
            background-repeat:no-repeat;
            border: none;
            cursor: pointer;
            color: var(--hitam);
            font-size: 16px;
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
        .slemania_comment_profile{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .slemania_comment_profile i{
            margin-right: 10px;
        }
        .slemania_date{
            font-size: 12px;
            margin-top: 3px;
        }
        /* .delete_comment_btn{
            padding: 10px;
            border: none;
            cursor: pointer;
            background-color: var(--merah);
            color: var(--putih);
        } */
        .regis_login{
            display: flex;
            column-gap: 8px;
            margin-top: 10px;
           /* justify-content: center; */
        }
        .regis_login a{
            padding: 8px 15px;
            font-size: 14px;
            text-decoration: none;
            background-color: var(--kuning);
            color: var(--hitam);
        }
        .add_comment_section, .slemania_comments_section, .edit_comment_section{
            padding: 30px;
            background-color: var(--putih);
        }
        .comment_title{
            margin-bottom: 10px;
            font-size: 18px;
            color: var(--hitam);
            font-weight: 700;
        }
        .add_comment_wrap, .edit_comment_wrap{
            display: flex;
            column-gap: 5px;
        }
        .add_comment_wrap textarea, .edit_comment_wrap textarea{
            flex: 1;
            resize: none;
            padding: 10px 0 0 12px;
            border: 0;
            background-color: var(--putih_gelap);
            outline: none;
            font-size: 14px;
            color: var(--hitam);
        }
        .add_comment_wrap .comment_btn{
            padding: 10px;
            border: 0;
            background-color: var(--hijau);
            color: var(--putih);
            cursor: pointer;
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
            color: var(--hitam);
        }
        .edit_btn_wrap a{
            text-decoration: none;
            color: var(--hitam);
            padding: 10px;
            font-size: 14px;
            background-color: var(--merah);
            text-align: center;
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
            color: var(--hitam);
            font-size: 14px;
        }
        .edit_comment_btn{
            background-color: var(--kuning);
        }
        .delete_comment_btn{
            background-color: var(--merah);
        }
        .comment_box{
            margin: 25px 0;
            color: var(--hitam);
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

    <?php
        if(isset($_POST['open_edit_box'])){
            $comment_id = $_POST['comment_id'];
            $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    ?>
    <!-- SUNTING KOMENTAR -->
    <section>
        <?php
            $select_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
            $select_edit_comment->execute([$comment_id]);
            $fetch_edit_comment = $select_edit_comment->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="edit_comment_section">
            <p class="comment_title">Sunting komentar anda</p>
            <form method="POST" class="edit_comment_wrap">
                <input type="hidden" name="edit_comment_id" value="<?= $fetch_edit_comment['id']; ?>">
                <textarea name="edit_comment_box" required placeholder="please enter your comment"><?= $fetch_edit_comment['comment']; ?></textarea>
                <div class="edit_btn_wrap">
                    <button type="submit" class="inline-btn" name="edit_comment">Sunting komentar</button>
                    <a href="read_post.php?post_id=<?= $get_id; ?>">Batal sunting</a>
                </div>
                
            </form>
        </div>
    </section>
    <?php
        }
    ?>

    <section>
        <?php
            $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? AND id = ?");
            $select_posts->execute(['active', $get_id]);
            if($select_posts->rowCount() > 0){
                while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                
                $post_id = $fetch_posts['id'];

                $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $count_post_comments->execute([$post_id]);
                $total_post_comments = $count_post_comments->rowCount(); 

                $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                $count_post_likes->execute([$post_id]);
                $total_post_likes = $count_post_likes->rowCount();

                $confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE slemania_id = ? AND post_id = ?");
                $confirm_likes->execute([$slemania_id, $post_id]);
        ?>
        <form action="" method="post" class="post_wrap">
            <input type="hidden" name="post_id" value="<?= $post_id; ?>">
            <input type="hidden" name="author_id" value="<?= $fetch_posts['author_id']; ?>">
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
            <div class="post_icons">
                <div class="comments">
                    <i class="fas fa-comment"></i>
                    <span> <?= $total_post_comments; ?></span>
                </div>
                <button class="likes" type="submit" name="post_likes">
                    <i class="fas fa-heart" style="<?php if($confirm_likes->rowCount() > 0){ echo 'color:#ee4e4e;'; } ?>  "></i>
                    <span> <?= $total_post_likes; ?></span>
                </button>
            </div>
        </form>
        <?php
                }
            }else{
                echo '<p>postingan tidak ditemukan!';
            }
        ?>
    </section>

    <section>
        
        <?php
            if($slemania_id != ''){  
                $select_author_id = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
                $select_author_id->execute([$get_id]);
                $select_profile = $conn->prepare("SELECT * FROM `slemania` WHERE id = ?");
                $select_profile->execute([$slemania_id]);
                $fetch_author_id = $select_author_id->fetch(PDO::FETCH_ASSOC);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="add_comment_section">
            <p class="comment_title">Tambahkan Komentar</p>
            <form method="post" class="add_comment_wrap">
                <input type="hidden" name="author_id" value="<?= $fetch_author_id['author_id']; ?>">
                <input type="hidden" name="slemania_name" value="<?= $fetch_profile['name']; ?>">
                <i class="fas fa-user" style="align-self: center; margin-right: 8px; color:var(--hitam);"></i>
                <textarea name="comment" maxlength="1000" class="comment-box"  placeholder="tuliskan komentar anda" required></textarea>
                <input type="submit" value="Tambahkan komentar" class="comment_btn" name="add_comment">
            </form>
        <?php
            }else{
        ?>
            <div class="add_comment_login">
                <p>please login to add or edit your comment</p>
                <!-- <a href="login.php" class="inline-btn">login now</a> -->
                <div class="regis_login">
                    <a href="slemania_register.php" class="register_btn">Register</a>
                    <a href="slemania_login.php" class="login_btn">Login</a>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </section>
    
    <section>
        
        <div class="slemania_comments_section">
            <p class="comment_title">Komentar Postingan</p>
            <?php
                $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $select_comments->execute([$get_id]);
                if($select_comments->rowCount() > 0){
                    while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="comment_box" style="<?php if($fetch_comments['slemania_id'] == $slemania_id){echo 'order:-1;'; } ?>">
                <div class="slemania_comment_profile">
                    <i class="fas fa-user" style="color: var(--hitam);"></i>
                    <div>
                        <span><?= $fetch_comments['slemania_name']; ?></span>
                        <div class="slemania_date"><?= $fetch_comments['date']; ?></div>
                    </div>
                </div>
                <div class="slemania_comment">
                    <?= $fetch_comments['comment']; ?>
                </div>
                <?php
                    if($fetch_comments['slemania_id'] == $slemania_id){  
                ?>
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?= $fetch_comments['id']; ?>">
                        <button type="submit" class="edit_comment_btn" name="open_edit_box">Sunting komentar</button>
                        <button type="submit" class="delete_comment_btn" name="delete_comment" onclick="return confirm('delete this comment?');">Hapus komentar</button>
                    </form>
                <?php
                    }
                ?>
            </div>
            <?php
                    }
                }else{
                    echo '<p>Belum ada komentar!</p>';
                }
            ?>
        </div>
    </section>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
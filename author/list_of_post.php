<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
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
    $message[] = 'postingan berhasil dihapus';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Postingan</title>
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
        form{
            padding: 30px;
            background-color: var(--putih);
            margin: 10px 0;
            color: var(--hitam);
        }
        section{
            width: 83%;
        }
        .title_view_post{
            margin: 20px 0 0 20px;
            color: var(--hitam);
        }
        .post_wrap{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
            gap: 1.5rem;
            justify-content: center;
            align-items: start;
            margin: 10px 20px;
        }
        img{
            width: 100%
        }
        .status{
            margin: 5px 0;
            font-size: 12px;
            color: var(--putih);
            padding: 5px;
            display: inline-block;
        }
        .title{
            font-weight:700;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .posts_content{
            margin: 5px 0;
        }
        .posts_content::after{
            content: "...";
        }
        .icons{
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid var(--putih_gelap);
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
        .view_btn, .edit_btn, .delete_btn{
            border-style: none;
            padding: 10px;
            flex-grow: 1;
            font-size: 14px;
            text-align: center;text-decoration: none;
            color: var(--putih);
            cursor: pointer;
        }
        .edit_btn{
            background-color: var(--hijau);
        }
        .delete_btn{
            background-color: var(--merah);
        }
        .view_btn{
            background-color: var(--kuning);
        }
        @media only screen and (max-width: 1440px){
            .title{
                font-size: 18px;
            }
            .posts_content, .comments span{
                font-size: 16px;
            }
            form{
                padding: 20px;
                margin: 0;
            }
            .view_btn, .edit_btn, .delete_btn{
                padding: 8px;
            }
        }

        .search_bar{
            background-color: white;
            display: flex;
            column-gap: 5px;
        }
        .search_bar input{
            padding: 12px;
            flex: 7;
            background-color: var(--putih);
            border: none;
        }
        .search_bar button{
            padding: 12px;
            flex: 1;
            background-color: var(--kuning);
            border: none;
            cursor: pointer;
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
    <section>
        <h2 class="title_view_post">Daftar Postingan</h2>
        <form action="search_post.php" method="POST" class="search_bar">
            <input type="text" placeholder="Cari postingan" required maxlength="100" name="searchbar">
            <button class="fas fa-search" name="search_btn"></button>
        </form>
        <div class="post_wrap">
            <?php
                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE author_id = ?");
                $select_posts->execute([$author_id]);
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
                <form action="" method="post">
                    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                        <?php 
                            if($fetch_posts['image'] != ''){ ?>
                                <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
                        <?php } ?>
                    <div class="status" style="background-color:<?php if($fetch_posts['status'] == 'active'){echo '#379777'; }else{echo '#e2be0a';}; ?>;"><?= $fetch_posts['status']; ?></div>
                    <div class="title"><?= $fetch_posts['title']; ?></div>
                    <div class="posts_content"><?= $fetch_posts['content']; ?></div>
                    <div class="icons">
                        <div class="likes"><i class="fas fa-heart"></i><span> <?= $total_post_likes; ?></span></div>
                        <div class="comments"><i class="fas fa-comment"></i><span> <?= $total_post_comments; ?></span></div>
                    </div>
                    <div class="btn_wrap">
                        <a href="edit_posts.php?post_id=<?= $post_id; ?>" class="edit_btn">sunting</a>
                        <button type="submit" name="delete" class="delete_btn" onclick="return confirm('Hapus postingan berikut?');">delete</button>
                        <a href="read_posts.php?post_id=<?= $post_id; ?>" class="view_btn">lihat postingan</a>
                    </div>
                </form>
            <?php
                }
            }else{
                echo '<p style="color: var(--hitam);">Belum ada postingan!';
            }
            ?>
        </div>
    </section>
    <script>
        document.querySelectorAll('.posts_content').forEach(content => {
            if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>
</body>
</html>
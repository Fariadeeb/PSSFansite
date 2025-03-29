<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
};

include '../components/post_likes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Forum</title>
    <style>
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
        body{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main{
            width: 80%;
            margin-inline: auto;
            display: flex;
            column-gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
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
        .left_content {
            flex: 3;
        }
        .right_content {
            flex: 1;
        }
        .input_container {
            display: flex;
            column-gap: 5px;
            justify-content: center;
            padding: 15px;
            background-color: var(--putih);
        }
        .search_input {
            background-color: var(--putih_gelap);
            color: var(--hitam);
            vertical-align: middle;
            font-size: 14px;
            padding: 8px 20px;
            border: 0;
            width: 80%;
            outline: none;
        }

        .submit_input {
            width: 15%;
            font-size: 14px;
            border: none;
            background-color: var(--kuning);
            color: var(--hitam);
            font-family: "Montserrat";
            cursor: pointer;
        }
        .posts_wrap {
            margin: 20px 0;
            color: var(--hitam);
        }
        .card_post {
            background-color: var(--putih);
            color: var(--abuTua);
            box-sizing: border-box;
            padding: 30px;
            margin: 20px 0;
        }
        .text_post{
            line-height: 1.4;
            margin-top: 8px;
        }
        .card_profile {
            display: flex;
            align-items: center;
            column-gap: 20px;
            margin-bottom: 10px;
        }
        
        .categories{
            padding: 25px;
            background-color: var(--putih);
            color: var(--hitam);
        }
        .categories_wrap{
            display: flex;
            flex-wrap: wrap;
            margin: 15px 0 25px 0;
            gap: 10px 5px;
        }
        .category_bubble{
            padding: 8px;
            border: 1px solid var(--hitam);
            text-decoration: none;
            color: var(--hitam);
            font-size: 14px;
        }
        .category_bubble:hover{
            color: var(--putih);
            background-color: var(--hijau);
            border-color: var(--hijau);
        }
        @media only screen and (max-width: 1280px){
            .left_content {
                flex: 5;
            }
            .right_content {
                flex: 2;
            }
        }
        .post_image{
            width: 100%;
            height: 350px;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .post_icons{
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding: 10px;
            border: 1.5px solid var(--putih_gelap);
        }
        .post_icons a{
            text-decoration: none;
            color: var(--hitam);
        }
        .post_icons button{
            background-color: Transparent;
            background-repeat:no-repeat;
            border: none;
            cursor: pointer;
            color: var(--hitam);
            font-size: 16px;
        }
        .uname_author{
            text-decoration: none;
            color: var(--hitam);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>

    <main>
        <section class="left_content">
            <div class="search_bar">
                <form method="POST" action="search_post.php">
                    <div class="input_container">
                        <input type="text" class="search_input" value="" name="search_box" />
                        <button type="submit" class="submit_input" name="search_btn">Cari</button>
                    </div>
                </form>
            </div>
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
            <div class="posts_wrap">
            <?php
                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? ");
                $select_posts->execute(['active']);
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
            
                <form method="post" class="card_post">
                    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                    <input type="hidden" name="author_id" value="<?= $fetch_posts['author_id']; ?>">
                    <div class="card_profile">
                        <i class="fas fa-user"></i>
                        <div class="name_time">
                            <a href="author_posts.php?author=<?= $fetch_posts['name']; ?>" class="uname_author"><?= $fetch_posts['name']; ?></a>
                            <p style="font-size: 12px; margin-top: 3px;"><?= $fetch_posts['date']; ?></p>
                        </div>
                    </div>
                    <div class="card_content">
                        <?php
                            if($fetch_posts['image'] != ''){  
                        ?>
                        <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="post_image" alt="">
                        <?php
                            }
                        ?>
                        <a href="read_post.php?post_id=<?= $post_id; ?>" style="text-decoration: none; color:var(--hitam); font-size: 20px; font-weight:700; text-transform: capitalize;"><?= $fetch_posts['title']; ?></a>
                        <p class="text_post"><?= $fetch_posts['content']; ?></p>
                    </div>
                    <a href="posts_category.php?category=<?= $fetch_posts['category']; ?>" class="post-cat" style="margin-bottom: 5px; text-decoration:none; font-size:12px; color:var(--hijau);" >
                        <span> #<?= $fetch_posts['category']; ?></span>
                    </a>
                    <div class="post_icons">
                        <a href="read_post.php?post_id=<?= $post_id; ?>"><i class="fas fa-comment"></i><span> <?= $total_post_comments; ?></span></a>
                        <button type="submit" name="post_likes">
                            <i class="fas fa-heart" style="<?php if($confirm_likes->rowCount() > 0){ echo 'color:#ee4e4e;'; } ?>  "></i>
                            <span> <?= $total_post_likes; ?></span>
                        </button>
                    </div>
                </form>
                <?php
                    }
                    }else{
                        echo '<p>Postingan tidak tersedia!</p>';
                    }
                ?>
            </div>
        </section>
        <section class="right_content">
            <div class="categories">
                <h3>kategori</h3>
                <div class="categories_wrap">
                    <a href="posts_category.php?category=sejarah" class="category_bubble">Sejarah</a>
                    <a href="posts_category.php?category=performa tim" class="category_bubble">performa tim</a>
                    <a href="posts_category.php?category=formasi" class="category_bubble">formasi</a>
                    <a href="posts_category.php?category=strategi" class="category_bubble">strategi</a>
                    <a href="posts_category.php?category=prediksi skor" class="category_bubble">prediksi skor</a>
                    <a href="posts_category.php?category=rumor transfer" class="category_bubble">rumor transfer</a>
                    <a href="posts_category.php?category=kontrak pemain" class="category_bubble">update kontrak</a>
                    <a href="posts_category.php?category=statistik pemain" class="category_bubble">statistik pemain</a>
                    <a href="posts_category.php?category=tradisi klub" class="category_bubble">tradisi klub</a>
                </div>
                <!-- <a href="#" class="selengkapnya_btn">Selengkapnya</a> -->
            </div>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
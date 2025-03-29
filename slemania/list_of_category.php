<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
    $slemania_id = $_SESSION['slemania_id'];
}else{
    $slemania_id = '';
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Daftar Kategori</title>
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
        body{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main{
            width: 80%;
            margin-inline: auto;
            flex: 1;
        }
        section{
            margin: 30px 0;
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
        .category_wrapper{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(14rem, 1fr));
            gap: 10px;
        }

        .category_wrapper div{
            background-size: cover;
            background-position: center;
            width: 100%;
            padding: 30px 0;
            text-align: center;
            cursor: pointer;
        }

        .category_wrapper div:hover{
            filter: brightness(50%);
            transition: 0.5s;
        }

        .category_wrapper div a{
            text-decoration: none;
            font-size: 14px;
            color: var(--putih);
            font-weight: 600;
        }

        .cat_jersey{
            background-image: url(../img/merch/kategori_jersey.png);
        }
        .cat_tracktop{
            background-image: url(../img/merch/kategori_tracktop.png);
        }
        .cat_trackpants{
            background-image: url(../img/merch/kategori_trackpants.png);
        }
        .cat_tshirt{
            background-image: url(../img/merch/kategori_tshirt.png);
        }
        .cat_bagpack{
            background-image: url(../img/merch/kategori_bag.png);
        }
        .cat_cyclingjersey{
            background-image: url(../img/merch/kategori_cycling.png);
        }
        .cat_shorts{
            background-image: url(../img/merch/kategori_short.png);
        }
        .cat_socks{
            background-image: url(../img/merch/kategori_sock.png);
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <section>
            <h3 style="margin-bottom: 15px; color:var(--hitam);">Daftar kategori</h3>
            <div class="category_wrapper">
                <div class="cat_jersey"><a href="categories.php?category=jersey">Jersey</a ></div>
                <div class="cat_tracktop"><a href="categories.php?category=tracktop">Tracktops</a ></div>
                <div class="cat_trackpants"><a href="categories.php?category=trackpants">Trackpants</a ></div>
                <div class="cat_tshirt"><a href="categories.php?category=tshirt">T-shirt</a ></div>
                <div class="cat_bagpack"><a href="categories.php?category=bagpack">Accessories</a ></div>
                <div class="cat_cyclingjersey"><a href="categories.php?category=cyclingjersey">Cycling Jersey</a ></div>
                <div class="cat_shorts"><a href="categories.php?category=shorts">Shorts</a ></div>
                <div class="cat_socks"><a href="categories.php?category=socks">socks</a ></div>
            </div>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
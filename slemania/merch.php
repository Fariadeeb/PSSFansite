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
    <title>Merchandise</title>
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

        main{
            width: 80%;
            margin-inline: auto;
        }

        .section_title{
            font-size: 18px;
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

        .welcome {
            background-image: url(../img/merch/heroimg_merch.png);
            background-size: cover;
            background-position: center;
            height: 500px;
            text-align: center;
            color: var(--putih);
            font-size: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CATEGORY */
        .category{
            margin: 40px 0;
        }
        .category_txt{
            display: flex;
            justify-content: space-between;
            align-items: end;
        }
        .category_txt a{
            font-size: 14px;
            text-decoration: none;
            color: var(--hitam);
        }
        .category_wrapper{
            display: flex;
            justify-content: space-between;
            column-gap: 10px;
        }

        .category_wrapper div{
            background-size: cover;
            background-position: center;
            width: 100%;
            padding: 30px 0;
            text-align: center;
            cursor: pointer;
            margin: 10px 0;
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
        /* CATEGORY END */

        /* PRODUCTS */
        .product{
            margin: 40px 0;
        }
        .product_txt{
            display: flex;
            justify-content: space-between;
            align-items: end;
        }
        .product_txt a{
            font-size: 14px;
            text-decoration: none;
            color: var(--hitam);
        }
        .product_wrapper{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            column-gap: 10px;
        }
        .card{
            padding: 20px;
            background-color: var(--putih);
            margin: 10px 0;
            color: var(--hitam);
        }
        .card img{
            width: 100%;
        }
        .card a{
            text-decoration: none;
            color: var(--hitam);
            font-size: 16px;
            display: inline-block;
            margin: 5px 0;
            line-height: 1.3;
        }
        .card h3{
            color: var(--hitam);
            font-size: 18px;
        }
        /* PRODUCTS END */
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <section class="welcome">
            <h1 class="welcome_title">Merchandise</h1>
        </section>
        <section class="category">
            <div class="category_txt">
                <h3 class="section_title">Kategori</h3>
                <a href="list_of_category.php">Selengkapnya</a>
            </div>
            <div class="category_wrapper">
                <div class="cat_jersey"><a href="categories.php?category=jersey">Jersey</a ></div>
                <div class="cat_tracktop"><a href="categories.php?category=tracktop">Tracktops</a ></div>
                <div class="cat_trackpants"><a href="categories.php?category=trackpants">Trackpants</a ></div>
                <div class="cat_tshirt"><a href="categories.php?category=tshirt">T-shirt</a ></div>
            </div>
        </section>
        <section class="product">
            <div class="product_txt">
                <h3 class="section_title">Produk Terbaru</h3>
                <a href="list_of_product.php">Selengkapnya</a>
            </div>
            <div class="product_wrapper">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 4"); 
                    $select_products->execute();
                    if($select_products->rowCount() > 0){
                        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="card">
                    <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="" />
                    <a href="detail_product.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['name']; ?></a>
                    <h3>Rp<?= $fetch_product['price']; ?></h3>
                </form>
                <?php
                    }
                }else{
                    echo '<p>Belum ada produk yang ditambahkan!</p>';
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
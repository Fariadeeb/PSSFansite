<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
    $slemania_id = $_SESSION['slemania_id'];
}else{
    $slemania_id = '';
};

include '../components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Kategori</title>
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

        main h3{
            color: var(--hitam);
            font-size: 18px;
            margin: 20px 0 5px 0;
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
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <h3>Kategori produk terkait</h3>
        <div class="product_wrapper">
            <?php
                $category = $_GET['category'];
                $select_products = $conn->prepare("SELECT * FROM `products`WHERE name LIKE '%{$category}%'"); 
                $select_products->execute();
                if($select_products->rowCount() > 0){
                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="card">
                <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="" />
                <a href="detail_product.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['name']; ?></a>
                <h3>Rp<?= $fetch_product['price']; ?></h3>
            </form action="" method="post">
            <?php
                }
            }else{
                echo '<p>Produk tidak tersedia!</p>';
            }
            ?>
        </div>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
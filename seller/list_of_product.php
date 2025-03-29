<?php
include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
   header('location:seller_login.php');
};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:list_of_product.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Daftar Produk</title>
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
            color: var(--hitam);
        }

        .box{
            padding: 30px;
            background-color: var(--putih);
            margin: 10px 0;
            color: var(--hitam);
        }

        .products_wrap{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            gap: 1.5rem;
            justify-content: center;
            align-items: start;
            margin: 10px 20px;
        }
        img{
            width: 100%
        }
        .price{
            font-weight:700;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .name{
            margin: 5px 0;
        }
        .btn_wrap{
            display: flex;
            column-gap: 5px;
            margin-top: 10px;
        }
        .update_btn, .delete_btn{
            border-style: none;
            padding: 10px;
            flex-grow: 1;
            font-size: 14px;
            text-align: center;text-decoration: none;
            color: var(--putih);
        }
        .update_btn{
            background-color: var(--kuning);
        }
        .delete_btn{
            background-color: var(--merah);
        }
    </style>
</head>
<body>
    <?php include '../components/sidebar_seller.php' ?>

    <section>
        <h2 style="margin: 20px 0 0 20px;">Daftar Postingan</h2>
        <div class="products_wrap">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                $select_products->execute([$seller_id]);
                if($select_products->rowCount() > 0){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="box">
                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="price">Rp<span><?= $fetch_products['price']; ?></span></div>
                <div class="btn_wrap">
                    <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="update_btn">perbarui</a>
                    <a href="list_of_product.php?delete=<?= $fetch_products['id']; ?>" class="delete_btn" onclick="return confirm('Hapus produk berikut?');">hapus</a>
                </div>
            </div>
            <?php
                    }
                }else{
                    echo '<p>Belum ada produk yang ditambahkan!</p>';
                }
            ?>
        </div>
    </section>
</body>
</html>
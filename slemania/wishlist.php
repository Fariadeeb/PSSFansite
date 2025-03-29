<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
   header('location:slemania_login.php');
};

include '../components/wishlist_cart.php';

if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist_item->execute([$wishlist_id]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Wishlist</title>
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

        .wishlist_title{
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

        .wishlist_wrapper{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            column-gap: 10px;
            margin-bottom: 20px;
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
        .delete_btn{
            width: 100%;
            padding: 8px;
            margin-top: 15px;
            border: none;
            background-color: var(--merah);
            color: var(--putih);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <h3 class="wishlist_title">Wishlist Produk</h3>
        <section class="wishlist_wrapper">
            <?php
                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE slemania_id = ?");
                $select_wishlist->execute([$slemania_id]);
                if($select_wishlist->rowCount() > 0){
                    while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="card">
                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                <img src="../uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="" />
                <a href="detail_product.php?pid=<?= $fetch_wishlist['pid']; ?>"><?= $fetch_wishlist['name']; ?></a>
                <h3>Rp<?= $fetch_wishlist['price']; ?></h3>
                <input type="submit" value="hapus item" onclick="return confirm('hapus item dari wishlist?');" class="delete_btn" name="delete">
            </form>
            <?php
                }
            }else{
                echo '<p>Wishlist anda kosong!</p>';
            }
            ?>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
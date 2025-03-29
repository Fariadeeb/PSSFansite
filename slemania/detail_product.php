<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
};

include '../components/wishlist_cart.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Detil produk</title>
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
        form{
            display: flex;
            column-gap: 20px;
        }
        .image_container{
            width: 40%;
            display: flex;
            flex-direction: column;
        }
        .content{
            width: 60%;
            color: var(--hitam);
        }
        .main_image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .sub_image{
            display: flex;
            column-gap: 5px;
            margin-top: 5px;
        }
        .sub_image img {
            width: 32.5%;
            cursor: pointer;
        }
        .name{
            font-size: 18px;
            font-weight: 500;
        }
        .price{
            font-size: 24px;
            margin: 8px 0 20px 0;
        }
        .quantity, .details, .size_options{
            margin: 20px 0;
        }
        
        .quantity p, .size_options p, .sub{
            margin-bottom: 5px;
            font-weight: 700;
            font-size: 16px;
        }
        .quantity input{
            text-align: center;
        }
        
        .deskripsi{
            line-height: 1.3;
        }
        .cart_wishlist_btn{
            display: flex;
            column-gap: 8px;
        }
        .add_cart_btn {
            padding: 10px 15px;
            border: none;
            background-color: var(--hijau);
            color: var(--putih);
            cursor: pointer;
        }
        .add_wl_btn{
            padding: 10px 15px;
            border: 1.5px solid var(--hijau);
            background-color: #fff;
            color: var(--hijau);
            cursor: pointer;
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
        .message{
            text-align: center;
            margin-top: 10px;
        }
        .message span{
            margin-left: 10px;
        }
        .message i{
            cursor: pointer;
        }
        .message i:hover{
            color: var(--merah);
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
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
    <?php
        $pid = $_GET['pid'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
        $select_products->execute([$pid]);
        if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form action="" method="post" class="show_product">
        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
        <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
        <input type="hidden" name="selected_size" id="selected_size">

        <div class="image_container">
            <div class="main_image">
                <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub_image">
                <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                <img src="../uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
                <img src="../uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
        </div>
        <div class="content">
            <h3 class="name"><?= $fetch_product['name']; ?></h3>
            <h3 class="price">Rp<?= $fetch_product['price']; ?></h3>
            <div class="quantity">
                <p>Jumlah</p>
                <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <div class="details">
                <p class="sub">Deskripsi</p>
                <p class="deskripsi"><?= $fetch_product['details']; ?></p>
            </div>
            <div class="size_options">
                <p>Ukuran</p>
                <?php 
                    $sizes = explode(',', $fetch_product['sizes']); // Memecah string ukuran menjadi array
                    foreach($sizes as $size){
                        echo "
                            <label class='size-label'>
                                <input type='radio' name='size' value='$size' required> 
                                <span>$size</span>
                            </label>
                        ";
                    }
                ?>
            </div>
            <div class="cart_wishlist_btn">
                <input type="submit" value="Tambah ke keranjang" class="add_cart_btn" name="add_to_cart">
                <input type="submit" value="Tambah ke wishlist" class="add_wl_btn"  name="add_to_wishlist">
            </div>
        </div>
    </form>
    <?php
        }
    }else{
        echo '<p>produk tidak tersedia!</p>';
    }
    ?>
    </section>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
    <script>
        let mainImage = document.querySelector('.show_product .image_container .main_image img');
        let subImages = document.querySelectorAll('.show_product .image_container .sub_image img');

        subImages.forEach(images =>{
            images.onclick = () =>{
                src = images.getAttribute('src');
                mainImage.src = src;
            }
        });

        document.querySelectorAll("input[name='size']").forEach(input => {
        input.addEventListener("change", function() {
            document.getElementById("selected_size").value = this.value;
        });
    });
    </script>
</body>
</html>
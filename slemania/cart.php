<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
   header('location:slemania_login.php');
};


if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE slemania_id = ?");
    $delete_cart_item->execute([$slemania_id]);
    header('location:cart.php');
 }
 
 if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'jumlah produk pada keranjang telah diperbarui!';
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Keranjang</title>
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
            margin-top: 10px;
            border: none;
            background-color: var(--merah);
            color: var(--putih);
            cursor: pointer;
        }
        .quantity_btn{
            display: flex;
            column-gap: 5px;
            margin: 25px 0 5px 0;
        }
        .qty{
            flex: 2;
            padding: 5px;
            border: none;
            text-align: center;
        }
        .fas{
            flex: 1;
            padding: 5px;
            border: none;
            background-color: var(--kuning);
            color: var(--putih);
            cursor: pointer;
        }
        .sub_total{
            font-size: 14px;
            margin-top: 5px;
        }
        .total_wrapper{
            width: 50%;
            margin-inline: auto;
        }
        .cart_total{
            margin: 30px 0;
            padding: 30px;
            background-color: var(--putih);
        }
        .cart_btns{
            display: flex;
            flex-direction: column;
            row-gap: 5px;
            margin-top: 20px;
        }
        .cart_btns a{
            display: block;
            padding: 10px;
            text-decoration: none;
            text-align: center;
            color: var(--putih);
            font-size: 14px;
        }
        .back_btn{
            background-color: var(--kuning);
        }
        .delete_all_btn{
            background-color: var(--merah);
        }
        .checkout_btn{
            background-color: var(--hijau);
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
                <div class="message" style="text-align: center; margin-top: 10px;">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <main>
        <h3 class="wishlist_title">Keranjang Produk</h3>
        <section class="wishlist_wrapper">
            <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE slemania_id = ?");
                $select_cart->execute([$slemania_id]);
                if($select_cart->rowCount() > 0){
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="card">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="../uploaded_img/<?= $fetch_cart['image']; ?>" alt="" />
                <a href="detail_product.php?pid=<?= $fetch_cart['pid']; ?>"><?= $fetch_cart['name']; ?></a>
                <h3>Rp<?= $fetch_cart['price']; ?></h3>
                <div class="quantity_btn">
                    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                    <button type="submit" class="fas fa-edit" name="update_qty"></button>
                </div>
                <p class="sub_total">Size: <span><?= $fetch_cart['size']; ?></span></p>
                <p class="sub_total">sub total: <span style="color: var(--hijau);">Rp<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></p> 
                <input type="submit" value="hapus item" onclick="return confirm('hapus item berikut dari keranjang belanja anda?');" class="delete_btn" name="delete">
            </form>
            <?php
                $grand_total += $sub_total;
                    }
                }else{
                    echo '<p>Keranjang belanja anda kosong!</p>';
                }
            ?>
        </section>
        <section class="total_wrapper">
            <div class="cart_total">
                <p>Jumlah total: <span style="color: var(--hijau);">Rp<?= $grand_total; ?></span></p>
                <div class="cart_btns">
                    <a href="merch.php" class="back_btn">kembali belanja</a>
                    <a href="cart.php?delete_all" class="delete_all_btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Hapus seluruh item dari keranjang belanja anda?');">Hapus seluruh item</a>
                    <a href="checkout.php" class="checkout_btn <?= ($grand_total > 1)?'':'disabled'; ?>">Melanjutkan checkout</a>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
<?php

include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
    header('location:seller_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Dashboard Seller</title>
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
        }

        * {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
        }

        .dashboard {
            width: 83%;
        }

        .title_ikhtisar {
            margin: 20px 0 0 20px;
            color: var(--hitam);
        }

        .box_container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
            gap: 1.5rem;
            justify-content: center;
            align-items: start;
            margin: 30px 20px;
        }

        .box {
            padding: 20px;
            min-width: 250px;
            background-color: var(--putih);
            color: var(--hitam);
            box-sizing: border-box;
        }

        .jumlah_wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0 30px 0;
        }

        .btn_wrap {
            background-color: var(--putih_gelap);
            width: 100%;
            padding: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn_wrap:hover {
            background-color: var(--kuning);
            transition: 0.3s;
        }

        .lihat_btn {
            text-decoration: none;
            color: var(--hitam);
        }
    </style>
</head>
<body>
    <?php include '../components/sidebar_seller.php' ?>
    <div class="dashboard">
        <h2 class="title_ikhtisar">Ikhtisar Dashboard Seller</h2>
        <div class="box_container">
            <div class="box">
                <?php
                    $total_pendings = 0;
                    $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND payment_status = ?");
                    $select_pendings->execute([$seller_id, 'pending']);
                    while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                        $total_pendings += $fetch_pendings['total_price'];
                    }
                    
                ?>
                <p class="judul_card">Total pending</p>
                <div class="jumlah_wrap">
                    <h3><?= $total_pendings; ?></h3>
                    <img src="../img/merch/iconPesananPending.png" alt="">
                </div>
                <div class="btn_wrap">
                    <a href="ordered_product.php" class="lihat_btn">Lihat pesanan</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $total_completes = 0;
                    $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND payment_status = ?");
                    $select_completes->execute([$seller_id, 'completed']);
                    while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                        $total_completes += $fetch_completes['total_price'];
                    }
                    
                ?>
                <p class="judul_card">Pesanan selesai</p>
                <div class="jumlah_wrap">
                    <h3><?= $total_completes; ?></h3>
                    <img src="../img/merch/iconPesananSelesaii.png" alt="">
                </div>
                <div class="btn_wrap">
                    <a href="ordered_product.php" class="lihat_btn">Lihat pesanan</a>
                </div>
            </div>

            <div class="box">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                    $select_orders->execute([$seller_id]);
                    $number_of_orders = $select_orders->rowCount()
                ?>
                <p class="judul_card">Pesanan masuk</p>
                <div class="jumlah_wrap">
                    <h3><?= $number_of_orders; ?></h3>
                    <img src="../img/merch/iconPesananMasuk.png" alt="">
                </div>
                <div class="btn_wrap">
                    <a href="ordered_product.php" class="lihat_btn">Lihat pesanan</a>
                </div>
            </div>
            
            <div class="box">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                    $select_products->execute([$seller_id]);
                    $number_of_products = $select_products->rowCount()
                ?>
                <p class="judul_card">Total produk</p>
                <div class="jumlah_wrap">
                    <h3><?= $number_of_products; ?></h3>
                    <img src="../img/merch/iconTotalProduk.png" alt="">
                </div>
                <div class="btn_wrap">
                    <a href="list_of_product.php" class="lihat_btn">Lihat produk</a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
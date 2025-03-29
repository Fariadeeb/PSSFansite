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
    <title>Orders</title>
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
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
            column-gap: 15px;
            margin-bottom: 10px;
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
        .invoice_wrapper{
            margin: 10px 0;
            padding: 20px;
            background-color: var(--putih);
            color: var(--hitam);
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }
        .invoice_wrapper span{
            color: var(--hijau);
        }
        .invoice_title{
            color: var(--hitam);
            font-size: 18px;
            margin: 20px 0 5px 0;
        }
        
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    
    <main>
        <h3 class="invoice_title">Faktur</h3>
        <section>
            <?php
                if($slemania_id == ''){
                    echo '<p>harap login terlebih dahulu untuk melihat pesanan anda</p>';
                }else{
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE slemania_id = ?");
                    $select_orders->execute([$slemania_id]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="invoice_wrapper">
                <p>Dipesan pada: <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p>Nama: <span><?= $fetch_orders['name']; ?></span></p>
                <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
                <p>Nomor Hp: <span><?= $fetch_orders['number']; ?></span></p>
                <p>Alamat: <span><?= $fetch_orders['address']; ?></span></p>
                <p>Metode Pembayaran: <span><?= $fetch_orders['method']; ?></span></p>
                <p>Pesananmu: <span><?= $fetch_orders['total_products']; ?></span></p>
                <p>Total biaya: <span>Rp<?= $fetch_orders['total_price']; ?></span></p>
                <p>Kode Pembayaran: <span><?= $fetch_orders['payment_code']; ?></span></p>
                <p>Status Pembayaran: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo '#ee4e4e'; }else{ echo '#379777'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
            </div>
            <?php
                        }
                    }else{
                    echo '<p>belum ada pesanan yang dilakukan!</p>';
                    }
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
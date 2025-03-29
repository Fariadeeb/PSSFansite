<?php

include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
   header('location:seller_login.php');
};

if(isset($_POST['update_payment'])){
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment->execute([$payment_status, $order_id]);
    $message[] = 'status pembayaran diperbarui!';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:ordered_product.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Pesanan Masuk</title>
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
            /* display: flex;
            justify-content: center; 
            align-items: center;  */
            width: 83%;
        }
        .title{
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
            background-color: var(--putih);
            color: var(--hitam);
        }
        .box div{
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .box div p{
            flex: 1;
        }

        .box div span{
            text-align: justify;
            flex: 2;
        }

        .select{
            width: 100%;
            padding: 8px;
            border: 1px solid var(--putih_gelap);
        }

        .btn_wrap{
            display: flex;
            column-gap: 5px;
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
    <?php include '../components/sidebar_seller.php' ?>

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
        <h2 class="title">Pesanan Produk</h2>
        <div class="box_container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                $select_orders->execute([$seller_id]);
                if($select_orders->rowCount() > 0){
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="box">
                <div class="slemania_id">
                    <p>id pengguna: </p>
                    <span><?= $fetch_orders['slemania_id']; ?></span>
                </div>
                <div class="date_placed">
                    <p>tanggal: </p>
                    <span><?= $fetch_orders['placed_on']; ?></span>
                </div>
                <div class="name">
                    <p>nama: </p>
                    <span><?= $fetch_orders['name']; ?></span>
                </div>
                <div class="email">
                    <p>email: </p>
                    <span><?= $fetch_orders['email']; ?></span>
                </div>
                <div class="number">
                    <p>telepon: </p>
                    <span><?= $fetch_orders['number']; ?></span>
                </div>
                <div class="address">
                    <p>alamat: </p>
                    <span><?= $fetch_orders['address']; ?></span>
                </div>
                <div class="total_product">
                    <p>produk: </p>
                    <span><?= $fetch_orders['total_products']; ?></span>
                </div>
                <div class="total_price">
                    <p>total biaya: </p>
                    <span>Rp<?= $fetch_orders['total_price']; ?></span>
                </div>
                <div class="payment_method">
                    <p>metode pembayaran: </p>
                    <span><?= $fetch_orders['method']; ?></span>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                    <select name="payment_status" class="select">
                        <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                    </select>
                    <div class="btn_wrap">
                        <input type="submit" value="perbarui" class="update_btn" name="update_payment">
                        <a href="ordered_product.php?delete=<?= $fetch_orders['id']; ?>" class="delete_btn" onclick="return confirm('Hapus pesanan berikut?');">hapus</a>
                    </div>
                </form>
            </div>
            <?php
                    }
                }else{
                    echo '<p>Belum ada pesanan masuk!</p>';
                }
            ?>
        </div>
    </section>
</body>
</html>
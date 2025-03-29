<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
   $slemania_id = $_SESSION['slemania_id'];
}else{
   $slemania_id = '';
   header('location:slemania_login.php');
};


if(isset($_POST['order'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['alamat'] .', '. $_POST['kelurahan'] .', '. $_POST['kecamatan'] .', '. $_POST['kabupaten'] .', '. $_POST['provinsi'] .' - '. $_POST['kode_pos'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    

    // Ambil semua seller_id unik dari keranjang pengguna
    $get_sellers = $conn->prepare("SELECT DISTINCT seller_id FROM cart WHERE slemania_id = ?");
    $get_sellers->execute([$slemania_id]);
    $seller_ids = $get_sellers->fetchAll(PDO::FETCH_COLUMN); // Ambil semua seller_id sebagai array

    if(count($seller_ids) > 0) {
        foreach ($seller_ids as $seller_id) {
            // Ambil produk dari cart hanya untuk seller_id tertentu
            $get_cart_items = $conn->prepare("SELECT * FROM cart WHERE slemania_id = ? AND seller_id = ?");
            $get_cart_items->execute([$slemania_id, $seller_id]);
            $cart_items = $get_cart_items->fetchAll(PDO::FETCH_ASSOC);

            $total_products = "";
            $total_price = 0;

            foreach ($cart_items as $item) {
                $total_products .= $item['name'] . " (" . $item['quantity'] . " - " . $item['size'] . "), ";
                $total_price += $item['price'] * $item['quantity'];
            }

            $total_products = rtrim($total_products, ", "); // Hapus koma terakhir

            // Buat kode pembayaran jika bukan COD
            $payment_code = null;
            if ($method != "bayar di tempat") {
                $payment_code = "INV-" . time() . rand(100, 999);
            }

            // Simpan pesanan ke dalam tabel orders
            $insert_order = $conn->prepare("INSERT INTO `orders`(slemania_id, seller_id, name, number, email, method, address, total_products, total_price, payment_code) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$slemania_id, $seller_id, $name, $number, $email, $method, $address, $total_products, $total_price, $payment_code]);

            // Hapus produk terkait dari cart setelah dimasukkan ke pesanan
            $delete_cart = $conn->prepare("DELETE FROM cart WHERE slemania_id = ? AND seller_id = ?");
            $delete_cart->execute([$slemania_id, $seller_id]);
        }

        echo "<script>alert('Checkout berhasil! Pesanan telah dibuat.');</script>";
    } else {
        echo "<script>alert('Keranjang belanja anda kosong.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Checkout</title>
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
        .checkout_title{
            color: var(--hitam);
            font-size: 18px;
            margin: 20px 0 5px 0;
        }
        .display_orders{
            display: flex;
            margin: 10px 0;
        }
        .product_wrapper{
            flex: 4;
        }
        .grand_total{
            flex: 2;
        }
        .total_wrapper{
            padding: 20px;
            background-color: var(--putih);
        }
        .product_card{
            padding: 20px;
            background-color: var(--putih);
            margin: 5px 0;
            display: inline-block;
        }

        .section_title{
            font-size: 16px;
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
        .place_orders{
            background-color: var(--putih);
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            column-gap: 10px;
            padding: 30px;
            margin: 10px 0;
        }
        .input_box{
            display: flex;
            flex-direction: column;
            margin: 10px 0;
        }
        .input_box input, .input_box select{
            margin-top: 5px;
            padding: 10px;
            border: none;
        }
        .btn_box{
            display: flex;
            flex-direction: column;
            margin: 10px 0;
            align-self: end;
        }
        .btn{
            background-color: var(--hijau);
            padding: 10px;
            border: none;
            cursor: pointer;
            color: var(--putih);
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
        <h3 class="checkout_title">Pesanan anda</h3>
        <form action="" method="POST">
            <div class="display_orders">
                <div class="product_wrapper">
                    <?php
                        $grand_total = 0;
                        $cart_items = [];
                        $seller_ids = [];
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE slemania_id = ?");
                        $select_cart->execute([$slemania_id]);
                        if($select_cart->rowCount() > 0){
                            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                $seller_ids[] = $fetch_cart['seller_id'];
                                $cart_items[] = $fetch_cart['name'].' (Size: '.$fetch_cart['size'].' | '.$fetch_cart['price'].' x '.$fetch_cart['quantity'].') | ';
                                $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    ?>
                    <p class="product_card"> <?= $fetch_cart['name']; ?>
                        : <?= 'Rp'.$fetch_cart['price'].' x '.$fetch_cart['quantity'].' (Size: '.$fetch_cart['size'].')'; ?>
                    </p>
                    
                    <input type="hidden" name="seller_id[]" value="<?= $fetch_cart['seller_id']; ?>">
                    <?php
                            }
                            $total_products = implode($cart_items);
                        }else{
                            echo '<p>Keranjang belanja anda kosong!</p>';
                        }
                    ?>
                </div>
                <div class="grand_total">
                    <div class="total_wrapper">
                        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                        <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                        <div class="grand-total">Jumlah total : <span>Rp<?= number_format($grand_total, 0, ',', '.'); ?></span></div>
                    </div>
                </div>
            </div>
            <div id="payment_code" style="display: none; margin: 20px 0;">
                <h3 class="checkout_title">Kode Pembayaran Anda:</h3>
                <p id="code_display"></p>
            </div>
            <h3 class="checkout_title">Lakukan Pemesanan</h3>
            <div class="place_orders">
                <div class="input_box">
                    <span>Nama:</span>
                    <input type="text" name="name" class="box" maxlength="20" required>
                </div>
                <div class="input_box">
                    <span>Nomor Hp:</span>
                    <input type="number" name="number" class="box" min="0" max="999999999999" onkeypress="if(this.value.length == 12) return false;" required>
                </div>
                <div class="input_box">
                    <span>Email:</span>
                    <input type="email" name="email" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Metode Pembayaran:</span>
                    <select name="method" class="box" required>
                        <option value="bayar di tempat">Bayar di tempat</option>
                        <option value="virtual account">virtual account</option>
                        <option value="dompet digital">Dompet digital</option>
                        <option value="transfer bank">Transfer bank</option>
                    </select>
                </div>
                <div class="input_box">
                    <span>Alamat:</span>
                    <input type="text" name="alamat" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Kelurahan:</span>
                    <input type="text" name="kelurahan" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Kecamatan:</span>
                    <input type="text" name="kecamatan" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Kabupaten:</span>
                    <input type="text" name="kabupaten" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Provinsi:</span>
                    <input type="text" name="provinsi" class="box" maxlength="50" required>
                </div>
                <div class="input_box">
                    <span>Kode pos:</span>
                    <input type="number" min="0" name="kode_pos" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
                </div>
                <div class="btn_box">
                    <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Taruh Pesanan">
                </div>
            </div>
        </form>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
    <script>
        // Ambil kode pembayaran dari PHP dan tampilkan di halaman
        let paymentCode = "<?= isset($payment_code) ? $payment_code : ''; ?>";
        if (paymentCode) {
            document.getElementById('payment_code').style.display = 'block';
            document.getElementById('code_display').innerText = paymentCode;
        }
    </script>
</body>
</html>
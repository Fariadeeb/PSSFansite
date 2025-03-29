<?php

include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
   header('location:seller_login.php');
};

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $size_option = $_POST['size_option'];
    $size_option = filter_var($size_option, FILTER_SANITIZE_STRING);

    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;

    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;

    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$image_03;

    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : 'Default';

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ? AND seller_id = ?");
    $select_products->execute([$name, $seller_id]);

    if($select_products->rowCount() > 0){
        $message[] = 'nama produk sudah ada sebelumnya!';
    }else{
        $insert_product = $conn->prepare("INSERT INTO `products`(seller_id, name, details, price, image_01, image_02, image_03, size_option, sizes) VALUES(?,?,?,?,?,?,?,?,?)");
        $insert_product->execute([$seller_id, $name, $details, $price, $image_01, $image_02, $image_03, $size_option, $sizes]);

        if($insert_product){
            if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
                $message[] = 'ukuran gambar terlalu besar!';
            }else{
                move_uploaded_file($image_tmp_name_01, $image_folder_01);
                move_uploaded_file($image_tmp_name_02, $image_folder_02);
                move_uploaded_file($image_tmp_name_03, $image_folder_03);
                $message[] = 'produk baru berhasil ditambahkan!';
            }
        }
    }  
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Tambah Produk</title>
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
            display: flex;
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
            width: 83%;
        }
        h3{
            color: var(--hitam);
        }
        form{
            width: 40%;
            padding: 30px;
            background-color: var(--putih);
            margin: 40px 0;
        }
        .input_wrap{
            display: flex;
            flex-direction: column;
            row-gap: 8px;
            margin: 20px 0;
        }
        .kolom_nama, .kolom_harga, .kolom_gambar, .kolom_size{
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
        }
        .kolom_deskripsi{
            height: 12rem;
            resize: none;
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
        }
        input[type=submit]{
            width: 100%;
            padding: 12px 0;
            border: none;
            color: var(--putih);
            background-color: var(--hijau);
            cursor: pointer;
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
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Tambah Produk</h3>
            <div class="input_wrap">
                <label for="name">Nama Produk</label>
                <input type="text" id="name" name="name" class="kolom_nama" maxlength="100" required/>
            </div>
            <div class="input_wrap">
                <label for="price">Harga Produk</label>
                <input type="number" min="0" id="price" name="price" class="kolom_harga" maxlength="9999999999" onkeypress="if(this.value.length == 10) return false;" required/>
            </div>
            <div class="input_wrap">
                <label for="size_option">Opsi Ukuran</label>
                <select name="size_option" id="size_option" class="kolom_size" onchange="toggleSizeOptions()">
                    <option value="multisize">multisize</option>
                    <option value="onesize">onesize</option>
                </select>
            </div>
            <div class="input_wrap">
                <div id="sizes" style="display:none;">
                    <label>Pilih Ukuran:</label>
                    <input type="checkbox" name="sizes[]" value="S"> S
                    <input type="checkbox" name="sizes[]" value="M"> M
                    <input type="checkbox" name="sizes[]" value="L"> L
                    <input type="checkbox" name="sizes[]" value="XL"> XL
                </div>
            </div>
            <div class="input_wrap">
                <label for="image_01">Gambar 1</label>
                <input type="file" name="image_01" id="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar" required>
            </div>
            <div class="input_wrap">
                <label for="image_02">Gambar 2</label>
                <input type="file" name="image_02" id="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar" required>
            </div>
            <div class="input_wrap">
                <label for="image_03">Gambar 3</label>
                <input type="file" name="image_03" id="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar" required>
            </div>
            <div class="input_wrap">
                <label for="details">Deskripsi Produk</label>
                <textarea name="details" id="details" maxlength="500" class="kolom_deskripsi" required></textarea>
            </div>
            <input type="submit" value="Tambahkan" class="add_btn" name="add_product">
        </form>
    </section>

    <script>
        function toggleSizeOptions() {
            var size_option = document.getElementById('size_option').value;
            var sizes = document.getElementById('sizes');
            if(size_option === 'multisize') {
                sizes.style.display = 'block';
            } else {
                sizes.style.display = 'none';
            }
        }
    </script>
</body>
</html>
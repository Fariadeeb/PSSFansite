<?php
include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
    header('location:seller_login.php');
}

if(isset($_POST['update'])){

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ?, price = ? WHERE id = ?");
    $update_product->execute([$name, $details, $price, $pid]);

    $message[] = 'product updated successfully!';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;

    if(!empty($image_01)){
    if($image_size_01 > 2000000){
        $message[] = 'image size is too large!';
    }else{
        $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
        $update_image_01->execute([$image_01, $pid]);
        move_uploaded_file($image_tmp_name_01, $image_folder_01);
        unlink('../uploaded_img/'.$old_image_01);
        $message[] = 'image 1 updated successfully!';
    }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;

    if(!empty($image_02)){
    if($image_size_02 > 2000000){
        $message[] = 'image size is too large!';
    }else{
        $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
        $update_image_02->execute([$image_02, $pid]);
        move_uploaded_file($image_tmp_name_02, $image_folder_02);
        unlink('../uploaded_img/'.$old_image_02);
        $message[] = 'image 2 updated successfully!';
    }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$image_03;

    if(!empty($image_03)){
    if($image_size_03 > 2000000){
        $message[] = 'image size is too large!';
    }else{
        $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
        $update_image_03->execute([$image_03, $pid]);
        move_uploaded_file($image_tmp_name_03, $image_folder_03);
        unlink('../uploaded_img/'.$old_image_03);
        $message[] = 'image 3 updated successfully!';
    }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Update Produk</title>
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
        .kolom_nama, .kolom_harga, .kolom_gambar{
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
            font-size: 14px;
        }
        .kolom_deskripsi{
            height: 12rem;
            resize: none;
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
            font-size: 14px;
            line-height: 1.4;
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

        .image_container{
            display: flex;
            column-gap: 10px;
            margin-top: 10px;
        }
        .main_image{
            flex: 3;
            border: 1px solid var(--putih_gelap);
            cursor: pointer;
        }
        .main_image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .sub_image{
            flex: 1;
            display: flex;
            flex-direction: column;
            row-gap: 5px;
            cursor: pointer;
        }
        .sub_image img{
            border: 1px solid var(--putih_gelap);
        }

        .btn_wrap{
            display: flex;
            column-gap: 5px;
            margin-top: 10px;
        }
        .update_btn, .back_btn{
            border-style: none;
            padding: 10px;
            flex-grow: 1;
            font-size: 14px;
            text-align: center;
            color: var(--putih);
            cursor: pointer;
        }
        .update_btn{
            background-color: var(--hijau);
        }
        .back_btn{
            background-color: var(--kuning);
            text-decoration: none;
        }
        @media only screen and (max-width: 1440px){
            .sub_image img{
                width: 100px;
            }
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

    <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$update_id]);
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
    ?>
    <section class="update_product">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
            <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
            <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
            <h3>Sunting Produk</h3>
            <div class="image_container">
                <div class="main_image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                </div>
                <div class="sub_image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                    <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                    <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                </div>
            </div>
            <div class="input_wrap">
                <label for="name">Sunting Nama Produk</label>
                <input type="text" id="name" name="name" class="kolom_nama" maxlength="100" value="<?= $fetch_products['name']; ?>" required/>
            </div>
            <div class="input_wrap">
                <label for="price">Sunting Harga Produk</label>
                <input type="number" min="0" id="price" name="price" class="kolom_harga" maxlength="9999999999" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>" required/>
            </div>
            <div class="input_wrap">
                <label for="image_01">Sunting Gambar 1</label>
                <input type="file" name="image_01" id="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar">
            </div>
            <div class="input_wrap">
                <label for="image_02">Sunting Gambar 2</label>
                <input type="file" name="image_02" id="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar">
            </div>
            <div class="input_wrap">
                <label for="image_03">Sunting Gambar 3</label>
                <input type="file" name="image_03" id="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom_gambar">
            </div>
            <div class="input_wrap">
                <label for="details">Sunting Deskripsi Produk</label>
                <textarea name="details" id="details" maxlength="500" class="kolom_deskripsi" required><?= $fetch_products['details']; ?></textarea>
            </div>
            <div class="btn_wrap">
                <input type="submit" value="Perbarui" class="update_btn" name="update">
                <a href="list_of_product.php" class="back_btn">Kembali</a>
            </div>
        </form>
    </section>
    <?php
            }
        }else{
            echo '<p class="empty">no product found!</p>';
        }
    ?>

    <script>
        let mainImage = document.querySelector('.update_product .image_container .main_image img');
        let subImages = document.querySelectorAll('.update_product .image_container .sub_image img');

        subImages.forEach(images =>{
            images.onclick = () =>{
                src = images.getAttribute('src');
                mainImage.src = src;
            }
        });
    </script>
</body>
</html>
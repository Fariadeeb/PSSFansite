<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
    $slemania_id = $_SESSION['slemania_id'];
}else{
    $slemania_id = '';
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_slemanias = $conn->prepare("DELETE FROM `slemania` WHERE id = ?");
    $delete_slemanias->execute([$delete_id]);
    header('location:slemania_account.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Akun</title>
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
        body{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main{
            width: 80%;
            margin-inline: auto;
            display: flex;
            column-gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
            flex: 1;
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
        .left_content{
            flex: 3;
            
        }
        .right_content{
            flex: 1;
        }
        .left_wrap{
            padding: 30px;
            background-color: var(--putih);
            color: var(--hitam);
            
        }
        .profil_wrap{
            display: flex;
            align-items: center;
            column-gap: 20px;
        }
        
        .perbarui_btn, .logout_btn, .delete_btn{
            text-decoration: none;
            color: var(--putih);
            font-size: 14px;
            padding: 8px 20px;
        }
        .perbarui_btn{
            background-color: var(--hijau);
        }
        .logout_btn{
            background-color:var(--kuning);
        }
        .delete_btn{
            background-color: var(--merah);
        }
        .profil p{
            margin: 3px 0 12px 0;
        }
        .info_wrap{
            margin-top: 30px;
        }
        .info_pribadi_wrap{
            display: flex;
            justify-content: space-between;
            
        }
        .fname, .lname, .phone, .email{
            margin: 10px 0 5px 0;
        }
        .bio_wrap{
            margin-top: 30px;
        }
        .bio_wrap p{
            line-height: 1.4;
            text-align: justify;
            margin-top: 10px;
        }
        
        .jejak{
            padding: 30px;
            background-color: var(--putih);
            color: var(--hitam);
        }
        .jejak_likes, .jejak_komentar, .histori_keranjang, .histori_pesanan, .wishlist{
            margin: 20px 0 5px 0;
            font-weight: 700;
        }

        @media only screen and (max-width: 1280px){
            .left_content {
                flex: 5;
            }
            .right_content {
                flex: 2;
            }
        }
        .regis_login{
            display: flex;
            justify-content: center;
        }
        .regis_login a{
            padding: 15px;
            text-decoration: none;
            color: var(--hijau);
        }
        .btns_wrap{
            margin-top: 25px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <div class="left_content">
            <div class="left_wrap">
                <section class="akun_wrap">
                    <?php
                        $select_profile = $conn->prepare("SELECT * FROM `slemania` WHERE id = ?");
                        $select_profile->execute([$slemania_id]);
                        if($select_profile->rowCount() > 0){
                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="profil_wrap">
                        <i class="fas fa-user"></i>
                        <div class="profil">
                            <h3><?= $fetch_profile['name']; ?></h3>
                            <p>Slemania</p>
                        </div>
                    </div>
                </section>
                <section class="info_wrap">
                    <h3>Informasi Pribadi</h3>
                    <div class="info_pribadi_wrap">
                        <div>
                            <p class="fname">Nama Depan:</p>
                            <p><?= $fetch_profile['fname'];?></p>
                        </div>
                        <div>
                            <p class="lname">Nama Belakang:</p>
                            <p><?= $fetch_profile['lname'];?></p>
                        </div>
                        <div>
                            <p class="phone">Telepon:</p>
                            <p><?= $fetch_profile['phone'];?></p>
                        </div>
                        <div>
                            <p class="email">Email:</p>
                            <p><?= $fetch_profile['email']; ?></p>
                        </div>
                    </div>
                </section>
                <section class="bio_wrap">
                    <h3>Bio</h3>
                    <p>
                    <?= $fetch_profile['bio']; ?>
                    </p>
                </section>
                <div class="btns_wrap">
                    <a href="slemania_update.php" class="perbarui_btn">Perbarui Profil</a>
                    <a href="../components/slemania_logout.php" onclick="return confirm('keluar dari website?');" class="logout_btn">Keluar Akun</a>
                    <?php
                        $select_accounts = $conn->prepare("SELECT * FROM `slemania` WHERE id = ?");
                        $select_accounts->execute([$slemania_id]);
                        if($select_accounts->rowCount() > 0){
                            $fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a href="slemania_account.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete_btn">Hapus akun</a>
                    <?php
                        }else{
                            echo '<p>tidak ada akun tersedia!</p>';
                        }
                    ?>
                </div>
                <?php
                        }else{
                    ?>
                        <p class="name" style="text-align: center;">Silahkan register atau login terlebih dahulu!</p>
                        <div class="regis_login">
                            <a href="slemania_register.php" class="register_btn">Register</a>
                            <a href="slemania_login.php" class="login_btn">Login</a>
                        </div>
                        
                    <?php
                        }
                    ?>
            </div>
        </div>
        <div class="right_content">
            <div class="jejak" style="margin-bottom: 20px;">
                <h3>Riwayat interaksi</h3>
                <p class="jejak_likes">Likes</p>
                <p class="deskripsi_likes">
                    Tinjau likes yang telah Anda berikan di berbagai postingan fansite. 
                    <a href="slemania_likes.php">likes</a>
                </p>
                <p class="jejak_komentar">Komentar</p>
                <p class="deskripsi_komentar">
                    Tinjau komentar yang telah Anda buat di berbagai postingan fansite. 
                    <a href="slemania_commented.php">komentar</a>
                </p>
                <p class="histori_keranjang">Keranjang</p>
                <p class="deskripsi_keranjang">
                    Cek keranjang belanja merchandise Anda di sini. 
                    <a href="cart.php">keranjang</a>
                </p>
                <p class="histori_pesanan">Pemesanan</p>
                <p class="deskripsi_pesanan">
                    Cek riwayat dan status pembelian merchandise Anda di sini. 
                    <a href="orders.php">pemesanan</a>
                </p>
                <p class="wishlist">Wishlist</p>
                <p class="deskripsi_wishlist">
                    Cek wishlist produk merchandise Anda di sini. 
                    <a href="wishlist.php">wishlist</a>
                </p>
            </div>
        </div>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
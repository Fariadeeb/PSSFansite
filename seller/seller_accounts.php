<?php
include '../components/connect.php';

session_start();

$seller_id = $_SESSION['seller_id'];

if(!isset($seller_id)){
    header('location:seller_login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_sellers = $conn->prepare("DELETE FROM `sellers` WHERE id = ?");
    $delete_sellers->execute([$delete_id]);
    header('location:seller_accounts.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Akun</title>
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

        main{
            width: 83%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .akun_wrap{
            background-color: var(--putih);
            width: 80%;
            padding: 40px;
            color: var(--hitam);
        }
        
        .akun_author, .info_wrap, .bio{
            margin: 20px 0;
        }
        .akun_author .profil_wrap{
            display: flex;
            align-items: center;
            column-gap: 15px;
        }

        .profil p{
            margin: 3px 0 12px 0;
        }
        .perbarui_btn, .keluar_btn, .delete_btn{
            text-decoration: none;
            color: var(--putih);
            font-size: 14px;
            padding: 8px 20px;
        }
        .perbarui_btn{
            background-color: var(--hijau);
        }
        .keluar_btn{
            background-color:var(--kuning);
        }
        .delete_btn{
            background-color: var(--merah);
        }
        
        .info_pribadi_wrap{
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .info_pribadi_wrap p{
            margin: 5px 0;
        }
        .bio_wrap p{
            line-height: 1.4;
            text-align: justify;
            margin-top: 10px;
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
    <?php include '../components/sidebar_seller.php' ?>
    <main>
        <div class="akun_wrap">
            
            <section class="akun_author">
                <?php
                    $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
                    $select_profile->execute([$seller_id]);
                    if($select_profile->rowCount() > 0){
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="profil_wrap">
                    <i class="fas fa-user"></i>
                    <div class="profil">
                        <h3><?= $fetch_profile['name']; ?></h3>
                        <p>Seller</p>
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
                <p><?= $fetch_profile['bio']; ?></p>
            </section>

            <div class="btns_wrap">
                <a href="update_profile.php" class="perbarui_btn">Perbarui Profil</a>
                <a href="../components/seller_logout.php" onclick="return confirm('Keluar dari website?');" class="keluar_btn">Keluar Akun</a>
                <?php
                    $select_accounts = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
                    $select_accounts->execute([$seller_id]);
                    if($select_accounts->rowCount() > 0){
                        $fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="seller_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus akun ini?')" class="delete_btn">Hapus akun</a>
                <?php
                    }else{
                        echo '<p>tidak ada akun tersedia!</p>';
                    }
                ?>
            </div>
            <?php
                }else{
            ?>
                <p style="text-align: center;">Silahkan mendaftar adtau login terlebih dahulu!</p>
                <div class="regis_login">
                    <a href="seller_register.php" class="register_btn">Register</a>
                    <a href="seller_login.php" class="login_btn">Login</a>
                </div>
            <?php
                }
            ?>
            
        </div>
    </main>
</body>
</html>
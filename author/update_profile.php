<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $fname = $_POST['fname'];
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = $_POST['lname'];
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $bio = $_POST['bio'];
    $bio = filter_var($bio, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `authors` SET name = ?, email = ?, fname = ?, lname = ?, phone = ?, bio = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $fname, $lname, $phone, $bio, $author_id]);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `authors` WHERE id = ?");
    $select_old_pass->execute([$author_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_new_pass = sha1($_POST['confirm_new_pass']);
    $confirm_new_pass = filter_var($confirm_new_pass, FILTER_SANITIZE_STRING);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $message[] = 'kata sandi lama tidak sesuai!';
        }elseif($new_pass != $confirm_new_pass){
            $message[] = 'konfirmasi kata sandi tidak cocok!';
        }else{
            if($new_pass != $empty_pass){
                $update_pass = $conn->prepare("UPDATE `authors` SET password = ? WHERE id = ?");
                $update_pass->execute([$confirm_new_pass, $author_id]);
                $message[] = 'kata sandi berhasil diperbarui!';
            }else{
                $message[] = 'tolong masukkan kata sandi baru!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
            justify-content: center;
            align-items: center;
            width: 83%;
            margin: 50px 0;
        }
        form{
            width: 40%;
            padding: 30px;
            background-color: var(--putih);
        }
        .input_wrap{
            display: flex;
            flex-direction: column;
            row-gap: 8px;
            margin: 20px 0;
        }
        .kolom_nama, .kolom_fnama, .kolom_lnama, .kolom_nomor, .kolom_bio, .kolom_email, .kolom_old_pass, .kolom_new_pass, .confirm_new_pass{
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
        }

        input[type=submit]{
            width: 100%;
            padding: 12px 0;
            border: none;
            background-color: var(--hijau);
            color: var(--putih);
            cursor: pointer;
        }
        input[type=submit]:hover{
            background-color: var(--hijau_gelap);
            transition: 0.3s;
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
    <?php include '../components/sidebar_author.php' ?>
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
            $select_profile = $conn->prepare("SELECT * FROM `authors` WHERE id = ?");
            $select_profile->execute([$author_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="" method="POST">
            <h3 style="color: var(--hitam);">Perbarui Profil</h3>
            <div class="input_wrap">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="<?= $fetch_profile['name']; ?>" class="kolom_nama" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')" />
            </div>
            <div class="input_wrap">
                <label for="fname">Nama Depan</label>
                <input type="text" id="fname" name="fname" value="<?= $fetch_profile['fname']; ?>" class="kolom_fnama" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="lname">Nama Belakang</label>
                <input type="text" id="lname" name="lname" value="<?= $fetch_profile['lname']; ?>" class="kolom_lnama" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="phone">Telepon</label>
                <input type="number" id="phone" name="phone" value="<?= $fetch_profile['phone']; ?>" class="kolom_nomor" onkeypress="if(this.value.length == 12) return false;" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="bio">bio</label>
                <input type="text" id="bio" name="bio" value="<?= $fetch_profile['bio']; ?>" class="kolom_bio"/>
            </div>
            <div class="input_wrap">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $fetch_profile['email']; ?>" class="kolom_email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="old_pass">Kata Sandi Lama</label>
                <input type="password" id="old_pass" name="old_pass" class="kolom_old_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="new_pass">Kata Sandi Baru</label>
                <input type="password" id="new_pass" name="new_pass" class="kolom_new_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="confirm_new_pass">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="confirm_new_pass" name="confirm_new_pass" class="confirm_new_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <input type="submit" name="submit" value="Perbarui">
        </form>
    </section>
</body>
</html>
<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
    $slemania_id = $_SESSION['slemania_id'];
}else{
    $slemania_id = '';
};

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_slemania = $conn->prepare("SELECT * FROM `slemania` WHERE email = ? AND password = ?");
    $select_slemania->execute([$email, $pass]);
    $row = $select_slemania->fetch(PDO::FETCH_ASSOC);

    if($select_slemania->rowCount() > 0){
        $_SESSION['slemania_id'] = $row['id'];
        header('location:home.php');
   }else{
        $message[] = 'nama pengguna atau kata sandi salah!';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Slemania Login</title>
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

        section{
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }
        form{
            width: 40%;
            padding: 30px;
            background-color: var(--putih);
            color: var(--hitam);
        }

        form h3{
            font-size: 20px;
        }
        
        .input_wrap{
            display: flex;
            flex-direction: column;
            row-gap: 8px;
            margin: 20px 0;
        }

        .kolom_nama, .kolom_pass{
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
        <form action="" method="POST">
            <h3>Slemania Login</h3>
            <div class="input_wrap">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="kolom_nama" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="pass">Kata Sandi</label>
                <input type="pass" id="pass" name="pass" class="kolom_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <input type="submit" name="submit" value="Masuk">
            <p style="font-size: 14px; text-align:center; margin-top:10px; color:var(--hitam)">Belum memiliki akun? <a href="slemania_register.php" style="text-decoration: none; color:var(--hijau);">daftar disini</a></p>
        </form>
    </section>
</body>
</html>
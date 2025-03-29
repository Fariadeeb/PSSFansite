<?php
include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_author = $conn->prepare("SELECT * FROM `authors` WHERE name = ? AND password = ?");
    $select_author->execute([$name, $pass]);
    
    if($select_author->rowCount() > 0){
        $fetch_author_id = $select_author->fetch(PDO::FETCH_ASSOC);
        $_SESSION['author_id'] = $fetch_author_id['id'];
        header('location:dashboard.php');
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
    <title>Author Login</title>
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
            <h3>Author Login</h3>
            <div class="input_wrap">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" class="kolom_nama" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <div class="input_wrap">
                <label for="pass">Kata Sandi</label>
                <input type="pass" id="pass" name="pass" class="kolom_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            </div>
            <input type="submit" name="submit" value="Masuk">
        </form>
    </section>
</body>
</html>
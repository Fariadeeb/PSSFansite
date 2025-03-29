<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
};

if(isset($_POST['publish'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $status = 'active';
    
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND author_id = ?");
    $select_image->execute([$image, $author_id]);

    if(isset($image)){
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'nama gambar terulang!';
        }elseif($image_size > 2000000){
            $message[] = 'ukuran gambar terlalu besar!';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);
        }
        }else{
            $image = '';
        }
        
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'tolong ganti nama gambar anda!';
        }else{
            $insert_post = $conn->prepare("INSERT INTO `posts`(author_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$author_id, $name, $title, $content, $category, $image, $status]);
            $message[] = 'Postingan berhasil diunggah!';
        }
}


if(isset($_POST['draft'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $status = 'deactive';
    
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND author_id = ?");
    $select_image->execute([$image, $author_id]);

    if(isset($image)){
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'nama gambar terulang!';
        }elseif($image_size > 2000000){
            $message[] = 'ukuran gambar terlalu besar!';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);
        }
        }else{
            $image = '';
        }
        
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'mohon ganti nama gambar anda!';
        }else{
            $insert_post = $conn->prepare("INSERT INTO `posts`(author_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$author_id, $name, $title, $content, $category, $image, $status]);
            $message[] = 'Postingan berhasil disimpan ke draf';
        }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Postingan</title>
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
        .kolom_judul, .kolom_kategori, .kolom_gambar{
            padding: 8px 10px;
            background-color: var(--putih_gelap);
            border: none;
        }
        .kolom_konten{
            height: 15rem;
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
            cursor: pointer;
        }
        .publish_saves_btn{
            display: flex;
            column-gap: 5px;
        }
        .publish_btn{
            background-color: var(--hijau);
        }
        .saves_btn{
            background-color: var(--kuning);
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
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Tambah Postingan</h3>
            <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
            <div class="input_wrap">
                <label for="title">Judul Postingan</label>
                <input type="text" id="title" name="title" class="kolom_judul" maxlength="100"/>
            </div>
            <div class="input_wrap">
                <label for="content">Konten Postingan</label>
                <textarea id="content" name="content" class="kolom_konten" maxlength="1000"></textarea>
            </div>
            <div class="input_wrap">
                <label for="category">Kategori Postingan</label>
                <select name="category" class="kolom_kategori" required>
                    <option value="" selected disabled> Pilih Kategori </option>
                    <option value="sejarah">sejarah</option>
                    <option value="performa tim">performa tim</option>
                    <option value="formasi">formasi</option>
                    <option value="strategi">strategi</option>
                    <option value="prediksi skor">prediksi skor</option>
                    <option value="rumor transfer">rumor transfer</option>
                    <option value="kontrak pemain">kontrak pemain</option>
                    <option value="statistik pemain">statistik pemain</option>
                    <option value="tradisi klub">tradisi klub</option>
                </select>
            </div>
            <div class="input_wrap">
                <label for="image">Gambar</label>
                <input type="file" id="image" name="image" class="kolom_gambar" accept="image/jpg, image/jpeg, image/png, image/webp">
            </div>
            <div class="publish_saves_btn">
                <input type="submit" value="Tambah Postingan" name="publish" class="publish_btn">
                <input type="submit" value="Simpan ke Draf" name="draft" class="saves_btn">
            </div>
        </form>
    </section>
</body>
</html>
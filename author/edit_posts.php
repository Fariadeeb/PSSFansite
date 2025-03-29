<?php
include '../components/connect.php';

session_start();

$author_id = $_SESSION['author_id'];

if(!isset($author_id)){
    header('location:author_login.php');
}

if (!isset($_GET['post_id'])) {
    header('location:list_of_post.php');
} else {
    $get_id = $_GET['post_id'];
}

if(isset($_POST['save'])){
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    
    $update_post = $conn->prepare("UPDATE `posts` SET title = ?, content = ?, category = ?, status = ? WHERE id = ?");
    $update_post->execute([$title, $content, $category, $status, $get_id]);

    $message[] = 'postingan berhasil diperbarui';

    $old_image = $_POST['old_image'];
    $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND author_id = ?");
    $select_image->execute([$image, $author_id]);

    if(!empty($image)){
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'mohon ganti nama gambar anda';
        }elseif($image_size > 2000000){
            $message[] = 'ukuran gambar terlalu besar!';
        }else{
            $update_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $get_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if($old_image != $image AND $old_image != ''){
                unlink('../uploaded_img/'.$old_image);
            } 
            $message[] = 'gambar berhasil diperbarui';
        }
    }else{
        $image = '';
    }
}

if(isset($_POST['delete'])){
    $delete_id = $_POST['post_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $select_image = $conn ->prepare("SELECT * FROM `posts` WHERE id = ?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
        unlink('../uploaded_img/'.$fetch_image['image']);
    }
    $delete_comments = $conn ->prepare("DELETE FROM `comments` WHERE post_id = ?");
    $delete_comments->execute([$delete_id]);
    $delete_likes = $conn ->prepare("DELETE FROM `likes` WHERE post_id = ?");
    $delete_likes->execute([$delete_id]);
    $delete_post = $conn ->prepare("DELETE FROM `posts` WHERE id = ?");
    $delete_post->execute([$delete_id]);
    $message[] = 'postingan berhasil dihapus';
}

if(isset($_POST['delete_image'])){

    $empty_image = '';
    
    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
       unlink('../uploaded_img/'.$fetch_image['image']);
    }
    $unset_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
    $unset_image->execute([$empty_image, $get_id]);
    $message[] = 'gambar berhasil dihapus!';
 
 }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Posts Page</title>
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
        .kolom_judul, .kolom_kategori, .kolom_gambar, .kolom_status{
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
        .inline_delete_btn{
            width: 100%;
            padding: 12px 0;
            border: none;
            color: var(--putih);
            cursor: pointer;
            background-color: var(--merah);
        }
        .btn_wrap{
            display: flex;
            column-gap: 5px;
        }
        .saves_btn{
            background-color: var(--hijau);
            width: 100%;
            padding: 10px 0;
            border: none;
            color: var(--putih);
            cursor: pointer;
            font-size: 14px;
        }
        .go_back_btn{
            background-color: var(--kuning);
            width: 100%;
            padding: 10px 0;
            border: none;
            color: var(--putih);
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
        }
        .delete_btn{
            background-color: var(--merah);
            width: 100%;
            padding: 10px 0;
            border: none;
            color: var(--putih);
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
            // $post_id = $_GET['id'];
            $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ? AND author_id = ?");
            $select_posts->execute([$get_id ,$author_id]);
            if($select_posts->rowCount() > 0){
                while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Sunting Postingan</h3>
            <input type="hidden" name="old_image" value="<?= $fetch_posts['image']; ?>">
            <input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
            <div class="input_wrap">
                <label for="status">Status</label>
                <select name="status" class="kolom_status" required>
                    <option value="<?= $fetch_posts['status']; ?>" selected><?= $fetch_posts['status']; ?></option>
                    <option value="active">active</option>
                    <option value="deactive">deactive</option>
                </select>
            </div>
            <div class="input_wrap">
                <label for="title">Judul Postingan</label>
                <input type="text" id="title" name="title" class="kolom_judul" maxlength="100" value="<?= $fetch_posts['title']; ?>"/>
            </div>
            <div class="input_wrap">
                <label for="content">Konten Postingan</label>
                <textarea id="content" name="content" class="kolom_konten" maxlength="1000"><?= $fetch_posts['content']; ?></textarea>
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
                <?php if($fetch_posts['image'] != ''){ ?>
                    <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
                    <input type="submit" value="Hapus Gambar" class="inline_delete_btn" name="delete_image">
                <?php } ?>
            </div>
            <div class="btn_wrap">
                <a href="list_of_post.php" class="go_back_btn">Kembali</a>
                <input type="submit" value="Simpan Postingan" name="save" class="saves_btn">
                <button type="submit" name="delete" class="delete_btn" onclick="return confirm('Hapus postingan berikut?');">Hapus Postingan</button>
            </div>
        </form>
        <?php
            }
        }else{
            echo '<p>Belum ada postingan!</p>';
        }
        ?>
    </section>
</body>
</html>
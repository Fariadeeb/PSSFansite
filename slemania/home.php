<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['slemania_id'])){
    $slemania_id = $_SESSION['slemania_id'];
}else{
    $slemania_id = '';
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Beranda</title>
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
        main{
            width: 80%;
            margin-inline: auto;
        }
        .welcome {
            background-image: url(../img/Hero_img.png);
            background-size: cover;
            background-position: center;
            height: 500px;
            text-align: center;
            color: var(--putih);
            font-size: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hl_forum, .hl_wiki, .hl_merch{
            color: var(--putih);
            display: flex;
            align-items: center;
            column-gap: 30px;
            padding: 50px 40px;
            background-color: var(--hitam);
        }
        .hl_wiki, .hl_merch{
            background-color: var(--putih);
            color: var(--hitam);
            
        }
        .img_wrap, .forum_teks, .wiki_teks, .merch_teks{
            flex: 1;
        }
        .img_wrap img{
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .forum_deskripsi, .wiki_deskripsi, .merch_deskripsi{
            line-height: 1.5;
            text-align: justify;
            margin-top: 20px;
        }
        .forum_wrap, .wiki_wrap, .merch_wrap{
            padding: 50px 40px;
            background-color: var(--putih);
            color: var(--hitam);
        }
        .forum_judul, .wiki_judul, .merch_judul{
            display: flex;
            align-items: center;
        }
        .forum_judul  h2, .wiki_judul  h2, .merch_judul  h2{
            flex: 1;
        }
        .forum_judul  p, .wiki_judul  p, .merch_judul  p{
            flex: 1;
            text-align: justify;
            
        }
        .forum_card_wrap, .wiki_card_wrap, .merch_card_wrap {
            display: flex;
            column-gap: 15px;
            margin-top: 20px;
        }
        .card_img, .card_img_wiki{
            width: 100%;
        }
        .forum_card, .merch_card{
            width: 25%;
        }
        .forum_card p, .merch_card p{
            text-align: justify;
            margin-top: 5px;
        }
        .forum_card p a, .merch_card p a{
            text-decoration: none;
            color: var(--hitam);
        }
        .btn_wrap{
            text-align: right;
            margin-top: 40px;
        }
        .selengkapnya_btn{
            font-size: 14px;
            padding: 8px 20px;
            text-decoration: none;
            background-color: var(--kuning);
            color: var(--putih);
        }
        .merch_card{
            width: 25%;
        }
        .harga{
            margin-top: 5px;
        }
        .faq_wrap{
            padding: 50px 40px;
            background-color: var(--putih);
            color: var(--hitam);
            display: flex;
            column-gap: 10px;
        }
        .faq_judul, .faq_konten{
            flex: 1;
        }
        .faq_judul p{
            line-height: 1.3;
            margin-top: 10px;
        }
        .faq_item{
            padding: 20px 0;
            border-style: solid none solid none;
            border-width: 1px 0 0 0;
            cursor: pointer;
        }
        .faq_answer {
            display: none;
            margin-top: 15px;
            text-align: justify;
            line-height: 1.4;
        }
        footer{
            padding: 50px 0;
            background-color: var(--hijau);
            color: var(--putih);
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin-inline: auto;
            
        }
        .footer_right, .footer_left{
            width: 30%;
            padding: 0 40px;
        }
        .footer_left p{
            line-height: 1.3;
            margin-top: 10px;
        }
        .back_to_top{
            display: flex;
            justify-content: end;
            text-decoration: none;
            color: var(--putih);
            column-gap: 10px;
        }
        .wiki_card_wrap div{
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wiki_card_sejarah{
            background: url(../img/wiki_img_sejarah.png) center/cover no-repeat;
        }
        .wiki_card_prestasi{
            background: url(../img/wiki_img_prestasi.png) center/cover no-repeat;
        }
        .wiki_card_pelatih{
            background: url(../img/wiki_img_pelatih.png) center/cover no-repeat;
        }
        .wiki_card_pemain{
            background: url(../img/wiki_img_pemain.png) center/cover no-repeat;
        }
        .wiki_card_apparel{
            background: url(../img/wiki_img_apparel.png) center/cover no-repeat;
        }
        
        .wiki_card_wrap div:hover {
            filter: brightness(50%);        
            transition: .5s;    
        }
        .wiki_title{
            text-decoration: none;
            color:var(--putih);
            font-size: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <section class="welcome">
            <h1 class="welcome_title">
                Selamat Datang di Fansite Klub Sepakbola PSS Sleman
            </h1>
        </section>
        <section class="hl_forum">
            <div class="img_wrap">
                <img src="../img/forum.jpg" alt="" />
            </div>
            <div class="forum_teks">
                <h2>Forum Diskusi</h2>
                <p class="forum_deskripsi">
                Forum ini adalah ruang untuk semua suporter berbagi pandangan, analisis
                pertandingan, hingga rumor transfer. Sampaikan pendapatmu, ajukan
                pertanyaan, dan diskusikan apa pun yang berkaitan dengan klub. Mari
                bangun komunitas yang solid dan saling mendukung!
                </p>
            </div>
        </section>
        <section class="hl_wiki" style="flex-direction: row-reverse;">
            <div class="img_wrap">
                <img src="../img/wiki.jpg" alt="" />
            </div>
            <div class="wiki_teks">
                <h2>Wikipedia Klub</h2>
                <p class="wiki_deskripsi">
                    Temukan kisah perjalanan klub PSS Sleman sejak awal berdiri hingga meraih berbagai gelar bergengsi.
                    Dapatkan informasi lengkap tentang latar belakang, pemain legendaris, hingga perkembangan
                    terkini yang membuat kita bangga mendukung tim ini.
                </p>
            </div>
        </section>
        <section class="hl_merch">
            <div class="img_wrap">
                <img src="../img/merch_home.jpg" alt="" />
            </div>
            <div class="merch_teks">
                <h2>Merchandise</h2>
                <p class="merch_deskripsi">
                    Dukung klub ini dengan bangga melalui koleksi merchandise resmi. Mulai
                    dari jersey, kaus, hoodie, hingga aksesori keren yang siap melengkapi gaya
                    harianmu. Tunjukkan identitas sebagai suporter sejati di setiap
                    kesempatan!
                </p>
            </div>
        </section>
        <section class="forum_wrap">
            <div class="forum_judul">
                <h2>Sorortan Forum</h2>
                <p>Bergabunglah dengan ribuan suporter untuk membahas strategi tim, performa pemain, dan rumor transfer terkini!</p>
            </div>
            <div class="forum_card_wrap">
                <?php
                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? LIMIT 4 ");
                $select_posts->execute(['active']);
                if($select_posts->rowCount() > 0){
                    while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                        $post_id = $fetch_posts['id'];
                ?>
                <div class="forum_card">
                    <?php
                        if($fetch_posts['image'] != ''){  
                    ?>
                    <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" alt="" class="card_img">
                    <?php
                        }
                    ?>
                    <p style="text-transform: capitalize;"><a href="read_post.php?post_id=<?= $post_id; ?>"><?= $fetch_posts['title']; ?></a> </p>
                </div>
                <?php
                    }
                }else{
                    echo '<p>Postingan tidak tersedia</p>';
                }
                ?>
            </div>
            <div class="btn_wrap">
                <a href="forum.php" class="selengkapnya_btn">Selengkapnya</a>
            </div>
        </section>
        <section class="wiki_wrap">
            <div class="wiki_judul">
                <h2>Sorotan Wikipedia</h2>
                <p>Jelajahi sejarah PSS Sleman melalui kisah legendaris, prestasi, pemain, dan momen bersejarah!</p>
            </div>
            <div class="wiki_card_wrap">
                <div class="wiki_card_sejarah">
                    <a href="wikipedia.php" class="wiki_title">
                        Sejarah
                    </a>
                </div>
                <div class="wiki_card_prestasi">
                    <a href="wikipedia.php" class="wiki_title">
                        Prestasi
                    </a>
                </div>
                <div class="wiki_card_pelatih">
                    <a href="wikipedia.php" class="wiki_title">
                        Pelatih & Staff
                    </a>
                </div>
                <div class="wiki_card_pemain">
                    <a href="wikipedia.php" class="wiki_title">
                        Pemain
                    </a>
                </div>
                <div class="wiki_card_apparel">
                    <a href="wikipedia.php" class="wiki_title">
                        Apparel
                    </a>
                </div>
            </div>
            <div class="btn_wrap">
                <a href="wikipedia.php" class="selengkapnya_btn">Selengkapnya</a>
            </div>
        </section>
        <section class="merch_wrap">
            <div class="merch_judul">
                <h2>Sorotan Merchandise</h2>
                <p>Tunjukkan kebanggaan Anda dengan jersey, syal, topi, dan aksesori eksklusif PSS Sleman!</p>
            </div>
            <div class="merch_card_wrap">
                <?php
                $select_product = $conn->prepare("SELECT * FROM `products` LIMIT 4 ");
                $select_product->execute();
                if($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="merch_card">
                    <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="" class="card_img">
                    <p style="text-transform: capitalize;"><a href="detail_product.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['name']; ?></a> </p>
                    <h3 style="margin-top: 5px;">Rp<?= $fetch_product['price']; ?></h3>
                </div>
                <?php
                    }
                }else{
                    echo '<p>Produk tidak tersedia</p>';
                }
                ?>
            </div>
            <div class="btn_wrap">
                <a href="merch.php" class="selengkapnya_btn">Selengkapnya</a>
            </div>
        </section>
        <section class="faq_wrap">
            <div class="faq_judul">
                <h2>FAQ</h2>
                <p>Berikut beberapa pertanyaan yang sering ditanyakan oleh pengguna</p>
            </div>
            <div class="faq_konten">
                <div class="faq_item" >
                    <div class="faq_question">Tentang apa fansite ini?</div>
                    <div class="faq_answer">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos dolorum quam consequatur provident velit accusamus aliquam placeat culpa alias eius odit, eos dicta pariatur. Magni perferendis non repudiandae cumque eos.</div>
                </div>
                <div class="faq_item" >
                    <div class="faq_question">Bagaimana cara bergabung dengan forum?</div>
                    <div class="faq_answer">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo quos necessitatibus, eos illo optio beatae dolores debitis maxime quam expedita ad, animi aliquam ut minima modi sapiente voluptates! Ullam, porro!</div>
                </div>
                <div class="faq_item" >
                    <div class="faq_question">Apakah merchandise di sini resmi?</div>
                    <div class="faq_answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quasi aut dolor optio repellendus fuga sint culpa. Vero veniam reprehenderit sit culpa provident eaque. Tempore incidunt ut nihil illo similique repudiandae!</div>
                </div>
                <div class="faq_item" >
                    <div class="faq_question">Apakah dapat memesan tiket pertandingan melalui kanal ini?</div>
                    <div class="faq_answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quasi aut dolor optio repellendus fuga sint culpa. Vero veniam reprehenderit sit culpa provident eaque. Tempore incidunt ut nihil illo similique repudiandae!</div>
                </div>
                <div class="faq_item" style="border-width: 1px 0 1px 0;">
                    <div class="faq_question">Bagaimana cara menghubungi pelayanan pelanggan?</div>
                    <div class="faq_answer">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse provident similique placeat necessitatibus, deserunt quia libero minima totam assumenda obcaecati commodi autem eaque est. Magni, corporis incidunt.</div>
                </div>
            </div>
        </section>
        
    </main>
    <footer>
        <div class="footer_left">
            <h3>PSSFansite</h3>
            <p>Terima kasih telah menjadi bagian dari Slemania. Mari terus mendukung dan merayakan setiap momen kebanggaan PSS Sleman!</p>
        </div>
        <div class="footer_right">
            <a href="#" class="back_to_top">
                <i class="fa-solid fa-arrow-up"></i>
                <p>Kembali Ke atas</p>
            </a>
        </div>
    </footer>
    <script>
        document.querySelectorAll(".faq_question").forEach(question => {
            question.addEventListener("click", () => {
                const answer = question.nextElementSibling;
                answer.style.display = answer.style.display === "block" ? "none" : "block";
            });
        });
    </script>
</body>
</html>
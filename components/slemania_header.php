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
    header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
        background-color: var(--hijau);
        width: 80%;
        margin-inline: auto;
        color: var(--putih);
    }
    .brand{
        margin-left: 20px;
    }
    nav{
        margin-right: 20px;
        display: flex;
        column-gap: 30px;
    }
    .nav_link{
        text-decoration: none;
        color: var(--putih_gelap);
    }
    .nav_link:hover{
        color: var(--kuning);
        transition: 0.5s;
        text-decoration:underline;
    }
</style>
<header>
    <div class="brand">
        <h2>PSSFansite</h2>
    </div>
    <nav>
        <a href="../slemania/home.php" class="nav_link">Beranda</a>
        <a href="../slemania/wikipedia.php" class="nav_link">Wikipedia</a>
        <a href="../slemania/forum.php" class="nav_link">Forum</a>
        <a href="../slemania/merch.php" class="nav_link">Merchandise</a>
        <a href="../slemania/slemania_account.php" class="nav_link">Akun</a>
        <!-- <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div> -->
    </nav>
</header>
<div class="sidebar">
    <h2>PSSFansite</h2>
    <ul>
        <li>
            <a href="../seller/dashboard.php" onclick="showPage('dashboard')">
                <i class="fa-solid fa-table-cells-large"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="../seller/ordered_product.php" onclick="showPage('pesananMasuk')">
                <i class="fa-regular fa-square-check"></i> Pesanan Masuk
            </a>
        </li>
        <li>
            <a href="../seller/add_product.php" onclick="showPage('tambahProduk')">
                <i class="fa-regular fa-square-plus"></i> Tambah Produk
            </a>
        </li>
        <li>
            <a href="../seller/list_of_product.php" onclick="showPage('daftarPostingan')">
                <i class="fa-solid fa-list-ul"></i> Daftar Produk
            </a>
        </li>
        <li>
            <a href="../seller/seller_accounts.php" onclick="showPage('profilAkun')">
                <i class="fa-regular fa-user"></i> 
                <?php
                    $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
                    $select_profile->execute([$seller_id]);
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                Profil <?= $fetch_profile['name']; ?>
            </a>
        </li>
        <li class="logout_btn">
            <a href="../components/seller_logout.php" onclick="return confirm('Keluar dari website?');" >
                <i class="fas fa-right-from-bracket"></i> Keluar
            </a>
        </li>
    </ul>
    <div class="login_register_btn">
        <a href="../seller/seller_login.php">Masuk</a>
        <a href="../seller/seller_register.php">Daftar</a>
    </div>
</div>
<style>
    .sidebar {
        background-color: var(--putih);
        color: var(--putih);
        width: 15%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
        color: var(--hijau);
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        display: flex;
        margin: 20px 0;
        align-items: center;
    }

    .sidebar ul li:hover {
        background-color: var(--hijau);
    }

    .sidebar ul li.logout_btn:hover{
        background-color: #ee4e4e;
    }

    .sidebar ul li i {
        padding: 10px 0px 10px 10px;
    }

    .sidebar ul li a {
        color: #b5b5b5;
        text-decoration: none;
        font-size: 18px;
        display: block;
        padding: 10px;
        transition: background 0.3s;
    }

    .sidebar ul li a:hover {
        color: var(--putih);
    }

    .sidebar .login_register_btn{
        display: flex;
        flex-direction: column;
        text-align: center;
        row-gap: 5px;
    }

    .sidebar .login_register_btn a{
        background-color: var(--kuning);
        padding: 10px;
        text-decoration: none;
        color: var(--putih);
        font-weight: 500;
    }

    .sidebar .login_register_btn a:hover{
        background-color: #e2be0a;
    }

    

    @media only screen and (max-width: 1440px){
        .sidebar{
            width: 17%;
        }
        .sidebar ul li a{
            font-size: 16px;
        }
        .sidebar ul li i {
            font-size: 16px;
        }
        .sidebar .login_register_btn a{
            font-size: 14px;
        }
    }
</style>
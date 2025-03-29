<div class="sidebar">
<h2>PSSFansite</h2>
<div class="user">
</div>
<ul>
    <li>
        <a href="../author/dashboard.php" onclick="showPage('dashboard')">
            <i class="fa-solid fa-table-cells-large"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="../author/add_posts.php" onclick="showPage('tambahPostingan')">
            <i class="fa-regular fa-square-plus"></i> Tambah Postingan
        </a>
    </li>
    <li>
        <a href="../author/list_of_post.php" onclick="showPage('daftarPostingan')">
            <i class="fa-solid fa-list-ul"></i> Daftar Postingan
        </a>
    </li>
    <li>
        <a href="../author/author_accounts.php" onclick="showPage('profilAkun')">
            <i class="fa-regular fa-user"></i> 
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `authors` WHERE id = ?");
                $select_profile->execute([$author_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            Profil <?= $fetch_profile['name']; ?>
        </a>
    </li>
    <li class="logout_btn">
        <a href="../components/author_logout.php" onclick="return confirm('logout from the website?');" >
            <i class="fas fa-right-from-bracket"></i> logout
        </a>
    </li>
</ul>
<div class="login_register_btn">
    <a href="../author/author_login.php" class="option-btn">Masuk</a>
    <a href="../author/author_register.php" class="option-btn">Daftar</a>
</div>
</div>

<style>
.user p{
    color: var(--hitam);
}

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
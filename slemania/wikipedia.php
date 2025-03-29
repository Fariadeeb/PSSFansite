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
    <title>Wikipedia</title>
    <style>
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
        main, footer{
            width: 80%;
            margin-inline: auto;
        }
        footer{
            display: flex;
            column-gap: 10px;
            background-color: var(--hijau);
            justify-content: center;
            padding: 10px 0;
            color: var(--putih);
            font-size: 14px;
        }
        .welcome {
            background-image: url(../img/heroimg_wiki.png);
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
        .content{
            display: flex;
            margin: 20px 0;
            column-gap: 30px;
        }
        .left_content {
            flex: 3;
        }
        .right_content {
            flex: 1;
        }
        .nav_mini{
            justify-content: space-around;
            padding: 15px;
            background-color: var(--putih);
        }
        .nav_item{
            text-decoration: none;
            color: var(--hitam);
        }
        .wiki_text{
            color: var(--hitam);
        }
        article{
            margin: 40px 0;
        }
        article p {
            text-indent: 50px;
            margin-top: 8px;
            line-height: 1.5;
            text-align: justify;
        }
        .infobox{
            padding: 20px;
            background-color: var(--putih);
        }
        .infobox img{
            width: 100%;
        }
        .teks_content {
            display: flex;
            justify-content: space-between;
            box-sizing: border-box;
            margin: 10px 0;
            font-size: 14px;
        }
        .teks_content p.left {
            color: var(--hijau);
        }
        @media only screen and (max-width: 1280px){
            .left_content {
                flex: 5;
            }
            .right_content {
                flex: 2;
            }
        }
        li{
            margin: 10px 0;
        }
        .prestasi_kanan h4, .prestasi_kiri h4{
            margin: 30px 0 10px 0;
        }
        table {
            font-family: "Montserrat", sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <?php include '../components/slemania_header.php'; ?>
    <main>
        <section class="welcome">
            <h1 class="welcome_title">Wikipedia Klub</h1>
        </section>
        <section class="content">
            <div class="left_content">
                <nav class="nav_mini">
                    <a class="nav_item" href="#sejarah">Sejarah</a>
                    <a class="nav_item" href="#prestasi">Prestasi</a>
                    <a class="nav_item" href="#pemain">Pemain</a>
                    <a class="nav_item" href="#pelatihnstaff">Pelatih dan Staff</a>
                    <a class="nav_item" href="#apparel">Apparel</a>
                </nav>
                <div class="wiki_text">
                    <article id="awalan">
                        <h3>Awalan</h3>
                        <p>
                            Perserikatan Sepak Bola Sleman (PSS) atau disebut PSS Sleman merupakan
                            klub sepak bola profesional Indonesia yang berbasis di Kabupaten Sleman,
                            Yogyakarta. PSS didirikan pada tanggal 20 Mei 1976. PSS memliliki julukan
                            Super Elja (Super Elang Jawa), selain itu PSS juga memiliki julukan Laskar
                            Sembada merujuk pada awal didirikannya sebagai tim perserikatan dari
                            Kabupaten Sleman. PSS berkompetisi di Liga 1 Indonesia.
                        </p>
                    </article>
                    <article id="sejarah">
                        <h3>Sejarah</h3>
                        <p>
                            Perserikatan Sepak bola Sleman (PSS) didirikan pada Kamis Kliwon tanggal
                            20 Mei 1976 semasa periode kepemimpinan Bupati Drs. KRT. Suyoto
                            Projosuyoto. Lima tokoh sentral kelahiran PSS adalah H. Suryo Saryono,
                            Sugiarto SY, Subardi, Sudarsono KH, dan Hartadi.[2] Lahirnya PSS
                            dilatarbelakangi bahwa pada waktu itu di Daerah Istimewa Yogyakarta (DIY)
                            baru ada dua perserikatan yaitu PSIM Yogyakarta dan Persiba Bantul. Waktu
                            berdirinya PSS hampir bersamaan dengan saat berdirinya Persikup Kulon
                            Progo dan Persig Gunungkidul. Saat itu, selain di Kota Yogyakarta, potensi
                            sepak bola di empat daerah kabupaten tidak terpantau dan kurang terkelola
                            dengan baik. Padahal beberapa daerah di Kabupaten Sleman, seperti
                            Prambanan, Sleman dan Kalasan, Sleman sejak dulu sudah memiliki tim sepak
                            bola yang tangguh, yang ditandai dengan hadirnya beberapa tim luar daerah
                            yang mengadakan pertandingan uji coba dengan tim di kawasan tersebut.
                            Meskipun klub-klub sepak bola di Kabupaten Sleman telah ada dan tumbuh,
                            tetapi belum terorganisasi dengan baik karena di Kabupaten Sleman belum
                            ada perserikatan. Hal ini berdampak terhadap kelancaran klub-klub sepak
                            bola di Kabupaten Sleman dalam mengadakan kompetisi sehingga banyak pemain
                            dari Kabupaten Sleman yang bergabung ke klub-klub sepak bola di Kota
                            Yogyakarta dan Kabupaten Bantul.
                        </p>
                    </article>
                    <article id="prestasi">
                        <h3 style="margin-bottom: 10px;">Prestasi</h3>
                        <hr>
                        <div class="prestasi_wrap" style="display: flex; ">
                            <div class="prestasi_kanan" style="flex: 1;">
                                <h4>Perserikatan</h4>
                                <ul>
                                    <li>1979 Divisi II DIY</li>
                                    <li>1980 Divisi II DIY peringkat ke-2</li>
                                    <li>1983 Divisi II DIY peringkat ke-1</li>
                                    <li>1985 Divisi II DIY peringkat ke-1</li>
                                    <li>1986 Divisi II DIY peringkat ke-1</li>
                                    <li>1986/1987 Divisi II DIY Peringkat ke-1</li>
                                    <li>1987/1988 Divisi II DIY Peringkat ke-1</li>
                                    <li>1989/1990 Divisi II DIY Peringkat ke-1</li>
                                    <li>1990/1991 Divisi IIA Jateng DIY Peringkat ke-6</li>
                                    <li>1991/1992 Divisi II DIY Peringkat ke-1</li>
                                    <li>1993/1994 Divisi II Nasional Delapan Besar (Juara Divisi II DIY)</li>
                                </ul>
                                <h4>Piala Indonesia</h4>
                                <ul>
                                    <li>2004/2005 Semifinalis</li>
                                    <li>2006/2007 32 Besar</li>
                                    <li>2008/2009 52 Besar</li>
                                    <li>2011/2012 40 Besar</li>
                                    <li>2018/2019 16 Besar</li>
                                </ul>
                                <h4>Piala Soeratin U17</h4>
                                <ul>
                                    <li>2001 Peringkat ke-3</li>
                                    <li>2002 Peringkat ke-4</li>
                                    <li>2008 32 Besar</li>
                                    <li>2014 Juara Zona DIY</li>
                                    <li>2017 Peringkat ke-3</li>
                                    <li>2019 Juara Zona DIY</li>
                                    <li>2020 Juara 3 Tingkat Nasional</li>
                                </ul>
                                <h4>Piala Presiden</h4>
                                <ul>
                                    <li>2017 Babak Grup</li>
                                    <li>2019 Babak Grup</li>
                                    <li>2022 Semifinal</li>
                                </ul>
                            </div>
                            <div class="prestasi_kiri" style="flex: 1;">
                                <h4>Liga Indonesia</h4>
                                <ul>
                                    <li>1994/1995 Divisi Dua Liga Indonesia 16 Besar Nasional</li>
                                    <li>1995/1996 Divisi Dua Liga Indonesia Promosi ke Divisi Satu Liga Indonesia (Playoff Divisi Satu Liga Indonesia)</li>
                                    <li>1996/1997 Divisi Satu Liga Indonesia 10 besar (Peringkat ke-3 Grup A)</li>
                                    <li>1997/1998 Divisi Satu Liga Indonesia - Kompetisi dihentikan</li>
                                    <li>1998/1999 Divisi Satu Liga Indonesia Peringkat ke-4 Grup II</li>
                                    <li>1999/2000 Divisi Satu Liga Indonesia Promosi ke Divisi Utama (Peringkat ke-2)</li>
                                    <li>2001 Divisi Utama Peringkat ke-10 Grup Timur</li>
                                    <li>2002 Divisi Utama Peringkat ke-7 Grup Timur</li>
                                    <li>2003 Divisi Utama Peringkat ke-4</li>
                                    <li>2004 Divisi Utama Peringkat ke-4</li>
                                    <li>2005 Divisi Utama Peringkat ke-7 Wilayah I</li>
                                    <li>2006 Divisi Utama</li>
                                    <li>2007 Divisi Utama Peringkat ke-12 Wilayah Barat</li>
                                    <li>2008/2009 Divisi Utama Peringkat ke-8 Wilayah Timur</li>
                                    <li>2009/2010 Divisi Utama Peringkat ke-10 Grup 3</li>
                                    <li>2010/2011 Divisi Utama Peringkat ke-10 Grup 3</li>
                                    <li>2011/2012 Divisi Utama Peringkat ke-7 Grup 2</li>
                                    <li>2013 Divisi Utama Juara Umum</li>
                                    <li>2014 Divisi Utama 8 Besar</li>
                                    <li>2016 Indonesia Soccer Championship B Runner Up</li>
                                    <li>2017 Liga 2 16 Besar</li>
                                    <li>2018 Liga 2 Juara 1</li>
                                    <li>2019 Liga 1 Peringkat 8</li>
                                    <li>2020 Liga 1 Peringkat 16 </li>
                                    <li>2021/2022 Liga 1 Peringkat 13</li>
                                    <li>2022/2023 Liga 1 Peringkat 16</li>
                                </ul>
                                
                                <h4>Piala Menpora</h4>
                                <ul>
                                    <li>2021 Juara 3</li>
                                </ul>
                            </div>
                        </div>
                    </article>
                    <article id="pemain">
                        <h3 style="margin-bottom: 10px;">Pemain</h3>
                        
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Posisi</th>
                                <th>Nama</th>
                                <th>Negara</th>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Goalkeeper</td>
                                <td>Alan</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>32</td>
                                <td>Goalkeeper</td>
                                <td>Ega Rizky</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>31</td>
                                <td>Goalkeeper</td>
                                <td>Safaat Romadhona</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>57</td>
                                <td>Goalkeeper</td>
                                <td>Fidelis Davin</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Centre-back</td>
                                <td>Cleberson</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>Centre-back</td>
                                <td>Fachruddin Aryanto</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>78</td>
                                <td>Centre-back</td>
                                <td>Ifan Nanda</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Centre-back</td>
                                <td>Dia Syayid</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>41</td>
                                <td>Centre-back</td>
                                <td>Nur Aziz</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>44</td>
                                <td>Centre-back</td>
                                <td>Joseph Kurniawan</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>96</td>
                                <td>Left-back</td>
                                <td>Abduh Lestaluhu</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Left-back</td>
                                <td>Kevin Gomes</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>69</td>
                                <td>Left-back</td>
                                <td>Bima Zawawi</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Right-back</td>
                                <td>Phil Ofosu-Ayeh</td>
                                <td>Ghana</td>
                            </tr>
                            <tr>
                                <td>38</td>
                                <td>Right-back</td>
                                <td>Nyoman Ansanay</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>87</td>
                                <td>Right-back</td>
                                <td>Achmad Figo</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>25</td>
                                <td>Right-back</td>
                                <td>Gilang Oktavana</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Right-back</td>
                                <td>Alfiansyah</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>74</td>
                                <td>Right-back</td>
                                <td>Fadel Ahmad</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>33</td>
                                <td>Defensive Midfield</td>
                                <td>Wahyu Hamisi</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>55</td>
                                <td>Defensive Midfield</td>
                                <td>Jayus Hariono</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Defensive Midfield</td>
                                <td>Betinho</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>36</td>
                                <td>Defensive Midfield</td>
                                <td>Relosa Rivan</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>77</td>
                                <td>Central Midfield</td>
                                <td>Paulo Sitanggang</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>23</td>
                                <td>Central Midfield</td>
                                <td>Kim Kurniawan</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Central Midfield</td>
                                <td>Diop Wamu</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>26</td>
                                <td>Central Midfield</td>
                                <td>Farrel Arda</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>Attacking Midfield</td>
                                <td>Zidan Arrosyid</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>24</td>
                                <td>Left Winger</td>
                                <td>Nicolao Cardoso</td>
                                <td>Italia</td>
                            </tr>
                            <tr>
                                <td>76</td>
                                <td>Left Winger</td>
                                <td>Dominikus Dion</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>72</td>
                                <td>Left Winger</td>
                                <td>Claudio Mutzi</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Right Winger</td>
                                <td>Marcelo Cirino</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>Right Winger</td>
                                <td>Riko Simanjuntak</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Right Winger</td>
                                <td>Vico</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>79</td>
                                <td>Right Winger</td>
                                <td>Raustananta Destalova</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>88</td>
                                <td>Right Winger</td>
                                <td>Angga Sangaji</td>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Centre-forward</td>
                                <td>Gustavo Tocantins</td>
                                <td>Brazil</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Centre-forward</td>
                                <td>Hokky Caraka</td>
                                <td>Indonesia</td>
                            </tr>
                        </table>
                    </article>
                    <article id="pelatihnstaff">
                        <h3 style="margin-bottom: 10px;">Pelatih dan Staff</h3>
                        <table>
                            <tr>
                                <th>Posisi</th>
                                <th>Nama</th>
                            </tr>
                            <tr>
                                <td>Team Manager</td>
                                <td>Leonard Tupamahu</td>
                            </tr>
                            <tr>
                                <td>Manager</td>
                                <td>Mazola junior</td>
                            </tr>
                            <tr>
                                <td>Assistant Manager</td>
                                <td>Ansyari Lubis</td>
                            </tr>
                            <tr>
                                <td>Goalkeeping Coach</td>
                                <td>Amiruddin</td>
                            </tr>
                            <tr>
                                <td>Goalkeeping Coach</td>
                                <td>Andre Croda</td>
                            </tr>
                            <tr>
                                <td>Fitness Coach</td>
                                <td>William Schmidt</td>
                            </tr>
                            <tr>
                                <td>Video Analyst</td>
                                <td>Gabriel Silveira</td>
                            </tr>
                            <tr>
                                <td>Scout</td>
                                <td>Gustavo Lopez</td>
                            </tr>
                            <tr>
                                <td>Physiotherapist</td>
                                <td>Sigit Pramudya</td>
                            </tr>
                            <tr>
                                <td>Translator</td>
                                <td>Claudio Luzardi</td>
                            </tr>
                        </table>
                    </article>
                    <article id="apparel">
                        <h3 style="margin-bottom: 10px;">Apparel</h3>
                        <table>
                            <tr>
                                <th>Musim</th>
                                <th>Nama</th>
                            </tr>
                            <tr>
                                <td>2001-2003</td>
                                <td>Nike</td>
                            </tr>
                            <tr>
                                <td>2004</td>
                                <td>In House</td>
                            </tr>
                            <tr>
                                <td>2005</td>
                                <td>Adidas</td>
                            </tr>
                            <tr>
                                <td>2006-2007</td>
                                <td>Vilour</td>
                            </tr>
                            <tr>
                                <td>2008-2009</td>
                                <td>Adidas</td>
                            </tr>
                            <tr>
                                <td>2009-2012</td>
                                <td>Dibuat klub</td>
                            </tr>
                            <tr>
                                <td>2013-2024</td>
                                <td>Sembada</td>
                            </tr>
                            <tr>
                                <td>2024 -</td>
                                <td>DRX Wear</td>
                            </tr>
                        </table>
                    </article>
                </div>
            </div>
            <div class="right_content">
                <div class="infobox">
                    <img src="../img/stadion.png" alt="">
                    <div class="teks_content">
                        <p class="left">Nama</p>
                        <p>Stadion Maguwoharjo</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Kapasitas</p>
                        <p>31.700</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Tahun dibangun</p>
                        <p>2005</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Permukaan</p>
                        <p>Rumput alami</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Ukuran</p>
                        <p>105m x 68m</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Jalur lari</p>
                        <p>Tidak ada</p>
                    </div>
                    <div class="teks_content">
                        <p class="left">Undersol heating</p>
                        <p>Tidak ada</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <i class="fa-regular fa-copyright"></i>
        <p>2024 All rights Reserved</p>
    </footer>
</body>
</html>
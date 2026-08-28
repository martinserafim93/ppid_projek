<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LionCoders" />
    <link rel="icon" type="image/png" href="images/logo_kemenag.png" />
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="icofont.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/slick.css" rel="stylesheet" />
    <link href="css/main2.css" rel="stylesheet" />
    <title>PPID Kementerian Agama</title>
</head>
<body> 
    <header id="home">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light ">
          <!-- Change Logo Img Here -->
          <a class="navbar-brand" href="index.php"><img src="images/logo_ppid.png" width="50%" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="interactive-menu-button">
              <a href="#">
                <span>Menu</span>
              </a>
            </div>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" data-scroll href="https://ppid.kemenag.go.id">Beranda</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profil</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="profil_ppid.php">Profil PPID</a>
                  <a class="dropdown-item" href="profil_pejabat.php">Profil Pejabat</a>
                  <a class="dropdown-item" href="profil_visi.php">Visi, Misi, &amp; Moto PPID</a>
                  <a class="dropdown-item" href="profil_tugas.php">Tugas, Fungsi, &amp; Wewenang PPID</a>
                  <a class="dropdown-item" href="profil_struktur.php">Struktur Organisasi PPID</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-scroll href="regulasi.php">Regulasi</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Layanan Informasi</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="ppid_mobile.php">e-PPID Mobile</a>
                  <a class="dropdown-item" href="li_permohonan.php">Tata Cara Permohonan Informasi</a>
                  <a class="dropdown-item" href="li_pengajuan.php">Tata Cara Pengajuan Keberatan</a>
                  <a class="dropdown-item" href="li_sengketa.php">Tata Cara Sengketa Informasi</a>
                  <a class="dropdown-item" href="sl_sop.php">SOP Layanan Informasi Publik</a>
                  <!-- <a class="dropdown-item" href="li_sop.php">SOP Layanan Informasi Publik</a> -->
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Standar Layanan</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="sl_maklumat.php">Maklumat Pelayanan</a>
                  <a class="dropdown-item" href="sl_jadwal.php">Jadwal Pelayanan</a>
                  <a class="dropdown-item" href="sl_biaya.php">Biaya/Tarif Layanan</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Informasi Publik</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="if_berkala_update2.php">Informasi Berkala</a>
                  <a class="dropdown-item" href="https://kemenag.go.id/informasi">Informasi Serta Merta</a>
                  <a class="dropdown-item" href="if_tersedia_update2.php">Informasi Tersedia Setiap Saat</a>
                  <!-- <a class="dropdown-item" href="siaranpers.php">Siaran Pers</a> -->
                  <a class="dropdown-item" href="infografis.php">Infografis</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
     </header>
     <!-- <section>
         <script src="js/platform.js" defer></script>
        <div class="elfsight-app-ea3db52e-eab3-485a-adb4-a76990c5f435"></div>
     </section> -->
<section>
     <div class="container">
     <div class="row">
     <div class="col-sm-6">
     <br/><br/><br/><br/>
        <h4>Selamat Datang <br/>di Portal PPID Kementerian Agama</h4><br/>
            <p style="font-size:0.9rem;">Layanan ini merupakan sarana layanan bagi pemohon informasi publik sebagai salah satu wujud pelaksanaan keterbukaan informasi publik di Kementerian Agama.</p>
            <br/>
            <div class="hero-btns">
              <a data-scroll data-toggle="modal" data-target="#myModal">Daftarkan Permohonan Informasi</a> 
              <br/><br/><br/> 
              <a data-scroll data-toggle="modal" data-target="#surveiModal">Survei Kepuasan Masyarakat</a>
            </div>
            <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <p align="center">
                        <img src="images/ic_warning.png" width="30px">&ensp;<b>WARNING</b><br/><br/>
                        Apakah Anda ingin mendaftarkan permohonan informasi secara online?
                        </p><br/>
                        <center>
                        <div class="hero-btns">
                        <a href="https://ppid.kemenag.go.id/sippid/">Ya, saya ingin mendaftar online</a>&nbsp;
                        <a href="manual.php">Tidak, saya ingin mendaftar manual</a>
                        </div>
                        </center>
                        <br/><br/>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Modal Survei -->
                <div class="modal fade" id="surveiModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <p align="center">
                        <a href="https://forms.gle/wWRSboxcL5kLRTteA"><img src="images/survei.jpg"></a>
                        </p><br/>
                        </div>
                    </div>
                    </div>
                </div>
    </div>
    <div class="col-sm-6">
    <br/><br/>
    <div class="slider">
		<figure>
			<div class="slide">
				<img src="images/info_3m.jpg">
			</div>
 
			<div class="slide">
				<img src="images/gratifikasi.jpg">
			</div>
 
			<div class="slide">
				<img src="images/370_covid.jpg">
			</div>
 
			<div class="slide">
				<img src="images/menag_masker.jpg">
			</div>
 
			<div class="slide">
				<img src="images/tolak_gratifikasi.jpg">
			</div>
		</figure>
	</div>
    </div>
    </div>
    </div>
  </section>
  <section class="blog">
      <div class="container"> 
        <div class="row">
            <!-- <div class="col-12 col-lg-4 blog-box">
            <center>
              <br/><img src="images/lpse-logo.png"><br/><br/>
              <a href="https://lpse.kemenag.go.id/eproc4/">LPSE</a>
            </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/jdih-logo.png" width="70"><br/><br/>
                  <a href="https://jdih.kemenag.go.id/list-regulation">Produk Hukum</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/logo_kemenag.png" width="70"><br/><br/>
                  <a href="https://simwas.kemenag.go.id/~simwbs/">Whistleblowing System</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/logo_kemenag.png" width="70"><br/><br/>
                  <a href="https://simwas.kemenag.go.id/~dumas/">Dumas</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/logo_kemenag.png" width="70"><br/><br/>
                  <a href="unitkerja.php">Unit Kerja</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/logo_kemenag.png" width="70"><br/><br/>
                  <a href="https://rb.kemenag.go.id/">Reformasi Birokrasi</a>
                </center>
          </div> -->
          <div class="col-12 col-lg-4 blog-box">
            <center>
              <img src="images/ic_system.png" width="70"><br/><br/>
              <a href="https://lpse.kemenag.go.id/eproc4/">LPSE</a>
            </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_law.png" width="70"><br/><br/>
                  <a href="https://jdih.kemenag.go.id/list-regulation">Produk Hukum</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_cloud.png" width="70"><br/><br/>
                  <a href="https://simwas.kemenag.go.id/~simwbs/">Whistleblowing System</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_doc.png" width="70"><br/><br/>
                  <a href="https://simwas.kemenag.go.id/~dumas/">Dumas</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_org.png" width="70"><br/><br/>
                  <a href="unitkerja.php">Unit Kerja</a>
                </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_innovation.png" width="70"><br/><br/>
                  <a href="https://rb.kemenag.go.id/">Reformasi Birokrasi</a>
                </center>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <section class="blog" style="background-color: #29b477;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
          <h3 style="text-align:center; color:#fff;">Jumlah Pemohon</h3>
          <h1 style="text-align:center; color:#fff;">45</h1> 
        </div>
      </div>
    </div>
  </section>
  <section class="about">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-lg-6">
        <h3>Berita Terkini</h3><br/><br/>
        <p style="color:#333333;">Diperbarui Terakhir: <?php echo date("d/m/Y");?></p>
        <?php
        $url = "https://kemenag.go.id/rss.xml";
        if(isset($_POST['submit'])){
            if($_POST['feedurl'] != ''){
                $url = $_POST['feedurl'];
            }
        }
        $invalidurl = false;
        if(@simplexml_load_file($url)){
            $feeds = simplexml_load_file($url);
        }else{
            $invalidurl = true;
            echo "<h2>Invalid RSS feed URL.</h2>";
        }
        $i=0;
        if(!empty($feeds)){
            $site = $feeds->channel->title;
            $sitelink = $feeds->channel->link;
            foreach ($feeds->channel->item as $item) {
                $title = $item->title;
                $img = $item->image->url;
                $link = $item->link;
                $description = $item->description;
                $postDate = $item->pubDate;
                $pubDate = date('D, d M Y',strtotime($postDate));
                if($i>=5) break;
        ?>
               <table class="table table-bordered">
                <tr><td rowspan="2"><?php echo '<img src="' .$img. '" style="display:block;margin-left:auto;margin-right:auto;" width="100%" height="auto"/>';?></td></tr>
               <tr>
               <td><a style="color:#000000;" href="<?php echo $link; ?>"><?php echo $title; ?></a>
               <br/><?php echo $pubDate; ?><br/>
               <?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?> <i><a style="color:#000000;" href="<?php echo $link; ?>">Baca selengkapnya</a></i>
               </td>
               </tr>
                </table>
                <?php
                $i++;
            }
        } else{
            if(!$invalidurl){
                echo "<h2>No item found</h2>";
            }
        }
    ?>
    <a style="color:#29b477;float:right;" href="https://kemenag.go.id/berita">Lihat berita lainnya</a>  
      </div>
      <div class="col-12 col-sm-12 col-lg-6">
        <h3>Daftar Informasi Publik Terbaru</h3><br/><br/>
        <p style="color:#333333;">Diperbarui Terakhir: <?php echo date("d/m/Y");?></p>
        <div class="container">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">Berkala</a>
            </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu1">Serta Merta</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu2">Tersedia Setiap Saat</a>
          </li>
          </ul>
          <div class="tab-content">
          <div id="home" class="container tab-pane active"><br/>
              <div class="panel-group" id="accordion">
                <div class="panel panel-default">
            
                </div>
                </div>
              <a style="color:#29b477;float:right;" href="if_berkala_update.php">Lihat informasi lainnya</a> 
          </div>
          <div id="menu1" class="container tab-pane fade"><br/>
          <table class="table table-bordered">
                <tr>
                <td>Siaran Pers</td>
                <td align="center"><a href="https://kemenag.go.id/pers-rilis"><i class="icofont-external-link"></i></a></td>
                </tr>
                <tr>
                <td>Instruksi Menteri Agama  No. 1 Tahun 2021 tentang Gerakan Sosialisasi Penerapan Protokol Kesehatan (5M)</td>
                <td align="center"><a href="additional_pages/gerakan_covid.php"><i class="icofont-external-link"></i></a></td>
                </tr>
                <tr>
                <td>SE Menag No. 13 Tahun 2021 tentang Pembatasan Pelaksanaan Kegiatan Keagamaan Di Rumah Ibadat</td>
                <td align="center"><a href="images/tolak_covid.jpg"><i class="icofont-external-link"></i></a></td>
                </tr>
                <tr>
                <td>SE Menag No. 04 Tahun 2021 tentang Panduan Ibadah Ramadhan dan Idul Fitri Tahun 1442H/2021M</td>
                <td align="center"><a href="images/se_menag.jpg"><i class="icofont-external-link"></i></a></td>
                </tr>
              </table>
              <a style="color:#29b477;float:right;" href="https://kemenag.go.id/informasi">Lihat informasi lainnya</a>   
          </div>
          <div id="menu2" class="container tab-pane fade"><br/>
              <div class="panel-group" id="accordion">
                <div class="panel panel-default">
               
                </div>
                </div>
              <a style="color:#29b477;float:right;" href="if_tersedia_update.php">Lihat informasi lainnya</a>
          </div>
  </div> 
</div>
      </div>
    </div>
  </div>
</section>
<section id="contact-us" class="contact">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3>Hubungi Kami</h3>
        <br/><br/>
      </div>
    </div>
    <div class="row">
        <div class="col-12">
          <table border="0" >
            <tr>
              <td style="vertical-align: top;"><i class="icofont-google-map icofont-2x"></i></td>
              <td><p>&nbsp;<b>Sekretariat PPID</b><br/>&nbsp;Jl. Lapangan Banteng Barat No. 3-4, Sawah Besar, Jakarta Pusat, DKI Jakarta</p>
              </td>
            </tr>
          </table>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-12">
            <table border="0" >
                <tr>
                  <td style="vertical-align: top;"><i class="icofont-phone icofont-2x"></i></td>
                  <td><p>&nbsp;021-3509181</p>
                  </td>
                </tr>
              </table>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-12">
            <table border="0" >
                <tr>
                  <td style="vertical-align: top;"><i class="icofont-email icofont-2x"></i></td>
                  <td><p>&nbsp;ppid@kemenag.go.id</p>
                  </td>
                </tr>
              </table>
        </div>
    </div>
    <br/>
    <!-- <div class="row">
        <div class="col-12">
            <table border="0" >
                <tr>
                  <td style="vertical-align: top;"><a href="https://www.facebook.com/KementerianAgamaRI"><i class="icofont-facebook icofont-2x"></i></a></td>
                  <td><p>&nbsp;Kementerian Agama RI</p>
                  </td>
                </tr>
              </table>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-12">
            <table border="0" >
                <tr>
                  <td style="vertical-align: top;"><a href="https://twitter.com/Kemenag_RI"><i class="icofont-twitter icofont-2x"></i></a></td>
                  <td><p>&nbsp;@Kemenag_RI</p>
                  </td>
                </tr>
              </table>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-12">
            <table border="0" >
                <tr>
                  <td style="vertical-align: top;"><a href="https://www.instagram.com/kemenag_ri/"><i class="icofont-instagram icofont-2x"></i></a></td>
                  <td><p>&nbsp;@Kemenag_RI</p>
                  </td>
                </tr>
              </table>
        </div>
    </div>  -->
    <div class="row">
        <div class="col-12">
            <div style="float:right;">
                <a href="https://www.facebook.com/KementerianAgamaRI"><i class="icofont-facebook icofont-2x"></i></a>&ensp;
                <a href="https://twitter.com/Kemenag_RI"><i class="icofont-twitter icofont-2x"></i></a>&ensp;
                <a href="https://www.instagram.com/kemenag_ri/"><i class="icofont-instagram icofont-2x"></i></a>
            </div>
        </div>
    </div>
  </div>
</section><br/>
<!-- FOOTER SECTION -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <p style="color:#FFFFFF; font-size:0.95rem;">&copy; Copyright 2021. PPID Kementerian Agama Republik Indonesia. All right reserved.</p>
      </div>
    </div>
  </div>
</footer>
  <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/smooth-scroll.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
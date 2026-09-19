<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="LionCoders" />
    <link rel="icon" type="image/png" href="images/logo_kemenag.png" />
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="icofont.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/slick.css" rel="stylesheet" />
    <link href="css/main2.css" rel="stylesheet" />
    <title>PPID Kementerian Agama</title> 
<style>
 
.slider{
	overflow: hidden;
	height: 350px;
}
 
.slider figure div{
	width: 20%;
	float: left;
}
 
.slider figure img{
	width: 100%;
	float: left;
}
 
.slider figure{
	position: relative;
	width: 500%;
	margin: 0;
	left: 0;
	animation: 20s slidy infinite;
}
 
@keyframes slidy{
	0%{
		left: 0%
	}
 
	10%{
		left: 0%;
	}
 
	12%{
		left: -100%;
	}
 
	22%{
		left: -100%;
	}
 
	24%{
		left: -200%;
	}
 
	34%{
		left: -200%;
	}
 
	36%{
		left: -300%;
	}
 
	46%{
		left: -300%;
	}
 
	48%{
		left: -400%;
	}
 
	58%{
		left: -400%;
	}
 
	60%{
		left: -300%;
	}
 
	70%{
		left: -300%;
	}
 
	72%{
		left: -200%;
	}
 
	82%{
		left: -200%;
	}
 
	84%{
		left: -100%;
	}
 
	94%{
		left: -100%;
	}
 
	96%{
		left: 0%;
	}
 
	100%{
		left: 0%;
	}
}
</style>
</head>
<body>
    <header id="home">
        <?php include('header.php');?>
     </header>
<section>
     <div class="container">
     <div class="row">
     <div class="col-sm-6">
     <br/><br/><br/><br/><br/>
        <h4>Selamat datang di<br/>Portal PPID Kementerian Agama</h4>
            <p>Vestibulum ac diam sit amet quam vehicula elementum<br> amet est on dui. Nulla porttitor accumsan tincidunt.</p>
            <br/>
            <div class="hero-btns">
              <a data-scroll href="#popupwarning">Daftarkan Permohonan Informasi</a>
              &nbsp;
              <a data-scroll href="masuk.php">Masuk</a>
            </div>
    </div>
    <div class="col-sm-6">
    <br/><br/><br/>
    <div class="slider">
		<figure>
			<div class="slide">
				<img src="images/1.png">
			</div>
 
			<div class="slide">
				<img src="images/2.png">
			</div>
 
			<div class="slide">
				<img src="images/3.png">
			</div>
 
			<div class="slide">
				<img src="images/4.png">
			</div>
 
			<div class="slide">
				<img src="images/5.png">
			</div>
		</figure>
	</div>
    </div>
    </div>
  </section>
  <section>
      <div class="container"> 
        <div class="row">
          <div class="col-12 col-lg-4 blog-box">
            <center>
              <img src="images/ic_system.png" width="70"><br/><br/>
              <a href="https://lpse.kemenag.go.id/eproc4/">LPSE</a>
            </center>
          </div>
          <div class="col-12 col-lg-4 blog-box">
              <center>
                  <img src="images/ic_law.png" width="70"><br/><br/>
                  <a href="https://hkln.kemenag.go.id/e-regulasi.php">Produk Hukum</a>
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


</body>
</html> 

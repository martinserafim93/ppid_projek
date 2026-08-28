<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metas -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LionCoders" />
    <!-- Links -->
    <link rel="icon" type="image/png" href="images/logo_kemenag.png" />
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="icofont.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/slick.css" rel="stylesheet" />
    <link href="css/main.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- Document Title -->
    <title>PPID Kementerian Agama</title>
</head>
<body>
<?php include('header.php');?>
  <br/><br/><br/>
  <section id="contact-us" class="contact">
        <div class="container">
          <div class="row">
            <div class="col-12">
 
            </div>
          </div>
          <div class="row">
              <div class="col-12">
                <table border="0" width="100%">

                  <tr>
                      <td align="center">
                        <h3>Jumlah Permohonan Informasi Publik</h3>
                        <a class="btn btn-success" href="#"><span class="counter" style="font-size: 32px;">12</span></a>
                      </td>
                  </tr>
                </table>
                <br/><br/><br/>
                
               

              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  
                <table border="0" width="100%">
                  <tr>
                      <td align="center">
                        <h3>Statistik Permohonan Informasi</h3>
                      </td>
                  </tr>
                  <tr>
                      <td align="center">
                        
                        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                        <script>
                        var xValues = ["2018", "2019", "2020", "2021", "2022"];
                        var yValues = [0, 2, 5, 5, 0];
                        var barColors = ["#BDC1AC", "#F5E9DD","#E1E0D3","#D3D4E1","#EFE0EE"];
                        
                        new Chart("myChart", {
                          type: "bar",
                          data: {
                            labels: xValues,
                            datasets: [{
                              backgroundColor: barColors,
                              data: yValues
                            }]
                          },
                          options: {
                            legend: {display: false},
                            title: {
                              display: true,
                              text: ""
                            }
                          }
                        });
                        </script>  
                      
                      </td>
                  </tr>
                </table>                   
                  
              </div>
          </div>
        </div>
    </section>
    <section>
    <div class="container">
          <div class="row">
            <div class="col-12">
              <br/><br/><br/>
            </div>
          </div>
    </div>
    </section>
    <?php include('footer.php');?>
  <!-- Scripts -->
  <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/smooth-scroll.min.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  <!-- Scripts Ends -->

    <script>
    $(document).ready(function() {
    
    $('.counter').each(function () {
    $(this).prop('Counter',0).animate({
    Counter: $(this).text()
    }, {
    duration: 1500,
    easing: 'swing',
    step: function (now) {
    $(this).text(Math.ceil(now));
    }
    });
    });
    
    });
    </script>
    
    

</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
		<link rel="icon" type="image/png" href="images/logo_kemenag.png" />
		<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<link href="css/reset-html5.css" rel="stylesheet" media="screen" />
		<link href="css/micro-clearfix.css" rel="stylesheet" media="screen" />
		<link href="css/stiff-chart.css" rel="stylesheet" media="screen" />
		<link href="css/custom.css" rel="stylesheet" media="screen" />
		<title>PPID Kementerian Agama</title>
	</head>

	<body>
    <table border="0" cellpadding="0" cellspacing="0" height="auto" width="100%">
        <tr>
            <td colspan="2">&emsp;<a href="javascript:history.back()"><img src="images/logo_back.png" width="40px" style="margin-top:10px;"></a></td>
        </tr>
    </table>
		<div class="chart-container">
			<div id="your-chart-name">
			  <div class="stiff-chart-inner">
			    <div class="stiff-chart-level" data-level="01">
			      <div class="stiff-main-parent">
			        <ul>
			          <li data-parent="a">
			            <div class="the-chart">
							<h4>Atasan PPID Unit</h4>
							<hr>
			            	<p>Sekretaris Eselon I</p>
			            </div>
			          </li>
			        </ul>
			      </div>
			    </div>

			    <div class="stiff-chart-level" data-level="02">
			      <div class="stiff-child" data-child-from="a">
			        <ul>
			          <li data-parent="a01">
			            <div class="the-chart">
						    <h4>PPID Unit</h4>
							<hr>
							<p>Kepala Bagian Data, Sistem Informasi, dan Humas</p>
			            </div>
			          </li>
			        </ul>
			      </div>
			    </div>

                <div class="stiff-chart-level" data-level="03">
			      <div class="stiff-child" data-child-from="a01">
			        <ul>
			          <li data-parent="a0101">
			            <div class="the-chart">
							<p>Panitia Pengelola dan Pelayanan Informasi</p>
			            </div>
			          </li>
			        </ul>
			      </div>
                </div>
                
			    <div class="stiff-chart-level" data-level="04">
			      <div class="stiff-child" data-child-from="a0101">
			        <ul>
			          <li data-parent="a010101">
			          	<div class="the-chart">
							<p>Desk Pengelola</p>
			            </div>  
			          </li>
			          <li data-parent="a010102">
			          	<div class="the-chart">
							<p>Desk Layanan</p>
			            </div>  
			          </li>
                    </ul>
                    </div>
                </div>

			  </div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

		
		<script src="js/stiffChart.js"></script>
		<script>
			$(document).ready(function() {
			  $('#your-chart-name').stiffChart({
			    
			  });
			});
		</script>
		
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

	</body>
</html>
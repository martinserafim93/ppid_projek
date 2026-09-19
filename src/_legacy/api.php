<html>
<body>
<?php
$token='af7c667b9819378c0bddb3baede9525b';
$url1= 'https://bimasislam.kemenag.go.id/apiv1/getShalatProv?param_token='.$token;

$data1 = file_get_contents($url1);
$provinces = json_decode($data1);

?>
<form action="api.php">
  <label>Pilih Provinsi:</label>
  <select name="provinsi" id="provinsi" onchange="this.form.submit()">
    <option value="" disabled selected>Select your option</option>
    <?php foreach ($provinces as $province) { ?>
    <option value="<?= $province->provKode; ?>"><?= $province->provNama; ?></option>
    <?php } ?>
  </select>
  <script type="text/javascript">
    document.getElementById('provinsi').value = "<?php echo $_GET['provinsi'];?>";
  </script>
  <br><br>
<?php
$provKode=$_GET["provinsi"]; 
$url2= 'https://bimasislam.kemenag.go.id/apiv1/getShalatKabko?param_prov='.$provKode.'&param_token='.$token;

$data2 = file_get_contents($url2);
$cities = json_decode($data2);
?>

  <label>Pilih Kab/Kota:</label>
  <select name="kota" id="kota">
    <option value="" disabled selected>Select your option</option>
    <?php foreach ($cities as $city) { ?>
    <option value="<?= $city->kabkoKode ?>"><?= $city->kabkoNama; ?></option>
    <?php } ?>
  </select>
  <script type="text/javascript">
    document.getElementById('kota').value = "<?php echo $_GET['kota'];?>";
  </script>
  <br/><br/>
  
<?php
$provKode=$_POST["provinsi"];
$kabkoKode=$_POST["kota"];
$year = date("Y"); ;
$month= date("m");
$url3= 'https://bimasislam.kemenag.go.id/apiv1/getShalatJadwal?param_prov='.$provKode.'&param_kabko='.$kabkoKode.'&param_thn='.$year.'&param_bln='.$month.'&param_token='.$token;

$data3 = file_get_contents($url3);
$schedules = json_decode($data3);

?>
<input type="submit" value="Submit">
</form>

<table border="1">
    <tbody>
        <tr>
            <th>Tanggal</th>
            <th>Imsak</th>
            <th>Subuh</th>
            <th>Terbit</th>
            <th>Dhuha</th>
            <th>Dzuhur</th>
            <th>Ashar</th>
            <th>Maghrib</th>
            <th>Isya</th>
        </tr>
        <?php foreach ($schedules as $schedule) { ?>
        <tr>
            <td> <?= $schedule->tanggal; ?> </td>
            <td> <?= $schedule->imsak; ?> </td>
            <td> <?= $schedule->subuh; ?> </td>
            <td> <?= $schedule->terbit; ?> </td>
            <td> <?= $schedule->dhuha; ?> </td>
            <td> <?= $schedule->dzuhur; ?> </td>
            <td> <?= $schedule->ashar; ?> </td>
            <td> <?= $schedule->maghrib; ?> </td>
            <td> <?= $schedule->isya; ?> </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</body>

</html>
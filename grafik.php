<!DOCTYPE html>
<html>
<head>
 <title>maribelajarcoding.com</title>
 <link rel="stylesheet" type="text/css" href="plugins/chart.js/Chart.min.css">
 <script type="text/javascript" src="dist/js/pages/dashboard3.js"> </script>
</head>
<body>
<h2 >GRAFIK TRANSAKSI</h2> 

<div style="width: 600px;" >
 <canvas id="myChart"></canvas>
</div>
<?php 
	include 'koneksi.php';
?>
 
	<div style="width: 800px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>
 
	<br/>
	<br/>
 
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Januari", "Februari", "Maret", "April"],
				datasets: [{
					label: '',
					data: [
					<?php 
					$jumlah_teknik = mysqli_query($koneksi,"select COUNT(id_transaksi) from transaksi where month(tgl_masuk)='01'");
					echo mysqli_num_rows($jumlah_teknik);
					?>, 
					<?php 
					$jumlah_ekonomi = mysqli_query($koneksi,"select COUNT(id_transaksi) from transaksi where month(tgl_masuk)='02'");
					echo mysqli_num_rows($jumlah_ekonomi);
					?>, 
					<?php 
					$jumlah_fisip = mysqli_query($koneksi,"select COUNT(id_transaksi) from transaksi where month(tgl_masuk)='03'");
					echo mysqli_num_rows($jumlah_fisip);
					?>, 
					<?php 
					$jumlah_pertanian = mysqli_query($koneksi,"select COUNT(id_transaksi) from transaksi where month(tgl_masuk)='04'");
					echo mysqli_num_rows($jumlah_pertanian);
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>
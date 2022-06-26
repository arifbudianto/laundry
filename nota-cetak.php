<?php
$id_transaksi 		=  $_GET['id_transaksi'];
// use Dompdf\Dompdf;
// ob_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Struk Transaksi</title>
	<link rel="stylesheet" type="text/css" href="./asset/css/bootstrap.min.css">
	<!-- <style media="screen">
	table, th, td, tr {
		border: 1px solid black;
		border-collapse: collapse;
	}
	th, td {
		padding: 5px;
		text-align: left;
	}
	hr{
		border: 1px solid black;
	}
  </style> -->
</head>
<body style="font-family:arial">
	<table style="width:100%" border=0>
		<tr>
			<td style="width:50%">
				<h3 style="margin:0">Athaya Laundry</h3>
				<p style="margin:0;font-size:12px">Jl. Janti Kanoman No. 11 B RT/RW 06/20 Depan Asrama PMII (Selatan Kampus UTDI)</p>
				<p style="margin:0;font-size:12px">Hp : 0882 3225 1535</p>
			</td>
			<td style="display:flex;border:0;justify-content:flex-end">
				<h3 style="margin:0">Invoice</h3>
			</td>
		</tr>
	</table>
	<hr>
	<?php
	include "koneksi.php";
	$sql = mysqli_query($kon, "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama, paket.id_paket,
					paket.nama_paket,paket.harga, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar FROM transaksi
					JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
					JOIN paket ON transaksi.id_paket = paket.id_paket
					JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum where id_transaksi like '%".$id_transaksi."%'
					ORDER BY id_transaksi DESC");
	
	$hasil = mysqli_fetch_array($sql);
	while ($hasil) {
		$id_paket = $hasil['id_paket'];
		$tgl1 = date('d-m-Y',strtotime($hasil['tgl_masuk']));// pendefinisian tanggal awal
		if ($id_paket == "K03" || $id_paket == "K04"  || $id_paket == "CK4" || $id_paket == "CB4"){
			$tgl2 = date('d-m-Y', strtotime($tgl1));
		}
		elseif($id_paket == "K02" || $id_paket == "S02"){
			$tgl2 = date('d-m-Y', strtotime('+1 days', strtotime($tgl1)));
		}
		else {
			
			$tgl2 = date('d-m-Y', strtotime('+2 days', strtotime($tgl1)));
		}
	?>

	<table style="width:100%;font-size:12px" border=0>
		<tr>
			<td style="width:50%;vertical-align: top">
				<table>
					<tr>
						<td rowspan="2" style="vertical-align: baseline;width: 80px;"><b>Customer</b></td>
						<td colspan="2"><?php echo $hasil['nama']; ?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo $hasil['nohp']; ?></td>
					</tr>
				</table>
			</td>
			<td style="float:right">
				<table>
					<tr>
						<td style="text-align:right;padding-right:15px"><b>Id Transaksi</b></td>
						<td><?php echo $hasil['id_transaksi']; ?></td>
					</tr>
					<tr>
						<td style="text-align:right;padding-right:15px"><b>Tgl. Masuk</b></td>
						<td><?php echo $tgl1; ?></td>
					</tr>
					<tr>
						<td style="text-align:right;padding-right:15px"><b>Tgl. Selesai</b></td>
						<td><?php echo $tgl2; ?></td>
					</tr>
					<tr>
						<td style="text-align:right;padding-right:15px"><b>Jenis Parfum</b></td>
						<td><?php echo $hasil['jenis_parfum']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<!-- <div class="row">
		<div class="col-sm-6 col-xs-6">
			<p>No HP   : <?php echo $hasil['nohp']; ?>
    <br>
    Nama : <?php echo $hasil['nama']; ?>
  </p>
</div>
<div class="col-sm-6 col-xs-6">
  <p >Tgl Masuk : <?php echo $tgl1; ?>
    <br>
    Tgl Selesai   : <?php echo $tgl2; ?>
	<br>
	Jenis Parfum : <?php echo $hasil['jenis_parfum']; ?>
  </p>
</div>
</div>
<hr >
<p>ID Transaksi : <?php echo $hasil['id_transaksi']; ?></p>
<div class="table-responsive"> -->
<table style="width:100%;font-size:12px; margin-top:15px;" border=1 cellspacing=0 cellpadding=4>
	<thead>
		<tr>
			<th style="text-align:left;">Paket</th>
			<th style="text-align:left;">Berat (Kg)</th>
			<th style="text-align:left;">Harga (Rp)</th>
			<th style="text-align:left;">Total Bayar (Rp)</th>
		</tr>
	</thead>
  	<tbody>
      <?php
        $sql = mysqli_query($kon, "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
		paket.nama_paket,paket.harga, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
		FROM transaksi
		JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
		JOIN paket ON transaksi.id_paket = paket.id_paket
		JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum where id_transaksi like '%".$id_transaksi."%'
		ORDER BY id_transaksi DESC");
        while ($hasil = mysqli_fetch_array($sql)) {
     ?>
      	<tr>
			<td><?php echo $hasil['nama_paket']; ?></td>
			<td><?php echo round($hasil['berat'],3); ?></td>
			<td><?php echo number_format($hasil['harga'],0,',','.'); ?></td>
			<td><?php echo number_format($hasil['total_bayar'],0,',','.'); ?></td>
      	</tr>
      <?php
    }
      ?>
  	</tbody>
</table>
<!-- <div>
  <p style="float:right">Total Bayar (Rp) : <?php echo $hasil['total_bayar']; ?></p>
</div> -->
<?php
}
?>
	<script>
		window.print();
	</script>
</body>
</html>
<?php

// $html = ob_get_clean();
// require_once 'dompdf/autoload.inc.php';
// $dompdf = new DOMPDF();
// $dompdf->set_paper("A5");
// $dompdf->load_html($html);
// $dompdf->render();
// $dompdf->stream('struk.pdf');

?>
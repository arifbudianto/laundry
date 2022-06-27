<?php
require("koneksi.php");
// grafik bulanan
$sql ="SELECT MAX(tgl_masuk) AS tgl_masuk FROM transaksi";
$data =mysqli_query($kon,$sql);

if(!$data){
    die(mysqli_error($kon));
}

$row = mysqli_fetch_assoc($data);

$tahun_ini = $row['tgl_masuk'];
$tahun_lalu = strtotime($tahun_ini.' -1 year');
$tahun_lalu = date('Y', $tahun_lalu);
$tahun_lalu = $tahun_lalu."-01-01";
// echo $tahun_lalu ."<br/>";


$sql1 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, COALESCE(SUM(total_bayar),'') AS total_bayar FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tahun_lalu', '%Y-%m') and DATE_FORMAT('$tahun_ini', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m') ORDER BY tgl_masuk ASC";
$data1 = mysqli_query($kon,$sql1);

if(!$data1){
    die(mysqli_error($kon));
}

$result=[];
while($row1 = mysqli_fetch_assoc($data1)){
    $result[] = array(
        "data_tgl_periode" => $row1['tgl_masuk'],
        "data_berat" => $row1['berat'],
        "data_total_bayar" => $row1['total_bayar']
    );
}

// pelanggan
$sql2 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(COUNT(nohp),'') AS total_pelanggan FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tahun_lalu', '%Y-%m') and DATE_FORMAT('$tahun_ini', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
$data2 = mysqli_query($kon,$sql2);
if(!$data2){
    die(mysqli_error($kon));
}

$result2=[];
while($row2 = mysqli_fetch_assoc($data2)){
    $result2[] = array(
        "data_tgl_periode" => $row2['tgl_masuk'],
        "total_pelanggan" => $row2['total_pelanggan']
    );
}

// parfum
$bulan_start =!empty($_POST['tgl_awal'])?$_POST['tgl_awal']:'';
$bulan_end =!empty($_POST['tgl_akhir'])?$_POST['tgl_akhir']:'';

$sql4 ="SELECT MAX(tgl_masuk) AS periode_max FROM transaksi";
$data4 = mysqli_query($kon,$sql4);

if(!$data4){
    die(mysqli_error($kon));
}
$row4 = mysqli_fetch_assoc($data4);

$periode_max = $row4['periode_max'];


if($bulan_start !='' && $bulan_end !=''){
    $bulan_start = $bulan_start."-00";
    $bulan_end = $bulan_end."-00";

    $sql3 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, jenis_parfum FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$bulan_start', '%Y-%m') and DATE_FORMAT('$bulan_end', '%Y-%m') GROUP BY  jenis_parfum";

    $sql33 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(COUNT(jenis_parfum),'') AS jumlah_peminat FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$bulan_start', '%Y-%m') and DATE_FORMAT('$bulan_end', '%Y-%m') GROUP BY jenis_parfum";
}else if($bulan_start !='' && $bulan_end ==''){
    $bulan_start = $bulan_start."-00";
    $sql3 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, jenis_parfum FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') = DATE_FORMAT('$bulan_start', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m'), jenis_parfum";

    $sql33 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(COUNT(jenis_parfum),'') AS jumlah_peminat FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') = DATE_FORMAT('$bulan_start', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m'), jenis_parfum";
}
else{
    
    $sql3 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, jenis_parfum FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') = DATE_FORMAT('$periode_max', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m'), jenis_parfum";

    $sql33 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(COUNT(jenis_parfum),'') AS jumlah_peminat FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') = DATE_FORMAT('$periode_max', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m'), jenis_parfum";
}

// echo $sql33;

$data3 = mysqli_query($kon,$sql3);
if(!$data3){
    die(mysqli_error($kon));
}

$result3=[];
while($row3 = mysqli_fetch_assoc($data3)){
    $liter_parfum = round($row3['berat']/25,3);
    $result3[] = array(
        "data_tgl_periode" => $row3['tgl_masuk'],
        "total_parfum_liter" => $liter_parfum,
        "jenis_parfum" => $row3['jenis_parfum']
    );
}


$data33 = mysqli_query($kon,$sql33);
if(!$data33){
    die(mysqli_error($kon));
}

$result33=[];
while($row33 = mysqli_fetch_assoc($data33)){
    $result33[] = array(
        "data_tgl_periode" => $row33['tgl_masuk'],
        "total_parfum_peminat" => $row33['jumlah_peminat']
        // "jenis_parfum" => $row3['jenis_parfum']
    );
}

// peminat parfum


echo json_encode([
    "status" => "success",
    "structure" => [
        "data_result_transaksi" => $result,
        "data_result_pelanggan" => $result2,
        "data_result_parfum" => $result3,
        "data_result_parfum_peminat" => $result33
    ]
]);

?>
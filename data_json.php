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

echo json_encode([
    "status" => "success",
    "structure" => [
        "data_result_transaksi" => $result,
        "data_result_pelanggan" => $result2
    ]
]);

?>
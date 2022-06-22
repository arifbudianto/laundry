<?php
require("koneksi.php");
// grafik bulanan
$sql4 ="SELECT MAX(tgl_masuk) AS tgl_masuk FROM transaksi";
$data4 =mysqli_query($kon,$sql4);

if(!$data4){
    die(mysqli_error($kon));
}

$row4 = mysqli_fetch_assoc($data4);

$tahun_ini = $row4['tgl_masuk'];
$tahun_lalu = strtotime($tahun_ini.' -1 year');
$tahun_lalu = date('Y', $tahun_lalu);
$tahun_lalu = $tahun_lalu."-01-01";
// echo $tahun_lalu ."<br/>";


$sql5 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%m') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, COALESCE(SUM(total_bayar),'') AS total_bayar FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tahun_lalu', '%Y-%m') and DATE_FORMAT('$tahun_ini', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m') ORDER BY tgl_masuk ASC";


$data5 = mysqli_query($kon,$sql5);


if(!$data5){
    die(mysqli_error($kon));
}


$result=[];
while($row5 = mysqli_fetch_assoc($data5)){
    $result[] = array(
        "data_tgl_periode" => $row5['tgl_masuk'],
        "data_berat" => $row5['berat'],
        "data_total_bayar" => $row5['total_bayar']
    );
}

echo json_encode([
    "status" => "success",
    "structure" => [
        "data_result" => $result
    ]
]);

?>
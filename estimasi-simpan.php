<?php

$id_estimasi    = $_POST['id_estimasi'];
$harga          = $_POST['harga'];

$dataValid = "YA";

if (strlen(trim($harga))==0){
    echo "Harap isi Harga !<br/>";
    $dataValid ="TIDAK";
}
if ($dataValid=="TIDAK"){
    echo "Masih ada kesalahan, silahkan perbaiki!<br/>";
    echo "<input type = 'button' value = 'Kembali'
            onClick = 'self.history.back()'>";
    exit;
}

include "koneksi.php";
if (!is_numeric($harga))
{
    echo 'Bukan angka';
}else{
    $sql = "UPDATE estimasi_waktu SET
            harga    =   '$harga'
            where id_estimasi = '$id_estimasi'";
    $hasil = mysqli_query($kon, $sql);

    if($hasil){
        echo "Berhasil <br/>";
    }else {
        echo "Gagal Simpan! <br/>";
        echo mysqli_error($kon);
        echo "<br/><input type = 'button' values = 'Kembali'
            onClick = 'self.histry.back()'>";
        exit;
    }
}
?>
<a href = "estimasi-tampil.php" />Daftar Estimasi Waktu</a>
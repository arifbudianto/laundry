<?php
    include "koneksi.php";

    $id_transaksi 		=  $_GET['id_transaksi'];
    $tgl_keluar 		=  date('Y-m-d');

          $sql = "UPDATE transaksi SET tgl_keluar='$tgl_keluar' WHERE id_transaksi = '$id_transaksi'";
          $hasil = mysqli_query($kon, $sql);
          echo "<script language='javascript'>alert('Pakaian Sudah Diambil');</script>";
          echo '<meta http-equiv="refresh" content="0; url=trans-tampil.php">';
?>
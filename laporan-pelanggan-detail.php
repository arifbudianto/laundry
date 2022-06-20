<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<?php
$tgl_masuk =date('Y-m', strtotime($_GET["tgl_masuk"]));
$tgl_concate = $tgl_masuk."-00";
?>
<div class="content">
    <div class="container-fluid">
        <a href="laporan-pelanggan-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> Laporan Customer</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <center>
                <h1>LAPORAN CUSTOMER ATHAYA LAUNDRY</h1>
            </center>
            <table border = 0>
                <tr>
                    <td>Bulan </td>
                    <td> : </td>
                    <td> <?php echo date('F', strtotime($tgl_masuk));?> </td>
                </tr>
            </table>
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>N0. HP</th>
                        <th>Nama</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Berat (Kg)</th>
                        <th>Total Bayar (Rp.)</th>
                        <!-- <th>Berat (Kg)</th> -->
                        <!-- <th>Paket</th>
                        <th>Jenis Parfum</th> -->
                        <!-- <th>Total Bayar (Rp)</th> -->
                    </tr>
                    <?php
                    include "koneksi.php";
                    $no = 1;
                    $sql = "SELECT pelanggan.nohp, pelanggan.nama, COUNT(pelanggan.nohp) AS JN, SUM(transaksi.berat) AS TB, 
                    SUM(transaksi.total_bayar) AS Jumlah FROM transaksi JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
                    WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y') GROUP BY nohp";
                    $hasil = mysqli_query ($kon,$sql);
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['nohp']."</td>";
                        echo " <td> ".$row['nama']."</td>";
                        echo " <td> ".$row['JN']."</td>";
                        echo " <td> ".$row['TB']."</td>";
                        echo " <td> ".$row['Jumlah']."</td>";
                        // echo " <td> ".$row['nama_paket']."</td>";
                        // echo " <td> ".$row['jenis_parfum']."</td>";
                        // echo " <td> ".$row['total_bayar']."</td>";
                        // echo " <td class='text-center'>";
                 } 
                ?>
                </table>
                
            </div>
        </div>
        
    </div>
</div>
<!-- <script>
    window.print();
</script> -->
<?php    
require('footer.php');
?>
<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Transaksi</h1>
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
$tgl_masuk =date('F Y', strtotime($_GET["tgl_masuk"]));
$tgl_concate = $tgl_masuk."-00";
?>
<div class="content">
    <div class="container-fluid">
        <a href="laporan-transaksi-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> Laporan Transaksi</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <center>
                <h1>LAPORAN TRANSAKSI ATHAYA LAUNDRY</h1>
            </center>
            <?php
            include "koneksi.php";
            $no = 1;
            $sql = "SELECT DATE_FORMAT(tgl_masuk, '%M-%Y') as tgl_masuk, COALESCE(SUM(berat),'') AS berat, COALESCE(SUM(total_bayar),'') AS total_bayar FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y') ;";
            $hasil = mysqli_query ($kon,$sql);
            echo $sql;
            $data = mysqli_fetch_array($hasil);
            $berat = $data['berat'];
            $pend = $data['total_bayar'];
            ?>
            <table border = 0>
                <tr>
                    <td>Bulan </td>
                    <td> : </td>
                    <td> <?php echo $tgl_masuk;?> </td>
                </tr>
                <tr>
                    <td>Total Laundry Masuk </td>
                    <td> : </td>
                    <td> <?php echo $berat;?> </td>
                </tr>
                <tr>
                    <td>Total Pendapatan </td>
                    <td> : </td>
                    <td> <?php echo "Rp.".$pend;?> </td>
                </tr>
            </table>
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>ID Transaksi</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>No. HP</th>
                        <th>Nama</th>
                        <th>Berat (Kg)</th>
                        <!-- <th>Paket</th>
                        <th>Jenis Parfum</th> -->
                        <th>Total Bayar (Rp)</th>
                    </tr>
                    <?php
                    include "koneksi.php";
                    $no = 1;
                    $sql = "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
                    paket.nama_paket, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
                    FROM transaksi
                    JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
                    JOIN paket ON transaksi.id_paket = paket.id_paket
                    JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum WHERE tgl_masuk='$tgl_masuk'";
                    $hasil = mysqli_query ($kon,$sql);
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['id_transaksi']."</td>";
                        echo " <td> ".$row['tgl_masuk']."</td>";
                        echo " <td> ".$row['tgl_keluar']."</td>";
                        echo " <td> ".$row['nohp']."</td>";
                        echo " <td> ".$row['nama']."</td>";
                        echo " <td> ".$row['berat']."</td>";
                        // echo " <td> ".$row['nama_paket']."</td>";
                        // echo " <td> ".$row['jenis_parfum']."</td>";
                        echo " <td> ".$row['total_bayar']."</td>";
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
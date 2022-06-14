<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Pelanggan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="prediksi-form.php">Laporan Pelanggan</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
    <?php
    if(isset($_POST['tampil'])){
        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];
        
        $dataValid = "YA";

        $err_tgl_awal='';
        $err_tgl_akhir='';
        $err_valid='';

        if (strlen(trim($tgl_awal))==0){
            $err_tgl_awal= "Tanggal Awal Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($tgl_akhir))==0){
            $err_tgl_akhir= "Tanggal Masuk Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        if ($dataValid=="TIDAK"){
            $err_valid= "Masih ada kesalahan, silahkan perbaiki !<br/>";
            
        }
    }

        if(strlen(trim($tgl_awal))==0 || strlen(trim($tgl_akhir))==0 || $dataValid=="TIDAK"){

            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_tgl_awal;
                    echo $err_tgl_akhir;
                    echo $err_valid;       
                ?>
            </div>
            <a href="laporan-transaksi-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
        <?php
        exit;
        }
    ?>
        <a href="laporan-pelanggan-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> LAPORAN PELANGGAN</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <center>
                <h1>LAPORAN PER PELANGGAN DI ATHAYA LAUNDRY</h1>
            </center>
            <table border = 0>
                <tr>
                    <td>Periode Laporan </td>
                    <td> : </td>
                    <td> <?php echo $tgl_awal;?> </td>
                    <td class="col-sm-2 text-center"> s/d </td>
                    <td> <?php echo $tgl_akhir;?> </td>
                </tr>
            </table>
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>No HP</th>
                        <th>Nama</th>
                        <th>Jumlah Laundry</th>
                        <th>Jumlah Berat</th>
                        <th>Total (Rp)</th>
                        <!-- <th>Berat (Kg)</th> -->
                        <!-- <th>Paket</th>
                        <th>Jenis Parfum</th> -->
                        <!-- <th>Total Bayar (Rp)</th> -->
                    </tr>
                    <?php
                    include "koneksi.php";
                    $no = 1;
                    $sql = "SELECT pelanggan.nohp, pelanggan.nama, COUNT(pelanggan.nama) AS JN, SUM(transaksi.berat) AS TB, 
                    SUM(transaksi.total_bayar) AS Jumlah FROM transaksi JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
                    WHERE tgl_masuk between '$tgl_awal' and '$tgl_akhir' GROUP BY nohp";
                    $hasil = mysqli_query ($kon,$sql);
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['nohp']."</td>";
                        echo " <td> ".$row['nama']."</td>";
                        echo " <td> ".$row['JN']."</td>";
                        echo " <td> ".$row['TB']."</td>";
                        echo " <td> ".$row['Jumlah']."</td>";
                        // echo " <td> ".$row['berat']."</td>";
                        // echo " <td> ".$row['nama_paket']."</td>";
                        // echo " <td> ".$row['jenis_parfum']."</td>";
                        // echo " <td> ".$row['total_bayar']."</td>";
                        echo " <td class='text-center'>";
                 } 
                ?>
                </table>
                
            </div>
        </div>
        
    </div>
</div>
<script>
    window.print();
</script>
<?php    
require('footer.php');
?>
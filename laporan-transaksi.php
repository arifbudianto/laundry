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
                    <li class="breadcrumb-item"><a href="prediksi-form.php">Laporan Transaksi</a></li>
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
        $tgl_concate = $tgl_awal."-00";
        // $tgl_akhir = $_POST['tgl_akhir'];
        
        $dataValid = "YA";

        $err_tgl_awal='';
        // $err_tgl_akhir='';
        $err_valid='';

        if (strlen(trim($tgl_awal))==0){
            $err_tgl_awal= "Tanggal Awal Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        // if (strlen(trim($tgl_akhir))==0){
        //     $err_tgl_akhir= "Tanggal Masuk Harap di Isi !<br/>";
        //     $dataValid ="TIDAK";
        // }
        if ($dataValid=="TIDAK"){
            $err_valid= "Masih ada kesalahan, silahkan perbaiki !<br/>";
            
        }
    }

        if(strlen(trim($tgl_awal))==0 || $dataValid=="TIDAK"){

            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_tgl_awal;
                    // echo $err_tgl_akhir;
                    echo $err_valid;       
                ?>
            </div>
            <a href="laporan-transaksi-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
        <?php
        exit;
        }
    ?>
        <a href="laporan-transaksi-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> Laporan Transaksi</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <?php
                include "koneksi.php";
                $no = 1;
                $sql = "SELECT COALESCE(SUM(berat),'') AS TB, COALESCE(SUM(total_bayar),'') AS TP FROM transaksi where DATE_FORMAT(tgl_masuk, '%m') =  DATE_FORMAT('$tgl_concate', '%m') and DATE_FORMAT(tgl_masuk, '%Y') =  DATE_FORMAT('$tgl_concate', '%Y')";
                $hasil = mysqli_query ($kon,$sql);
                $data = mysqli_fetch_array($hasil);
                $berat = $data['TB'];
                $pend = $data['TP'];
                $bulan = date('F Y', strtotime($tgl_awal));

            
            ?>
            <table style="width:100%" border=0>
                <tr>
                    <td style="text-align:center"><h2 style="margin-bottom:0">Laporan Transaksi Athaya Laundry</h2></td>
                </tr>
                <tr>
                    <td style="text-align:center;padding-bottom:10px">Periode :  <b><?php echo $bulan;?></b></td>
                </tr>
            </table>
           
            <table border = 0>
                <tr>
                    <!-- <td style="text-align:center">Periode :  <?php echo $bulan;?></td> -->
                    <!-- <td> : </td>
                    <td> <?php echo $bulan;?> </td> -->
                    <!-- <td class="col-sm-2 text-center"> s/d </td>
                    <td> <?php echo $tgl_akhir;?> </td> -->
                </tr>
                <!-- <tr>
                    <td>Total Laundry Masuk </td>
                    <td> : </td>
                    <td> <?php echo $berat;?> </td>
                </tr>
                <tr>
                    <td>Total Pendapatan </td>
                    <td> : </td>
                    <td> <?php echo "Rp.".$pend;?> </td>
                </tr> -->
            </table>
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Bulan</th>
                        <th style="text-align:right">Berat (Kg)</th>
                        <!-- <th>Paket</th>
                        <th>Jenis Parfum</th> -->
                        <th style="text-align:right">Total Bayar (Rp)</th>
                    </tr>
                    <?php
                   
                    $sql = "SELECT COALESCE(SUM(berat),'') AS berat, COALESCE(SUM(total_bayar),'') AS total_bayar FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%m') =  DATE_FORMAT('$tgl_concate', '%m') and DATE_FORMAT(tgl_masuk, '%Y') =  DATE_FORMAT('$tgl_concate', '%Y')";
                    $hasil = mysqli_query ($kon,$sql);
                    
                    $no = 1;
                
                    while ($row = mysqli_fetch_assoc($hasil)){
                        if( $row['berat'] && $row['total_bayar']){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$bulan."</td>";
                            // echo " <td> ".$row['tgl_masuk']."</td>";
                            // echo " <td> ".$row['tgl_keluar']."</td>";
                            // echo " <td> ".$row['nohp']."</td>";
                            // echo " <td> ".$row['nama']."</td>";
                            echo " <td style='text-align:right'> ".$row['berat']."</td>";
                            // echo " <td> ".$row['nama_paket']."</td>";
                            // echo " <td> ".$row['jenis_parfum']."</td>";
                            echo " <td style='text-align:right'> ".number_format($row['total_bayar'],2,',','.')."</td>";
                            // echo " <td class='text-center'>";
                        }else{
                            echo "<tr><td colspan='4' style='text-align:center'>Tidak ada data</td></tr>";
                        }
                    } 
                        
                  
                    
                ?>
                </table>
                
            </div>
        </div>
        
    </div>
</div>

<?php    
require('footer.php');
?>

<script>
    // window.print();
    var divToPrint=document.getElementById("printData");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
</script>
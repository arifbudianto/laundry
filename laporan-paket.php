<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Paket</h1>
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
        <a href="laporan-paket-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> Laporan Paket</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <center>
                <h1>LAPORAN PAKET ATHAYA LAUNDRY</h1>
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
                        <th>ID PAKET</th>
                        <th>PAKET</th>
                        <th>JUMLAH PEMINAT TIAP PAKET</th>
                        <th>TOTAL BAYAR</th>
                        <th>JUMLAH BERAT TIAP PAKET</th>
                    </tr>
                    <?php
                    include "koneksi.php";
                    $no = 1;
                    $sql ="SELECT paket.id_paket, paket.nama_paket, COUNT(transaksi.id_paket) AS paket, SUM(berat)
                            AS berat, SUM(total_bayar) AS bayar FROM transaksi JOIN paket ON transaksi.id_paket = paket.id_paket
                            WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y') GROUP BY id_paket;";
                    $hasil = mysqli_query ($kon,$sql);               
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['id_paket']."</td>";
                        echo " <td> ".$row['nama_paket']."</td>";
                        echo " <td> ".$row['paket']."</td>";
                        echo " <td> ".number_format($row['bayar'],2,',','.')."</td>";
                        echo " <td> ".round($row['berat'],3)."</td>";
                        echo "</tr>"; 
                    }
                    $sql2 ="SELECT paket.id_paket, paket.nama_paket, COUNT(transaksi.id_paket) AS paket, SUM(berat)
                    AS berat, SUM(total_bayar) AS bayar FROM transaksi JOIN paket ON transaksi.id_paket = paket.id_paket
                    WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y')";
                            
                            $hasil2 = mysqli_query($kon,$sql2);

                            if(!$hasil2){
                                die(mysqli_error($kon));
                            }

                            $row2 = mysqli_fetch_assoc($hasil2);
 
                            if( $row2['paket'] && $row2['berat']){
                                echo "<tr>";
                                echo "<th class='text-center' colspan='3'>Total</th>";
                                echo " <td> ".$row2['paket']."</td>";
                                echo " <td> ".number_format($row2['bayar'],2,',','.')."</td>";
                                echo " <td> ".round($row2['berat'],3)."</td>";
                                echo "</tr>"; 
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
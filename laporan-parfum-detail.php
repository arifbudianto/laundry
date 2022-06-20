<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Parfum</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Parfum</li>
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
        <a href="laporan-parfum-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-edit"></i> Laporan Parfum</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
            <center>
                <h1>LAPORAN PARFUM ATHAYA LAUNDRY</h1>
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
                        <th>ID PARFUM</th>
                        <th>PARFUM</th>
                        <th>JUMLAH PARFUM KELUAR</th>
                        <th>JUMLAH PEMINAT PARFUM</th>
                    </tr>
                    <?php
                    include "koneksi.php";
                    $no = 1;
                    $sql ="SELECT parfum.id_parfum, parfum.jenis_parfum, SUM(berat) AS JP, COUNT(parfum.jenis_parfum)
                            AS PK FROM transaksi JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum
                            WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y') GROUP BY id_parfum;";
                    $hasil = mysqli_query ($kon,$sql);               
                    while ($row = mysqli_fetch_array($hasil)){
                        $JP = $row['JP'];
                        $Par = $JP / 25;
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['id_parfum']."</td>";
                        echo " <td> ".$row['jenis_parfum']."</td>";
                        echo " <td> ".$Par."</td>";
                        echo " <td> ".$row['PK']."</td>";
                    }
                    $sql2 ="SELECT parfum.id_parfum, parfum.jenis_parfum, SUM(berat) AS JP, COUNT(parfum.jenis_parfum)
                    AS PK FROM transaksi JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum
                    WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y');";
                            
                            $hasil2 = mysqli_query($kon,$sql2);

                            if(!$hasil2){
                                die(mysqli_error($kon));
                            }

                            $row2 = mysqli_fetch_assoc($hasil2);
                            $JP2 = $row2['JP'];
                            $Par2 = $JP2/25; 
                            if( $row2['PK'] && $Par2){
                                echo "<tr>";
                                echo "<th class='text-center' colspan='3'>Total</th>";
                                echo "<th class='text-right'>".$Par2."</th>";
                                echo "<th class='text-right'>".$row2['PK']."</th>";
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
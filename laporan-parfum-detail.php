<?php
require('header.php');
require('sidebar.php');
require('koneksi.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Detail Parfum</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Detail Parfum</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<?php
$tgl_masuk =date('Y-m', strtotime($_GET["tgl_masuk"]));
$tgl_concate = $tgl_masuk."-00";
?>
<div class="content">
    <div class="container-fluid">
        <a href="laporan-parfum-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-header">
                <button class="btn btn-default btn-md btn-sm " id="btnPrint" ><i class="fa fa-print"></i> Print Data</button>
            </div>
            <div class="card-body " id="printData">
            <style>
                    @media print {
                        table {
                            font-family:arial;
                            border-collapse:collapse;
                            width:100%;
                        }
                        table.table{
                            font-size:12px;
                        }
                        table.table , table.table td, table.table th{
                            border:1px solid;
                        }
                        .text-center{
                            text-align:center;
                        }
                        .mb-0{
                            margin-bottom:0;
                        }
                        .pb-1{
                            padding-bottom:10px;
                        }
                        .text-right{
                            text-align:right;
                        }
                        .sub-judul{
                            font-size:12px;
                        }
                    }
                    table{
                        width:100%;
                    }
                    .mb-0{
                        margin-bottom:0;
                    }
                    .pb-1{
                        padding-bottom:10px;
                    }
                </style>
                <table border=0>
                    <tr>
                        <td class="text-center"><h3 class="mb-0">Laporan Detail Parfum Athaya Laundry</h3></td>
                    </tr>
                    <tr>
                        <td class="text-center pb-1 sub-judul">Periode :  <b><?php echo date('F Y', strtotime($tgl_masuk));?> </b></td>
                    </tr>
                </table>
                <table class="table table-bordered" cellspacing=0 cellpadding=5>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID Parfum</th>
                        <th class="text-center">Parfum</th>
                        <th class="text-center">Jumlah Parfum Keluar</th>
                        <th class="text-center">Jumlah Peminat Parfum</th>
                    </tr>
                    <?php
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
                        echo " <td class='text-right'> ".$Par."</td>";
                        echo " <td class='text-right'> ".$row['PK']."</td>";
                        echo " </tr> ";
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
                        echo "<th class='text-right' colspan='3'>Total</th>";
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
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

<?php    
require('footer.php');
?>

<script>
    function printData()
    {
        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printData").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
    
    $('#btnPrint').on('click',function(){
        printData();
    });
</script>
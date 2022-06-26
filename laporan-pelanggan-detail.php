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
                <h1 class="m-0">Laporan Detail Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Detail Customer</li>
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
        <a href="laporan-pelanggan-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
        <div class="card card-default">
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
                        <td class="text-center"><h3 class="mb-0">Laporan Detail Customer Athaya Laundry</h3></td>
                    </tr>
                    <tr>
                        <td class="text-center pb-1 sub-judul">Periode :  <b><?php echo date('F Y', strtotime($tgl_masuk));?> </b></td>
                    </tr>
                </table>
                <table class="table table-bordered" cellspacing=0 cellpadding=5>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">No. HP</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th class="text-center">Total Berat (Kg)</th>
                        <th class="text-center">Total Bayar (Rp.)</th>
                        <!-- <th>Berat (Kg)</th> -->
                        <!-- <th>Paket</th>
                        <th>Jenis Parfum</th> -->
                        <!-- <th>Total Bayar (Rp)</th> -->
                    </tr>
                    <?php
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
                        echo " <td class='text-right'> ".$row['JN']."</td>";
                        echo " <td class='text-right'> ".$row['TB']."</td>";
                        echo " <td class='text-right'> ".number_format($row['Jumlah'],2,',','.')."</td>";
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
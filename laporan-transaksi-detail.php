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
                <h1 class="m-0">Laporan Detail Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Detail Transaksi</li>
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
        <a href="laporan-transaksi-input.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
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
                <?php
                $no = 1;
                $sql = "SELECT COALESCE(SUM(berat),'') AS berat, COALESCE(SUM(total_bayar),'') AS total_bayar FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y')";
                $hasil = mysqli_query ($kon,$sql);
                $data = mysqli_fetch_array($hasil);
                $berat = $data['berat'];
                $pend = $data['total_bayar'];
                ?>
                <table border=0>
                    <tr>
                        <td class="text-center"><h3 class="mb-0">Laporan Transaksi Athaya Laundry</h3></td>
                    </tr>
                    <tr>
                        <td class="text-center pb-1 sub-judul">Periode :  <b><?php echo date('F Y', strtotime($tgl_masuk));?> </b></td>
                    </tr>
                </table>

            <!-- <table border = 0>
                <tr>
                    <td>Bulan </td>
                    <td> : </td>
                    <td> <?php echo date('F', strtotime($tgl_masuk));?> </td>
                </tr>
                <tr>
                    <td>Total Laundry Masuk </td>
                    <td> : </td>
                    <td> <?php echo round($berat,3);?> </td>
                </tr>
                <tr>
                    <td>Total Pendapatan </td>
                    <td> : </td>
                    <td> <?php echo "Rp.".number_format($pend,2,',','.');?> </td>
                </tr>
            </table> -->
                <table class="table table-bordered" cellspacing=0 cellpadding=5>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID Transaksi</th>
                        <th class="text-center">Tgl. Masuk</th>
                        <th class="text-center">Tgl. Selesai</th>
                        <th class="text-center">No. HP</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Berat (Kg)</th>
                        <th class="text-center">Total Bayar (Rp.)</th>
                    </tr>
                    <?php
                    
                    $no = 1;
                    $sql = "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
                    paket.nama_paket, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
                    FROM transaksi
                    JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
                    JOIN paket ON transaksi.id_paket = paket.id_paket
                    JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum WHERE DATE_FORMAT(tgl_masuk, '%M-%Y') = DATE_FORMAT('$tgl_concate', '%M-%Y') GROUP BY id_transaksi";
                    $hasil = mysqli_query ($kon,$sql);
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['id_transaksi']."</td>";
                        echo " <td> ".$row['tgl_masuk']."</td>";
                        echo " <td> ".$row['tgl_keluar']."</td>";
                        echo " <td> ".$row['nohp']."</td>";
                        echo " <td> ".$row['nama']."</td>";
                        echo " <td class='text-right'> ".$row['berat']."</td>";
                        echo " <td class='text-right'> ".number_format($row['total_bayar'],2,',','.')."</td>";
                        echo " </tr>";
                        
                    } 
                    echo "<tr><th colspan='6' class='text-right'>Total</th><th class='text-right'>".round($berat,3)."</th><th class='text-right'>".number_format($pend,2,',','.')."</th></tr>";
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
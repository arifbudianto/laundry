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
            <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <form action = "" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="container-fluid">  
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Filter</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="tgl_awal" class="col-sm-4 col-form-label">Bulanan <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "month" name ="tgl_awal" id="change_month" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type = "submit" value="Tampilkan" name = "tampil" class="btn btn-info" />
                            <input type = "reset" value="Reset" name = "reset" class="btn btn-default" />
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="container-fluid">
        <?php
        if(isset($_POST['tampil']) && isset($_POST['tgl_awal'])){
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_concate = $tgl_awal."-00";
            
        ?>
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
                        include "koneksi.php";
                        $no = 1;
                        $sql = "SELECT COALESCE(SUM(berat),'') AS TB, COALESCE(SUM(total_bayar),'') AS TP FROM transaksi where DATE_FORMAT(tgl_masuk, '%m') =  DATE_FORMAT('$tgl_concate', '%m') and DATE_FORMAT(tgl_masuk, '%Y') =  DATE_FORMAT('$tgl_concate', '%Y')";
                        $hasil = mysqli_query ($kon,$sql);
                        $data = mysqli_fetch_array($hasil);
                        $berat = $data['TB'];
                        $pend = $data['TP'];
                        $bulan = date('F Y', strtotime($tgl_awal));
                    ?>

                    <table border=0>
                        <tr>
                            <td class="text-center"><h3 class="mb-0">Laporan Transaksi Athaya Laundry</h3></td>
                        </tr>
                        <tr>
                            <td class="text-center pb-1">Periode :  <b><?php echo $bulan;?></b></td>
                        </tr>
                    </table>
                
                    
                    <table class="table table-bordered" cellspacing=0 cellpadding=5>
                        <tr>
                            <th>No.</th>
                            <th>Bulan</th>
                            <th class="text-right">Berat (Kg)</th>
                            <th class="text-right">Total Bayar (Rp)</th>
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
                                echo " <td class='text-right'> ".$row['berat']."</td>";
                                echo " <td class='text-right'> ".number_format($row['total_bayar'],2,',','.')."</td>";
                            }else{
                                echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                            }
                        } 
                    ?>
                    </table>
                </div>
            </div>
            <?php  }?>
        </div>
    </form>
    
</div>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<?php
require('footer.php');
?>

<script>
    function printData()
    {
        // var divToPrint=document.getElementById("printData");
        // newWin= window.open("");
        // newWin.document.write(divToPrint.outerHTML);
        // newWin.print();
        // newWin.close();

        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printData").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
    
    $('#btnPrint').on('click',function(){
        printData();
    });
</script>
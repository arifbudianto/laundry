<?php
require('header.php');
require('sidebar.php');
require('koneksi.php');
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Paket</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Paket</li>
                </ol>
            </div>
        </div>
    </div>
</div>

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
                                <label for="tgl_awal" class="col-sm-3 col-form-label">Dari Bulan <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <div class="form-inline mb-3">
                                        <div class="form-group">
                                            <input type = "month" name ="tgl_awal" id="tgl_awal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>&nbsp; s/d &nbsp;</label>
                                            <input type="month" class="form-control" name="tgl_akhir" id="tgl_akhir">
                                        </div>
                                    </div>
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
            $tgl_concate_x = $tgl_awal."-00";

            if($_POST['tgl_akhir'] != ''){
                $tgl_akhir = $_POST['tgl_akhir'];
                $tgl_concate_y = $tgl_akhir."-00";

            }else{
                $tgl_akhir = '';
                $tgl_concate_y = '';
            }
            
        ?>
            <div class="card card-default">
                <div class="card-header">
                    <button class="btn btn-default btn-md btn-sm " id="btnPrint" ><i class="fa fa-print"></i> Print Data</button>
                    <!-- <button class="btn btn-default btn-md btn-sm " id="btnGrafik" ><i class="fa fa-chart"></i> Grafik</button> -->
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
                        
                        // $no = 1;
                        // $sql = "SELECT COALESCE(SUM(berat),'') AS TB, COALESCE(SUM(total_bayar),'') AS TP FROM transaksi where DATE_FORMAT(tgl_masuk, '%m') =  DATE_FORMAT('$tgl_concate_x', '%m') and DATE_FORMAT(tgl_masuk, '%Y') =  DATE_FORMAT('$tgl_concate_x', '%Y')";
                        // $hasil = mysqli_query ($kon,$sql);
                        // $data = mysqli_fetch_array($hasil);
                        // $berat = $data['TB'];
                        // $pend = $data['TP'];
                        $bulan_x = date('F Y', strtotime($tgl_awal));

                        if($tgl_akhir != ''){
                            $bulan_y = ' - '.date('F Y', strtotime($tgl_akhir));
                        }else{
                            $bulan_y ='';
                        }

                    ?>

                    <table border=0>
                        <tr>
                            <td class="text-center"><h3 class="mb-0">Laporan Paket Athaya Laundry</h3></td>
                        </tr>
                        <tr>
                            <td class="text-center pb-1 sub-judul">Periode :  <b><?php echo $bulan_x . $bulan_y;?> </b></td>
                        </tr>
                    </table>
                
                    
                    <table class="table table-bordered" cellspacing=0 cellpadding=5>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Periode Bulan</th>
                            <th class="text-center">Jumlah Paket</th>
                            <th class="text-center">Jumlah Pendapatan</th>
                            <th class="text-center">Operasi</th>
                        </tr>
            
                        <?php

                        if($_POST['tgl_akhir'] == ''){
                            $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(COUNT(id_paket),'') AS paket, COALESCE(SUM(total_bayar),'') AS biaya FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') =  DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_x', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                        }else{
                            $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(COUNT(id_paket),'') AS paket, COALESCE(SUM(total_bayar),'') AS biaya FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                               
                        }

                        $hasil = mysqli_query ($kon,$sql);

                        if(!$hasil){
                            die(mysqli_error($kon));
                        }

                        $count = mysqli_num_rows($hasil);

                        if($count > 0){
                            $no=1;
                            while ($row = mysqli_fetch_assoc($hasil)){
                                echo " <tr> ";
                                echo " <td> ".$no++."</td>";
                                echo " <td> ".date('F Y', strtotime($row['tgl_masuk']))."</td>";
                                echo " <td class='text-right'> ".$row['paket']."</td>";
                                echo " <td class='text-right'> ".number_format($row['biaya'],2,',','.')."</td>";
                                echo " <td class='text-center'>";
                                echo "<a href = 'laporan-paket.php?tgl_masuk=".$row['tgl_masuk']."' title='View'><i class='fa fa-eye text-info'></i></a>";
                                echo "</td>";
                                echo " </tr> ";
                            } 
                        }else{
                            echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                        
                        }

                        if($_POST['tgl_akhir'] != ''){
                            $sql2 ="SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(COUNT(id_paket),'') AS paket, COALESCE(SUM(total_bayar),'') AS biaya FROM transaksi WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m')";
                            
                            $hasil2 = mysqli_query($kon,$sql2);

                            if(!$hasil2){
                                die(mysqli_error($kon));
                            }

                            $row2 = mysqli_fetch_assoc($hasil2);
                            

                            if( $row2['paket'] && $row2['biaya'] ){
                                echo "<tr>";
                                echo "<th class='text-center' colspan='2'>Total</th>";
                                echo " <td class='text-right'> ".$row2['paket']."</td>";
                                echo " <td class='text-right'> ".number_format($row2['biaya'],2,',','.')."</td>";
                                echo "</tr>";
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
        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printData").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
    
    $('#btnPrint').on('click',function(){
        printData();
    });

</script>
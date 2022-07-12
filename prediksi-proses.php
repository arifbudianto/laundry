<?php
require('header.php');
require('sidebar.php');
require('koneksi.php');
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Prediksi Kebutuhan Parfum</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Prediksi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <!-- <form action = "" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="container-fluid">  
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Filter</h5>
                        </div>
                        <?php
                        // if ($jenis_prediksi == "Berat"){?>
                            <div class="card-body">
                                <div class="form-group row">
                                <label for="parfum_prediksi" class="col-sm-5 col-form-label">Berat parfum yang akan diprediksi (Kg)<i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input name = "parfum_prediksi" type = "text" class="form-control" id="parfum_prediksi" required>
                                </div>
                            </div>
                        <?php //} else {?>
                            <div class="card-body">
                                <div class="form-group row">
                                <label for="berat_prediksi" class="col-sm-4 col-form-label">Berat Laundry yang akan diprediksi (L)<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "berat_prediksi" type = "text" class="form-control" id="berat_prediksi" required> 
                                </div>
                                
                            </div>
                        <?php //} ?>
                        </div>
                        <div class="card-footer">
                            <input type = "submit" value="Prediksi" name = "tampil" class="btn btn-info" />
                            <input type = "reset" value="Reset" name = "reset" class="btn btn-default" />
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </form>
</div> -->
        <?php
        if(isset($_POST['prediksi']) && isset($_POST['tgl_awal'])){
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_concate_x = $tgl_awal."-00";

            $jenis_parfum = $_POST['jenis_parfum'];
            $jenis_prediksi = $_POST['jenis_prediksi'];

            if($_POST['tgl_akhir'] != ''){
                $tgl_akhir = $_POST['tgl_akhir'];
                $tgl_concate_y = $tgl_akhir."-00";

            }else{
                $tgl_akhir = '';
                $tgl_concate_y = '';
            }
            $bulan_x = date('F Y', strtotime($tgl_awal));

            if($tgl_akhir != ''){
                $bulan_y = ' - '.date('F Y', strtotime($tgl_akhir));
            }else{
                $bulan_y ='';
            }
        ?>
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">
                        <button class="btn btn-default btn-md btn-sm " id="btnPrint" ><i class="fa fa-print"></i> Print Data</button>
                    </div>
                    <div class="card-body " id="printData">
                        <style>
                            @media print {
                                table,.card-body {
                                    font-family:arial;
                                    border-collapse:collapse;
                                    width:100%;
                                }
                                table.table,.card-body{
                                    font-size:12px;
                                }
                                table.table , table.table td, table.table th{
                                    border:1px solid;
                                }
                                .text-center{
                                    text-align:center;
                                }
                                .text-left{
                                    text-align:left;
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
                            
                            // $bulan_x = date('F Y', strtotime($tgl_awal));

                            // if($tgl_akhir != ''){
                            //     $bulan_y = ' - '.date('F Y', strtotime($tgl_akhir));
                            // }else{
                            //     $bulan_y ='';
                            // }

                        ?>

                        <table border=0>
                            <tr>
                                <td class="text-center"><h3 class="mb-0">Prediksi Kebutuhan Parfum Athaya Laundry</h3></td>
                            </tr>
                            <tr>
                                <td class="text-center pb-1 sub-judul">Periode :  <b><?php echo $bulan_x . $bulan_y;?> </b></td>
                            </tr>
                        </table>
                    
                        <!-- Menampilkan Tabel Prediksi -->
                        <table class="table table-bordered mb-3" cellspacing=0 cellpadding=5>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Berat Laundry(X)</th>
                                <th class="text-center">Berat Parfum (Y)</th>
                                <th class="text-center">X²</th>
                                <th class="text-center">XY</th>
                            </tr>
                
                            <?php
                            if($_POST['tgl_akhir'] == ''){
                                $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') =  DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_x', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                            }else{
                                $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                                
                            }
                            $hasil = mysqli_query ($kon,$sql);

                            if(!$hasil){
                                die(mysqli_error($kon));
                            }

                            $a = 0;
                            $b = 0;
                            $no = 1;
                            $jumx = 0;
                            $jumy = 0;
                            $jumxx = 0;
                            $jumxy = 0;
                            $jumx2 = 0;
                            $persamaan_reg_y='';
                            $persamaan_reg_y2='';
                            $count = mysqli_num_rows($hasil);

                            if($count > 0){
                                while ($row = mysqli_fetch_assoc($hasil)){
                                    echo " <tr> ";
                                    echo " <td> ".$no++."</td>";
                                    echo " <td class='text-right'> ".round($row['berat'],3)."</td>";
                                    echo " <td class='text-right'> ".round($row['berat']/25,3)."</td>";
                                    echo " <td class='text-right'> ".round($xx = ($row['berat']) * ($row['berat']),3)."</td>";
                                    echo " <td class='text-right'> ".round($xy = ($row['berat']) * ($row ['berat']/25),3)."</td>";
                                    echo " </tr> ";
                                    $jumx = $jumx + round($row['berat'],3);
                                    $jumy = $jumy + round($row['berat']/25,3);
                                    $jumxx = $jumxx + ($row['berat'] * $row['berat']);
                                    $jumxy = $jumxy + ($row['berat'] * $row['berat']/25);
                                } 
                                // Menampilkan nilai a dan b
                                // if($_POST['tgl_akhir'] != ''){
                                //     $sql2 ="SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m')";
                                    
                                //     $hasil2 = mysqli_query($kon,$sql2);

                                //     if(!$hasil2){
                                //         die(mysqli_error($kon));
                                //     }
                                //     $no = $no-1;
                                //     $row2 = mysqli_fetch_assoc($hasil2);
                                $no = $no-1;
                                if($_POST['tgl_akhir'] == ''){
                                    $sql2 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') =  DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_x', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                                }else{
                                    $sql2 = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m') group by DATE_FORMAT(tgl_masuk, '%Y-%m')";
                                    
                                }
                                $hasil2 = mysqli_query ($kon,$sql2);
        
                                if(!$hasil2){
                                    die(mysqli_error($kon));
                                }

                                $row2 = mysqli_fetch_assoc($hasil2);
                                    
                                if($row2['berat']){
                                    echo "<tr>";
                                    echo "<th>Total</th>";
                                    echo "<th class='text-right'>".$jumx."</th>";
                                    echo "<th class='text-right'>".$jumy."</th>";
                                    echo "<th class='text-right'>".round($jumxx,3)."</th>";
                                    echo " <th class='text-right'> ".round($jumxy,3)."</td>";
                                    echo "</tr>";
                                }
                                try{
                                    $b = (($no * $jumxy) - ($jumx * $jumy))/(($no * $jumxx) - ($jumx * $jumx));
                                }catch(DivisionByZeroError $e){ 
                                }
                                if ($b != 0){
                                    $b = (($no * $jumxy) - ($jumx * $jumy))/(($no * $jumxx) - ($jumx * $jumx));
                                    $a = ($jumy - ($b * $jumx)) / $no;
                                    echo "<th colspan = 4 class='text-left'>Koefisien b</th>";
                                    echo "<th class='text-right'>".round($b,3)." </th>";
                                    echo "</tr> ";
                                    echo "<tr>";
                                    echo "<th colspan = 4 class='text-left'>Konstanta a </th>";
                                        if (is_numeric($b)){
                                            echo "<th class='text-right'>". round($a,3) ."</th>";
                                        }
                                    echo "</tr>";
                                    $persamaan_reg_y="Persamaan Regresi :<br/> Y = a + bX <br/>";
                                    $persamaan_reg_y2="Y = ".round($a,3)." + ".round($b,3)."X <br/>";
                                }else {
                                    $a = ($jumy - ($b * $jumx)) / $no;
                                    echo "<th colspan = 4 class='text-left'>Koefisien b</th>";
                                    echo "<th class='text-right'> 0 </th>";
                                    echo "</tr> ";
                                    echo "<tr>";
                                    echo "<th colspan = 4 class='text-left'>Konstanta a </th>";
                                    if (is_numeric($b)){
                                        echo "<th class='text-right'>". round($a,3) ."</th>";
                                    }
                                    echo "</tr>";
                                    $persamaan_reg_y="Persamaan Regresi : <br/> Y = a + bX <br/>";
                                    $persamaan_reg_y2="Y = ".round($a,3)." + 0 X <br/>";
                                }
                                
                                ?>
                                
                            <?php
                                        
                            }else{
                                echo "<tr><td colspan =5 class='text-center'>Tidak ada data</td></tr>"; 
                            }
                            ?>
                        </table>
                        <div class="card card-default">
                            <!-- /.card-header -->
                            <div class="card-body ">
                            <?php
                                
                                // if($_POST['tgl_akhir'] == ''){
                                //     $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') =  DATE_FORMAT('$tgl_concate_x ', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m')";
                                // }else{
                                //     $sql = "SELECT DATE_FORMAT(tgl_masuk, '%Y-%M') as tgl_masuk, COALESCE(SUM(berat),'') AS berat FROM transaksi WHERE jenis_parfum = '$jenis_parfum' AND DATE_FORMAT(tgl_masuk, '%Y-%m') BETWEEN DATE_FORMAT('$tgl_concate_x', '%Y-%m') and DATE_FORMAT('$tgl_concate_y', '%Y-%m') GROUP BY DATE_FORMAT(tgl_masuk, '%Y-%m')";
                                    
                                // }
                                // $hasil = mysqli_query ($kon,$sql);
                                // $data = mysqli_fetch_array($hasil);
                                // $bulan = date('n', strtotime('+1 month', strtotime($tgl_akhir)));

                                // Perhitungan jenis prediksi 'parfum'
                                if ($_POST['berat_prediksi'] != ''){
                                    $berat_prediksi = $_POST['berat_prediksi'];
                                    echo $persamaan_reg_y;
                                    echo $persamaan_reg_y2;
                                    echo "Y = ".round($a,3)." + ".round($b,3). "(".$berat_prediksi.") <br/>" ;  
                                    echo "Y = ".round(($a + ($b * $berat_prediksi)),3)."<br/>" ;
                                        if (is_numeric($b) && is_numeric($a)){
                                            $prediksi = $a + ($b * $berat_prediksi);
                                        }
                                    $bulan_y = date('F', strtotime('+1 month', strtotime($tgl_akhir)));
                                    echo "<p>Hasil prediksi untuk parfum <b>".$jenis_parfum."</b> pada bulan <b> ".$bulan_y."</b> dengan berat laundry <b>".$berat_prediksi." kg</b> adalah <b>".round($prediksi,3)." liter</b>";
                                }
                                // Perhitungan jenis prediksi 'berat'
                                else {
                                    $parfum_prediksi = $_POST['parfum_prediksi'];

                                    echo $persamaan_reg_y;
                                    echo $persamaan_reg_y2;
                                    echo "X = ".round($a,3)." - ".$parfum_prediksi."/".round($b,3)."<br/>" ;  
                                    echo "Y = ".round(($a - $parfum_prediksi / $b),3)."<br/>" ;
                                        if (is_numeric($b) && is_numeric($a)){
                                            $prediksi = ($a - $parfum_prediksi / $b);
                                        }
                                    $bulan_y = date('F', strtotime('+1 month', strtotime($tgl_akhir)));
                                    echo "<p>Hasil prediksi untuk parfum <b>".$jenis_parfum."</b> pada bulan <b> ".$bulan_y."</b> dengan berat parfum <b>".$parfum_prediksi." liter</b> adalah <b>".round($prediksi,3)." kg</b>";
                                }
                                    
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
    <!-- </form> -->
    
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
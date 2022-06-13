<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Prediksi Proses</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="prediksi-form.php">Prediksi Kebutuhan Parfum</a></li>
                    <li class="breadcrumb-item active">Prediksi Proses</li>
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
    if(isset($_POST['prediksi'])){
        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];
        $jenis_parfum = $_POST['jenis_parfum'];
        
        $dataValid = "YA";

        $err_tgl_awal='';
        $err_tgl_akhir='';
        $err_jenis_parfum='';
        $err_valid='';

        if (strlen(trim($tgl_awal))==0){
            $err_tgl_awal= "Tanggal Awal Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($tgl_akhir))==0){
            $err_tgl_akhir= "Tanggal Masuk Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($jenis_parfum))==0){
            $err_jenis_parfum= "Jenis Parfum Harap di Isi !<br/>";
            $dataValid ="TIDAK";
        }
        if ($dataValid=="TIDAK"){
            $err_valid= "Masih ada kesalahan, silahkan perbaiki !<br/>";
            
        }

        if(strlen(trim($tgl_awal))==0 || strlen(trim($tgl_akhir))==0 || strlen(trim($jenis_parfum))==0 || $dataValid=="TIDAK"){

            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_tgl_awal;
                    echo $err_tgl_akhir;
                    echo $err_jenis_parfum;
                    echo $err_valid;       
                ?>
            </div>
            <a href="prediksi-form.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
        <?php
        exit;
        }
    ?>
        <a href="prediksi-form.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Kembali</a>
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body ">
                <table class="table table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>ID Transaksi</th>
                        <th>Tgl.</th>
                        <th>No. HP</th>
                        <th>Jenis Parfum</th>
                        <th>ID Parfum (X)</th>
                        <th>Berat (Y)</th>
                        <th>X²</th>
                        <th>XY</th>
                    </tr>
                    <?php
                    include "koneksi.php";
                    $sql = "SELECT id_transaksi, tgl_masuk, pelanggan.nohp, parfum.id_parfum, parfum.jenis_parfum, berat FROM transaksi
                    JOIN pelanggan ON transaksi.nohp = pelanggan.nohp JOIN parfum
                    ON transaksi.jenis_parfum = parfum.jenis_parfum WHERE tgl_masuk between '$tgl_awal' and '$tgl_akhir';";
                    $hasil = mysqli_query ($kon,$sql);
                    $a=0;
                    $b=0;
                    $x = 1;
                    $no = 0;
                    $jumx = 0;
                    $jumy = 0;
                    $jumxx = 0;
                    $jumxy = 0;
                    $jumx2 = 0;
                    $persamaan_reg_y='';
                    $persamaan_reg_y2='';

                    if (mysqli_num_rows($hasil)>0){
                        while ($data = mysqli_fetch_array($hasil)){
                            echo "<tr>";
                            echo "<td>".($no=$no+$x)."</td>";
                            echo "<td>".$data['id_transaksi']."</td>";
                            echo "<td>".$data['tgl_masuk']."</td>";
                            echo "<td>".$data['nohp']."</td>";
                            echo "<td>".$data['jenis_parfum']."</td>";
                            echo "<td>".$data['id_parfum']."</td>";
                            echo "<td>".$data['berat']."</td>";
                            echo "<td>".($xx = ($data['id_parfum'] * $data['id_parfum']))."</td>";
                            echo "<td>".($xy = ($data['id_parfum'] * $data['berat']))."</td>";
                            echo "</tr>";
                            $jumx = $jumx + $data['id_parfum'];
                            $jumy = $jumy + $data['berat'];
                            $jumxx = $jumxx + $xx;
                            $jumxy = $jumxy + $xy;
                            $ratax = $jumx / $no;
                            $ratay = $jumy / $no;
 
                        }
                        
                        try{
                            $b = (($no * $jumxy) - ($jumx * $jumy))/(($no * $jumxx) - ($jumx * $jumx));
                        }catch(DivisionByZeroError $e){ 
                        }

                        echo "<tr>";
                        echo "<td colspan = 5>Jumlah</td>";
                        echo "<td>".$jumx."</td>";
                        echo "<td>".$jumy."</td>";
                        echo "<td>".$jumxx."</td>";
                        echo "<td>".$jumxy."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan = 5>Rata - Rata</td>";
                        echo "<td>".$ratax."</td>";
                        echo "<td>".$ratay."</td>";
                        echo "<td colspan = 2></td>";
                        echo "</tr>";
                        echo "<tr>";
                        
                        if ($b != 0){
                            $b = (($no * $jumxy) - ($jumx * $jumy))/(($no * $jumxx) - ($jumx * $jumx));
                            $a = ($jumy - ($b * $jumx)) / $no;
                            echo "<td colspan = 5>Koefisien b</td>";
                            echo "<td>".$b." </td>";
                            echo "</tr> ";
                            echo "<tr>";
                            echo "<td colspan = 5>Konstanta a </td>";
                                if (is_numeric($b)){
                                    echo "<td>". $a ."</td>";
                                }
                            echo "</tr>";
                            $persamaan_reg_y="Persamaan Regresi :<br/> Y = a + bX <br/>";
                            $persamaan_reg_y2="Y = ".$a." + ".$b."X <br/>";
                        }else {
                            $a = ($jumy - ($b * $jumx)) / $no;
                            echo "<td colspan = 5>Koefisien b</td>";
                            echo "<td> 0 </td>";
                            echo "</tr> ";
                            echo "<tr>";
                            echo "<td colspan = 5>Konstanta a </td>";
                            if (is_numeric($b)){
                                echo "<td>". $a ."</td>";
                            }
                            echo "</tr>";
                            $persamaan_reg_y="Persamaan Regresi : <br/> Y = a + bX <br/>";
                            $persamaan_reg_y2="Y = ".$a." + 0 X <br/>";
                        }

                        ?>
                        <div class="card card-default">
                            <!-- /.card-header -->
                            <div class="card-body ">
                            <?php
                                $jenis_parfum = $_POST['jenis_parfum'];
                                include "koneksi.php";
                                $jenis_parfum = $_POST['jenis_parfum'];
                                $sql = "SELECT id_transaksi, tgl_masuk, pelanggan.nohp, parfum.id_parfum, parfum.jenis_parfum, berat FROM transaksi
                                    JOIN pelanggan ON transaksi.nohp = pelanggan.nohp JOIN parfum
                                    ON transaksi.jenis_parfum = parfum.jenis_parfum WHERE parfum.jenis_parfum = '$jenis_parfum'";
                                $hasil = mysqli_query ($kon,$sql);
                                $data = mysqli_fetch_array($hasil);
                                $jenis_parfum = $data['jenis_parfum'];
                                $id_parfum   = $data['id_parfum'];  
                                // echo $jenis_parfum;
                                // echo $id_parfum;
                                echo $persamaan_reg_y;
                                echo $persamaan_reg_y2;
                                echo "Y = ".$a." + ".$b. "(".$id_parfum.") <br/>" ;  
                                echo "<p>Y = ".$a + ($b * $id_parfum)."</p>" ;
                                if (is_numeric($b) && is_numeric($a)){
                                    $prediksi = $a + ($b * $id_parfum);
                                }
                                echo "<p>Hasil prediksi untuk parfum <b>".$jenis_parfum."</b> dengan <b>ID ".$id_parfum."</b> adalah <b>".$prediksi."</b>. </p>";
                                $jumparfuml = $prediksi / 25;
                                $jumparfumml = $jumparfuml * 1000;
                                echo "Jumlah parfum = Y / 25 <br/>";
                                echo "Jumlah parfum = ".$prediksi." / 25 </p> ";
                                echo "<p>Parfum yang dibutuhkan selanjutnya yaitu <b>".$jumparfuml." liter</b> atau <b>".$jumparfumml." ml</b>.</p>";
                                ?>
                            </div>
                        </div>
                        <?php
                            
                    }else{
                        echo "<tr><td colspan = 9 class='text-center'>Tidak ada data</td></tr>"; 
                    }
                // }  
                ?>
                </table>
                
            </div>
        </div>
        
    </div>
</div>

<?php            
}
require('footer.php');

?>
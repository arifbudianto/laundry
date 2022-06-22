<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Data Transaksi Simpan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Data Transaksi Simpan</li>
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
        include "koneksi.php";

        $tgl_masuk      = $_POST['tgl_masuk'];
        $nohp           = $_POST['nohp'];
        $id_paket       = $_POST['id_paket'];
        $jenis_parfum   = $_POST['jenis_parfum'];
        $berat          = $_POST['berat'];


        if (isset($_POST['id_transaksi'])){
            $id_transaksi = $_POST['id_transaksi'];
            
            $simpan  = "EDIT";
        }
        else{
            $simpan = "BARU";
        }

    
        $dataValid = "YA";

        $err_tgl_masuk='';
        $err_nohp='';
        $err_berat='';
        $err_id_paket='';
        $err_jenis_parfum='';
        $err_valid='';

        if (strlen(trim($tgl_masuk))==0){
            $err_tgl_masuk= "Tanggal Masuk harus diisi!<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($nohp))==0){
            $err_nohp= "Nomor HP harus diisi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($berat))==0){
            $err_berat= "Berat laundry harus diisi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($id_paket))==0){
            $err_id_estimasi= "Estimasi waktu harus diisi !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($jenis_parfum))==0){
            $err_jenis_parfum= "Jenis parfum harus diisi !<br/>";
            $dataValid ="TIDAK";
        }
        if ($dataValid=="TIDAK"){
            $err_valid= "Masih ada kesalahan, silahkan perbaiki!<br/>";
           
        }

        if (!is_numeric($nohp)){
           
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo 'No Hp is not numeric <br/>'; 
                ?>
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
            <?php
        }
        if (!is_numeric($berat)){
           
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo 'Berat is not numeric ';
                ?>
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
            <?php
        }

        if(strlen(trim($tgl_masuk))==0 || strlen(trim($nohp))==0 || strlen(trim($berat))==0 || strlen(trim($id_paket))==0 || strlen(trim($jenis_parfum))==0 || $dataValid=="TIDAK"){

            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_tgl_masuk;
                    echo $err_nohp;
                    echo $err_berat;
                    echo $err_id_paket;
                    echo $err_jenis_parfum;
                    echo $err_valid;  
                ?>
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
            <?php
            exit;
        }

        $sqltgl = "SELECT tgl_masuk as tgl from transaksi WHERE tgl_masuk = '$tgl_masuk'";
        $querytgl = mysqli_query($kon,$sqltgl);
        $datatgl = mysqli_fetch_array($querytgl);
        

        if(isset($datatgl['tgl'])){
            $tglid = date('Ymd', strtotime($datatgl['tgl']));
            $sql = "SELECT max(id_transaksi) as kodeTerbesar FROM transaksi WHERE id_transaksi LIKE '$tglid%'";
            $query = mysqli_query($kon, $sql);
            $data = mysqli_fetch_array($query);
            $kode = $data['kodeTerbesar'];
        }else{
            $tglid = date('Ymd', strtotime($tgl_masuk));
            $kode = $tglid;
        }
        
        
       
        $sql = "SELECT * FROM paket where id_paket = '$id_paket'";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_array($hasil);
        $harga = $data['harga'];

        $total_bayar = 0;
        if($id_paket=='K01' || $id_paket=='K02' || $id_paket=='K03' || $id_paket=='K04' || $id_paket=='S01' || $id_paket=='S02' || $id_paket=='CB4' || $id_paket=='CK4'){
            $total_bayar = $harga * $berat;
        }else{
            $total_bayar = $harga;
        }
        

        $sql2 = "SELECT nohp FROM pelanggan where nohp = '$nohp'";
        $hasil2 = mysqli_query($kon,$sql2);
        $data2  = mysqli_fetch_array($hasil2);

        if ($data2 && $data2['nohp'] !== NULL){
            if ($simpan == "EDIT"){
                if (empty($_POST['tgl_keluar'])){
                    $tgl_keluar = 'NULL';
                }else{
                    $tgl_keluar = "'".$_POST['tgl_keluar']."'";
                }
                $sql = "UPDATE transaksi set
                    nohp        = '$nohp',
                    tgl_masuk   = '$tgl_masuk',
                    tgl_keluar  = $tgl_keluar,
                    berat       = $berat,
                    id_paket = '$id_paket',
                    jenis_parfum = '$jenis_parfum',
                    total_bayar = $total_bayar
                    WHERE id_transaksi = '$id_transaksi'";

            }
            else{
                $urutan = substr($kode, 8, 3);
                $urutan++;
                $id_transaksi = $tglid . sprintf("%03s", $urutan);

                $sql = "insert into transaksi
                (id_transaksi, nohp, tgl_masuk, tgl_keluar, berat, id_paket, jenis_parfum, total_bayar)
                    values
                ('$id_transaksi','$nohp',  '$tgl_masuk', NULL ,$berat, '$id_paket', '$jenis_parfum', $total_bayar)";
            }
            
            $hasil = mysqli_query($kon, $sql);
            if($hasil){
                ?>

                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check"></i> Data Berhasil Disimpan!
                </div>
                <a href="trans-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Kembali</a>
                <a href="nota-cetak.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-print"></i></break> Cetak Nota</a>
                <?php
            }else {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-close"></i> Gagal Simpan!
                </div>

                <?php
                echo mysqli_error($kon);
                ?>
                <a href="#" class="mb-3 btn btn-info btn-md" onclick="self.histry.back()"><i class="fa  fa-angle-left"></i> Kembali</a>

                <?php
                exit;
            }
        }else {
            if (!is_numeric($nohp))
            {
                echo '';
            }else{
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-close"></i> Nomor Tidak Terdaftar !
                </div>
                <a href="trans-tampil.php" class="mb-3 btn btn-info btn-md" ><i class="fa  fa-angle-left"></i> Kembali</a>
                <?php
            }
            
        }
        
        ?>
    </div>
</div>
<?php
require('footer.php');
?>
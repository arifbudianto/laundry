
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
        <h1 class="m-0">Simpan Data</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Simpan Data</li>
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
        
            $paket_laundry = $_POST['paketLaundry'];
            $harga = $_POST['harga'];

            if (isset($_POST['id_paket'])){
                $id_paket = $_POST['id_paket'];
                
                $simpan  = "EDIT";
            }
            else{
                $simpan = "BARU";
            }

            $dataValid = "YA";

            $err_harga='';
            $err_paket_laundry='';
            $err_valid='';

            if (strlen(trim($harga))==0){
                $err_harga ="Harap isi Harga !<br/>";
                $dataValid ="TIDAK";
            }else if(strlen(trim($paket_laundry))==0){
                $err_paket_laundry ="Harap isi Paket Laundry !<br/>";
                $dataValid ="TIDAK";
            }
            if ($dataValid=="TIDAK"){
                $err_valid="Masih ada kesalahan, silahkan perbaiki !<br/>";
            
            }

            if(strlen(trim($harga))==0 || strlen(trim($paket_laundry))==0 || $dataValid=="TIDAK"){
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php
                        echo $err_paket_laundry;
                        echo $err_harga;
                        echo $err_valid;
                    ?>
                </div>
                <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
                <?php
                exit;
            }

            if (!is_numeric($harga))
            {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-times"></i> Bukan Angka !
                </div>
                <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
                
                <?php
                exit;
            }
        
        
            if($simpan == 'EDIT')
            {
                $sql = "UPDATE paket SET
                        harga = $harga,
                        nama_paket = '$paket_laundry'
                        where id_paket = '$id_paket'";
                $hasil = mysqli_query($kon, $sql);
            }else{
                $sql2 = "SELECT MAX(CAST(SUBSTRING(id_paket, 2, length(id_paket)-1) AS UNSIGNED)) AS kode FROM paket WHERE id_paket LIKE 'B%'";
                $hasil2 = mysqli_query($kon, $sql2);
                $row = mysqli_fetch_assoc($hasil2);
                $kode = $row['kode'] + 1;

                $sql = "INSERT INTO paket (id_paket,nama_paket,harga) values ('B$kode','$paket_laundry',$harga)";
                $hasil =mysqli_query($kon,$sql);

            }

            if($hasil){
                ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check"></i> Data Berhasil Disimpan !
                </div>
                <a href="paket-tampil.php" class="mb-3 btn btn-info btn-md" ><i class="fas fa-angle-left"></i> Daftar Harga Paket</a>
                
                <?php
            }else {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-times"></i> Gagal Simpan!
                </div>

                <?php
                echo mysqli_error($kon);
                ?>
                <a href="#" class="mb-3 btn btn-info btn-md" onclick="self.histry.back()"><i class="fa  fa-angle-left"></i> Kembali</a>

                <?php
                exit;
            }
        ?>
    </div>
</div>
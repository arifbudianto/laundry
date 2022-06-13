<?php
require('header.php');
require('sidebar.php');
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
        $id_parfum          =   $_POST['id_parfum'];
        $jenis_parfum       =   $_POST['jenis_parfum'];
        $kode_parfum       =   $_POST['kode_parfum'];

        $dataValid = "YA";

        $err_idparfum='';
        $err_jenis_parfum='';
        $err_valid='';

        if (strlen(trim($id_parfum))==0){
            $err_idparfum ="Harap isi ID Parfum !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($jenis_parfum))==0){
            $err_jenis_parfum="Harap isi Jenis Parfum !<br/>";
            $dataValid ="TIDAK";
        }
        if ($dataValid=="TIDAK"){
            $err_valid= "Masih ada kesalahan, silahkan perbaiki !<br/>";
            
        }

        if(strlen(trim($id_parfum))==0 || strlen(trim($jenis_parfum))==0 || $dataValid=="TIDAK"){

            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_idparfum;
                    echo $err_jenis_parfum;
                    echo $err_valid;
                ?>
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
            <?php
            exit;
        }
        include "koneksi.php";

        $sql = "update parfum set
                id_parfum       =   '$id_parfum',
                jenis_parfum    =   '$jenis_parfum'
                where kode_parfum = '$kode_parfum'";
        $hasil = mysqli_query($kon, $sql);

        if($hasil){
            ?>

            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-check"></i> Data Berhasil Disimpan!
            </div>
            <a href="parfum-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-box"></i> Data Parfum</a>
            
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
<?php
require('footer.php');
?>
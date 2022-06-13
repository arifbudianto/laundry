
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
        if (isset($_POST['kode_barang'])){
            $kode_barang   =   $_POST['kode_barang'];
            $simpan =   "EDIT";
        } else {
            $simpan = "BARU";
        }

        $nama_barang    = $_POST['nama_barang'];
        $harga_barang   = $_POST['harga_barang'];

        $dataValid = "YA";

        $err_nama_barang='';
        $err_harga_barang='';
        $err_valid='';

        if (strlen(trim($nama_barang))==0){
            $err_harga="Harap isi Nama Barang !<br/>";
            $dataValid ="TIDAK";
        }
        if (strlen(trim($harga_barang))==0){
            $err_harga="Harap isi Harga !<br/>";
            $dataValid ="TIDAK";
        }
        if ($dataValid=="TIDAK"){
            $err_valid="Masih ada kesalahan, silahkan perbaiki !<br/>";
           
        }

        if(strlen(trim($harga_barang))==0 || $dataValid=="TIDAK"){
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php
                    echo $err_nama_barang;
                    echo $err_harga_barang;
                    echo $err_valid;
                ?>
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali ke Halaman Sebelumnya</a>
            <?php
            exit;
        }

        include "koneksi.php";
        $sql = "SELECT max(kode_barang) as kd FROM barang";
            $query = mysqli_query($kon, $sql);
            $data = mysqli_fetch_array($query);
            $kode = $data['kd'];
       
        $urutan = substr($kode, 1);
        $urutan++;
        $kode_barang = "B" . sprintf("%02s", $urutan);

        if (!is_numeric($harga_barang))
        {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-times"></i> Bukan Angka !
            </div>
            <a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali ke Halaman Sebelumnya</a>
            
            <?php
        }else{
            if ($simpan == "EDIT"){
                $sql = "UPDATE barang SET
                        nama_barang     =   '$nama_barang',
                        harga_barang    =   '$harga_barang'
                        where kode_barang = '$kode_barang'";
                
            }else {
                    $sql = "insert into barang
                        (kode_barang,nama_barang, harga_barang)
                        values
                        ('$kode_barang','$nama_barang','$harga_barang')";
                }
            $hasil = mysqli_query($kon, $sql);

            if($hasil){
                ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check"></i> Data Berhasil Disimpan !
                </div>
                <a href="barang-tampil.php" class="mb-3 btn btn-info btn-md" ><i class="fa fa-book"></i> Daftar Harga Per Barang</a>
                
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
        }
        ?>
    </div>
</div>
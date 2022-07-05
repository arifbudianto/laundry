<?php
require('header.php');
require('sidebar.php');

$id_transaksi = $_GET["id_transaksi"];
include "koneksi.php";
$sql = "select * from transaksi where id_transaksi = '$id_transaksi'";
$hasil = mysqli_query($kon, $sql);
if (!$hasil) die ("Gagal Query...");

$data = mysqli_fetch_array($hasil);
$id_transaksi   = $data["id_transaksi"];
$tgl_masuk      = $data["tgl_masuk"];
$tgl_keluar     = $data["tgl_keluar"];
$nohp           = $data["nohp"];
$berat          = $data["berat"];
$id_paket    = $data["id_paket"];
$jenis_parfum      = $data["jenis_parfum"];
$status = $data["status"];

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Edit Data Transaksi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="trans-tampil.php">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active">Edit Data Transaksi</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <a href="trans-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Daftar Transaksi</a>
                <div class="card">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action = "trans-simpan.php" method = "post" enctype = "multipart/form-data" class="form-horizontal">
                        <input type = "hidden" name = "id_transaksi" value = "<?php echo $id_transaksi;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="tgl_masuk" class="col-sm-4 col-form-label">Tgl. Masuk <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "tgl_masuk" type = "date" value = "<?php echo $tgl_masuk;?>" class="form-control" id="tgl_masuk" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_keluar" class="col-sm-4 col-form-label">Tgl. Keluar <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "tgl_keluar" type = "date" value = "<?php echo $tgl_keluar;?>" class="form-control" id="tgl_keluar" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-4 col-form-label">No. HP <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "nohp" type = "text" value = "<?php echo $nohp;?>" class="form-control" id="nohp" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="berat" class="col-sm-4 col-form-label">Berat <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="berat" value = "<?php echo $berat;?>" id="berat" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_paket" class="col-sm-4 col-form-label">Estimasi <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="id_paket" class="form-control" id='id_paket'>
                                        <option value = "" >--Pilih Paket--</option>
                                    <?php
                                        include "koneksi.php";
                                        
                                        $query = "SELECT * FROM paket order by id_paket asc";
                                        $sql = mysqli_query ($kon,$query);
                                        echo "sfsd ". $query ."<br/>";
                                        while ($data = mysqli_fetch_array($sql)){
                                            
                                            if($data['id_paket'] == $id_paket){
                                            ?>
                                                <option value = "<?= $data['id_paket'];?>" selected><?= $data['nama_paket'];?></option>
                                            <?php
                                            }else{
                                            ?>
                                                <option value = "<?= $data['id_paket'];?>"><?= $data['nama_paket'];?></option>
                                            <?php    
                                            }
                                            
                                        }
                                    ?> 
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_parfum" class="col-sm-4 col-form-label">Jenis Parfum <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="jenis_parfum" class="form-control" value = "<?php echo $jenis_parfum;?>" id="jenis_parfum">
                                        <option value = "Fresh" <?= ($jenis_parfum == "Fresh" ) ? 'selected' : ''?>>Fresh</option>
                                        <option value = "Aqua" <?= ($jenis_parfum == "Aqua" ) ? 'selected' : ''?>>Aqua</option>
                                        <option value = "Sakura" <?= ($jenis_parfum == "Sakura" ) ? 'selected' : ''?>>Sakura</option>        
                                        <option value = "Lili" <?= ($jenis_parfum == "Lili" ) ? 'selected' : ''?>>Lili</option>  
                                        <option value = "Vanila" <?= ($jenis_parfum == "Vanila" ) ? 'selected' : ''?>>Vanila</option>  
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="berat" class="col-sm-4 col-form-label">Status <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="status" class="form-control" value = "<?php echo $status;?>" id="status">
                                        <option value = "Baru" <?= ($status == "Baru" ) ? 'selected' : ''?>>Baru</option>
                                        <option value = "Pencucian" <?= ($status == "Pencucian" ) ? 'selected' : ''?>>Pencucian</option>
                                        <option value = "Setrika" <?= ($status == "Setrika" ) ? 'selected' : ''?>>Setrika</option>        
                                        <option value = "Lipat" <?= ($status == "Lipat" ) ? 'selected' : ''?>>Lipat</option>  
                                        <option value = "Selesai" <?= ($status == "Selesai" ) ? 'selected' : ''?>>Selesai</option>  
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Simpan</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>

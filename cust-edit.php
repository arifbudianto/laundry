<?php
require('header.php');
require('sidebar.php');

$nohp = $_GET["nohp"];
include "koneksi.php";
$sql = "select * from pelanggan where nohp = '$nohp'";
$hasil = mysqli_query($kon, $sql);
if (!$hasil) die ("Gagal Query...");

$data = mysqli_fetch_array($hasil);
$id_member = $data["id_member"];
$nohp   = $data["nohp"];
$nama   = $data["nama"];
// $alamat = $data["alamat"];
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Edit Data Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="cust-tampil.php">Daftar Customer</a></li>
            <li class="breadcrumb-item active">Edit Data Customer</li>
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
                <a href="cust-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Daftar Customer</a>
                <div class="card">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action = "cust-simpan2.php" method = "post" enctype = "multipart/form-data" method="post" class="form-horizontal">
                        <input type = "hidden" name = "id_member" value = "<?php echo $id_member;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-4 col-form-label">No. HP <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="nohp" class="form-control" id="nohp" value = "<?php echo $nohp;?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama Pelanggan <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="nama" class="form-control" id="nama" value = "<?php echo $nama;?>">
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Alamat <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <textarea name="alamat" class="form-control" rows="2"><?php echo $alamat;?></textarea>
                                </div>
                            </div> -->
                            <!-- /.card-body -->
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
        <!-- /.card -->
    </div>
</div>
<?php
require('footer.php');
?>

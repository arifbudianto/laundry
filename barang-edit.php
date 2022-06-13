<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Daftar Harga Per Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="barang-tampil.php">Daftar Harga Per Barang</a></li>
                    <li class="breadcrumb-item active">Edit Daftar Harga Per Barang</li>
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
                <a href="barang-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Daftar Harga Per Barang</a>
                <div class="card">
                    <!-- /.card-header -->
                    <?php
                    $kode_barang = $_GET["kode_barang"];
                    include "koneksi.php";
                    $sql = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil) die ("Gagal Query...");

                    $data = mysqli_fetch_array($hasil);
                    $nama_barang    = $data["nama_barang"];
                    $harga_barang   = $data["harga_barang"];
                    ?>

                    <!-- form start -->
                    <form action = "barang-simpan.php" method = "post" enctype = "multipart/form-data" method="post" class="form-horizontal">
                        <input type = "hidden" name = "kode_barang" value = "<?php echo $kode_barang;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_barang" class="col-sm-4 col-form-label">Nama <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name = "nama_barang" value = "<?php echo $nama_barang;?>" class="form-control" id="nama_barang" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga_barang" class="col-sm-4 col-form-label">Harga <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name = "harga_barang" value = "<?php echo $harga_barang;?>" class="form-control" id="harga_barang" >
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type = "submit" value = "Simpan" name = "proses" class="btn btn-info"/>
                            <input type = "reset" value = "Reset" name = "reset" class="btn btn-default"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
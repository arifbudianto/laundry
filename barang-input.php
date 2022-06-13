<?php
require('header.php');
require('sidebar.php');
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Input Daftar Harga Per Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="barang-tampil.php">Daftar Harga Per Barang</a></li>
            <li class="breadcrumb-item active">Input Daftar Harga Per Barang</li>
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
                <div class="card">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Horizontal Form</h3>
                    </div> -->
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action = "barang-simpan.php" method="post" class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_barang" class="col-sm-4 col-form-label">Nama Barang <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="nama_barang" class="form-control" id="nama_barang" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga_barang" class="col-sm-4 col-form-label">Harga Barang <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="harga_barang" class="form-control" id="harga_barang" required>
                                </div>
                            </div>
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

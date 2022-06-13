<?php
require('header.php');
require('sidebar.php');
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Tambah Harga Paket</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="paket-tampil.php">Daftar Harga Paket</a></li>
            <li class="breadcrumb-item active">Tambah Harga Paket</li>
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
            <div class="col-sm-6 col-md-offset-2">
                <div class="card">
                    
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action = "paket-simpan.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="paketLaundry" class="col-sm-4 col-form-label">Paket Laundry <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "paketLaundry" type = "text" class="form-control" id="paketLaundry" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga" class="col-sm-4 col-form-label">Harga <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="harga" class="form-control" id="harga" required>
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


            
<?php
require('header.php');
require('sidebar.php');
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Input Data Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="cust-tampil.php">Daftar Customer</a></li>
            <li class="breadcrumb-item active">Input Data Customer</li>
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
                    
                    <!-- form start -->
                    <form action = "cust-simpan.php" method="post" class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-4 col-form-label">No. HP <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="nohp" class="form-control" id="nohp" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama Pelanggan <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="nama" class="form-control" id="nama" required>
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
        <!-- /.card -->
    </div>
</div>

<?php
require('footer.php');
?>

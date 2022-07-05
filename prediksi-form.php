<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Prediksi Kebutuhan Parfum</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Prediksi Kebutuhan Parfum</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">     
        <!-- <div class="row">
            <div class="col-md-4 mb-3">
                <form action = "trans-tampil.php" method = "post">
                    <div class="input-group input-group">
                        <input class="form-control" type = "text" name = "id_transaksi" placeholder="Cari Berdasarkan ID Transaksi"/>
                        <span class="input-group-append">
                            <input type = "submit" class="btn btn-info" value = "Cari"/>
                        </span>
                    </div>
                </form> 
            </div>
        </div> -->
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action = "prediksi-proses.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="tgl_awal" class="col-sm-4 col-form-label">Periode Tanggal dari <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input type = "date" name = "tgl_awal" id="tgl_awal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>&nbsp; s/d &nbsp;</label>
                                            <input type = "date" name = "tgl_akhir" id="tgl_akhir" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_parfum" class="col-sm-4 col-form-label">Jenis Parfum <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="jenis_parfum" class="form-control" required>
                                        <option value = "">--Jenis Parfum--</option>    
                                        <option value = "fresh">Fresh</option>
                                        <option value = "aqua">Aqua</option>
                                        <option value = "sakura">Sakura</option>        
                                        <option value = "lili">Lili</option>  
                                        <option value = "vanila">Vanila</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type = "submit" value="Prediksi" name = "prediksi" class="btn btn-info" />
                            <input type = "reset" value="Reset" name = "reset" class="btn btn-default" />
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

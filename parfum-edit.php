<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Data Parfum</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="parfum-tampil.php">Daftar Parfum</a></li>
                    <li class="breadcrumb-item active">Edit Data Parfum</li>
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
                <a href="parfum-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Daftar Parfum</a>
                <div class="card">
                    <!-- /.card-header -->
                    <?php
                    $jenis_parfum = $_GET["jenis_parfum"];
                    include "koneksi.php";
                    $sql = "select * from parfum where jenis_parfum = '$jenis_parfum'";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil) die ("Gagal Query...");

                    $data = mysqli_fetch_array($hasil);
                    $id_parfum = $data["id_parfum"];
                    $jenis_parfum   = $data["jenis_parfum"];
                    $kode_parfum   = $data["kode_parfum"];
                    ?>
                    <!-- form start -->
                    <form action = "parfum-simpan.php" method = "post" enctype = "multipart/form-data" method="post" class="form-horizontal">
                        <input type = "hidden" name = "kode_parfum" value = "<?php echo $kode_parfum;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="id_parfum" class="col-sm-4 col-form-label">ID Parfum</label>
                                <div class="col-sm-8">
                                    <input type = "text" name = "id_parfum" value = "<?php echo $id_parfum;?>" class="form-control" id="id_parfum">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_parfum" class="col-sm-4 col-form-label">Jenis Parfum <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name = "jenis_parfum" value = "<?php echo $jenis_parfum;?>" class="form-control" id="jenis_parfum" >
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer">

                            <input type = "submit" value = "Simpan" name = "proses" class="btn btn-info"/>
                            <input type = "reset" value = "Reset" name = "reset" class="btn btn-default"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
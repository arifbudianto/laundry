<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Data Harga</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="estimasi-tampil.php">Daftar Harga</a></li>
                    <li class="breadcrumb-item active">Edit Data Harga</li>
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
                <a href="estimasi-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-book"></i> Daftar Harga</a>
                <div class="card">
                    <!-- /.card-header -->
                    <?php
                    $id_estimasi = $_GET["id_estimasi"];
                    include "koneksi.php";
                    $sql = "select * from estimasi_waktu where id_estimasi = '$id_estimasi'";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil) die ("Gagal Query...");

                    $data = mysqli_fetch_array($hasil);
                    $harga   = $data["harga"];
                    ?>

                    <!-- form start -->
                    <form action = "estimasi-simpan.php" method = "post" enctype = "multipart/form-data" method="post" class="form-horizontal">
                        <input type = "hidden" name = "id_estimasi" value = "<?php echo $id_estimasi;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="harga" class="col-sm-4 col-form-label">Harga</label>
                                <div class="col-sm-8">
                                    <input type = "text" name = "harga" value = "<?php echo $harga;?>" class="form-control" id="harga" >
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
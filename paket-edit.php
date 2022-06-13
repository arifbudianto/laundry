<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Daftar Harga Paket</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="paket-tampil.php">Daftar Harga Paket</a></li>
                    <li class="breadcrumb-item active">Edit Daftar Harga Paket</li>
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
                <a href="paket-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fas fa-angle-left"></i> Daftar Harga Paket</a>
                <div class="card">
                    <!-- /.card-header -->
                    <?php
                    $id_paket = $_GET["id_paket"];
                    include "koneksi.php";
                    $sql = "select * from paket where id_paket = '$id_paket'";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil) die ("Gagal Query...");

                    $data = mysqli_fetch_array($hasil);
                    $paket_laundry = $data['nama_paket'];
                    $harga   = $data["harga"];
                    ?>

                    <!-- form start -->
                    <form action = "paket-simpan.php" method = "post" enctype = "multipart/form-data" method="post" class="form-horizontal">
                        <input type = "hidden" name = "id_paket" value = "<?php echo $id_paket;?>"/>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="paketLaundry" class="col-sm-4 col-form-label">Paket Laundry <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "paketLaundry" type = "text" class="form-control" value="<?php echo $paket_laundry; ?>" id="paketLaundry" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga" class="col-sm-4 col-form-label">Harga <i class="text-danger">*</i></label>
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
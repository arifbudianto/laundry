<?php
require('header.php');
require('sidebar.php');
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Transaksi Laundry</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="trans-tampil.php">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active">Form Data Transaksi</li>
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
                    <form action = "trans-simpan.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <input name = "id_member" type = "text" style = "display:none"/>
                       
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="tgl_masuk" class="col-sm-4 col-form-label">Tgl. Masuk <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "tgl_masuk" type = "date" class="form-control" id="tgl_masuk" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-4 col-form-label">No. HP <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input name = "nohp" type = "text" class="form-control" id="nohp" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="berat" class="col-sm-4 col-form-label">Berat <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type = "text" name="berat" class="form-control" id="berat" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="id_paket" class="col-sm-4 col-form-label">Paket Laundry <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="id_paket" class="form-control" required>
                                        <option disabled selected>--Pilih Paket--</option>
                                        <?php
                                        include "koneksi.php";
                                        $query = "SELECT * FROM paket ORDER BY id_paket";
                                        $sql = mysqli_query ($kon,$query);
                                        while ($data = mysqli_fetch_array($sql)){
                                            $id_paket = $data['id_paket'];
                                            $nama_paket = $data['nama_paket'];                                    
                                            ?>
                                            <option value = "<?=$id_paket;?>"><?=$nama_paket;?></option>
                                            <?php    
                                        }
                                        ?> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jenis_parfum" class="col-sm-4 col-form-label">Jenis Parfum <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="jenis_parfum" class="form-control" required>
                                        <option disabled selected>--Jenis Parfum--</option> 
                                        <?php
                                        include "koneksi.php";
                                        $query = "SELECT * FROM parfum ORDER BY jenis_parfum";
                                        $sql = mysqli_query ($kon,$query);
                                        while ($data = mysqli_fetch_array($sql)){
                                        $jenis_parfum = $data['jenis_parfum'];                                 
                                        ?>
                                        <option value = "<?=$jenis_parfum;?>"><?=$jenis_parfum;?></option>
                                        <?php    
                                        }
                                        ?> 
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


            
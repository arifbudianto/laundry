<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Konfirmasi Hapus Data Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Konfirmasi Hapus Data Transaksi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <?php
        $id_transaksi   =   $_GET['id_transaksi'];
        include "koneksi.php";
        $sql    =   "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
  
        $hasil  =   mysqli_query($kon, $sql);
        if (!$hasil) die ('Gagal Query');

        $data   =   mysqli_fetch_array($hasil);
        $id_transaksi   =   $data['id_transaksi'];

        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <p>Apakah anda akan menghapus data dengan ID <b><?php echo $id_transaksi ?> </b>?</p> 
                    </div>
                    <div class="card-footer">
                        <a href="trans-hapus.php?id_transaksi=<?php echo $id_transaksi;?>&hapus=1" class="btn btn-info">Hapus</a>
                        <a href="trans-tampil.php?id_transaksi=<?php echo $id_transaksi;?>" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </div>
        </div>
        <?php

        if (isset($_GET['hapus'])){
            $sql    =   "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'";
            $hasil  =   mysqli_query($kon, $sql);
            if (!$hasil){
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php
                        echo 'Gagal Hapus Data dengan ID Transaksi <b>$id_transaksi</b>';
                    ?>
                </div>
                <a href="trans-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
                <?php
            }else {
                ?>
                <script>
                    window.location.href = "trans-tampil.php";
                </script>
                <?php
            }
        }
        ?>
    </div>
</div>
<?php
require('footer.php');
?>
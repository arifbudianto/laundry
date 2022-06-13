<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Konfirmasi Hapus Data Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Konfirmasi Hapus Data Customer</li>
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
        $id_member   =   $_GET['id_member'];
        include "koneksi.php";
        $sql    =   "SELECT * FROM pelanggan WHERE id_member = '$id_member'";
        $hasil  =   mysqli_query($kon, $sql);
        if (!$hasil) die ('Gagal Query');

        $data   =   mysqli_fetch_array($hasil);
        $nohp   =   $data['nohp'];
        $nama   =   $data['nama'];
        $alamat =   $data['alamat'];

        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <p>Apakah anda akan menghapus data berikut ?</p>
                        <dl class="row">
                            <dt class="col-sm-4">No. Hp</dt>
                            <dd class="col-sm-8">
                                <?php echo $nohp; ?>
                            </dd>

                            <dt class="col-sm-4">Nama Customer</dt>
                            <dd class="col-sm-8">
                                <?php echo $nama; ?>
                            </dd>

                            <dt class="col-sm-4">Alamat</dt>
                            <dd class="col-sm-8">
                                <?php echo $alamat; ?>
                            </dd>
                        </dl>
                        
                    </div>
                    <div class="card-footer">
                        <a href="cust-hapus.php?id_member=$id_member&hapus=1" class="btn btn-info">Hapus</a>
                        <a href="cust-tampil.php?nohp=$nohp" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // if (isset($_GET['hapus'])){
            $sql    =   "DELETE FROM pelanggan WHERE id_member = '$id_member'";
            $hasil  =   mysqli_query($kon, $sql);
            if (!$hasil){
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php
                        echo 'Gagal Hapus Data Customer <b>$nama</b>';
                    ?>
                </div>
                <a href="cust-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-angle-left"></i> Kembali</a>
                <?php
            }else {
                header('location:cust-tampil.php');
            }
        // }
        ?>
    </div>
</div>
<?php
require('footer.php');
?>
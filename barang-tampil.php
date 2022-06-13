<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Daftar Harga Per Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Daftar Harga Per Barang</li>
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
            <div class="col-md-4 mb-3">
                <form action = "barang-tampil.php" method = "post">
                    <div class="input-group input-group">
                        <input class="form-control" type = "text" name = "nama_barang" placeholder="Masukkan Nama Barang"/>
                        <span class="input-group-append">
                            <input type = "submit" class="btn btn-info" value = "Cari"/>
                        </span>
                    </div>
                </form> 
            </div>
        </div>
        <?php
        $nama_barang = "";
        if (isset($_POST["nama_barang"]))
            $nama_barang = $_POST["nama_barang"];

        include "koneksi.php";
        $sql = "SELECT * FROM barang where nama_barang like '%".$nama_barang."%'
                order by nama_barang desc";
        $hasil = mysqli_query($kon, $sql);

        if (!$hasil)
            die("Gagal Query..".mysqli_error($kon));

        ?>
        
        <div class="card card-default ">
            <div class="card-header">
                <a href="barang-input.php" class="btn btn-success btn-md btn-sm"><i class="fa fa-plus"></i> Tambah Data </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Barang </th>
                            <th>Nama Barang </th>
                            <th>Harga Barang (Rp)</th>
                            <th class='text-center'>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($hasil)){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$row['kode_barang']."</td>";
                            echo " <td> ".$row['nama_barang']."</td>";
                            echo " <td> ".$row['harga_barang']."</td>";
                            echo " <td class='text-center'> ";
                            echo "<a href = 'barang-edit.php?kode_barang=".$row['kode_barang']."' title='Edit Data'><i class='fa fa-edit text-orange'></i></a>";
                            // echo "&nbsp;&nbsp;";
                            // echo "<a href = 'barang-hapus.php?kode_barang=".$row['kode_barang']."' title='Hapus Data'> <i class='fa fa-trash text-danger'></i> </a>";
                            echo " </td>";
                            echo " </tr> ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
<script>
    $('#table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
</script>

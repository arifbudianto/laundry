<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Daftar Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Daftar Customer</li>
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
                <form action = "cust-tampil.php" method = "post">
                    <div class="input-group input-group">
                        <input class="form-control" type = "text" name = "nohp" placeholder="Cari Berdasarkan No. HP"/>
                        <span class="input-group-append">
                            <input type = "submit" class="btn btn-info" value = "Cari"/>
                        </span>
                    </div>
                </form> 
            </div>
        </div>
        <?php
        $nohp = "";
        if (isset($_POST["nohp"]))
            $nohp = $_POST["nohp"];

        include "koneksi.php";
        $sql = "SELECT pelanggan.nohp, nama, COUNT(pelanggan.nohp) as Jumlah FROM pelanggan JOIN transaksi ON  pelanggan.nohp = transaksi.nohp where pelanggan.nohp like '%".$nohp."%'
                group by pelanggan.nohp order by Jumlah desc";
        $hasil = mysqli_query($kon, $sql);

        if (!$hasil)
            die("Gagal Query..".mysqli_error($kon));

        ?>
        
        <div class="card card-default ">
            <div class="card-header">
                <a href="cust-isi.php" class="btn btn-success btn-md btn-sm"><i class="fa fa-plus"></i> Tambah Data </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. HP</th>
                            <th>Nama </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($hasil)){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$row['nohp']."</td>";
                            echo " <td> ".$row['nama']."</td>";
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

<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Parfum</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Parfum</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <a href="parfum-input.php" class="btn btn-success btn-md btn-sm"><i class="fa fa-plus"></i> Tambah Data </a>
            </div>
            <div class="card-body ">
                <?php
                    $jenis_parfum = "";
                    if (isset($_POST["jenis_parfum"])){
                        $jenis_parfum = $_POST["jenis_parfum"];
                    }
                    include "koneksi.php";
                    $sql = "SELECT * FROM parfum where jenis_parfum like '%".$jenis_parfum."%'
                            order by id_parfum asc";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil){
                        die("Gagal Query..".mysqli_error($kon));
                    }
                ?>

                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Parfum</th>
                            <th>Jenis Parfum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($hasil)){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$row['id_parfum']."</td>";
                            echo " <td> ".$row['jenis_parfum']."</td>";
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
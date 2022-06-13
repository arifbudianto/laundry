<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Harga Paket</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Harga Paket</li>
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
                <a href="paket-input.php" class="btn btn-success btn-md btn-sm"><i class="fa fa-plus"></i> Tambah Data </a>
                
            </div>
            <!-- /.card-header -->
            <div class="card-body ">
                <?php
                    $id_paket = "";
                    if (isset($_POST["id_paket"])){
                        $id_paket = $_POST["id_paket"];
                    }
                        
                    include "koneksi.php";
                    $sql = "SELECT * FROM paket where id_paket like '%".$id_paket."%'
                            order by id_paket asc";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil){
                        die("Gagal Query..".mysqli_error($kon));
                    }
                        
                ?>
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Paket</th>
                            <th>Paket Laundry</th>
                            <th>Harga (Rp)</th>
                            <th class='text-center'>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($hasil)){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$row['id_paket']."</td>";
                            echo " <td> ".$row['nama_paket']."</td>";
                            echo " <td> ".$row['harga']."</td>";
                            echo " <td class='text-center'>";
                            echo "<a href = 'paket-edit.php?id_paket=".$row['id_paket']."' title='Edit Data'><i class='fa fa-edit text-orange'></i></a>";
                            echo "</td>";
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
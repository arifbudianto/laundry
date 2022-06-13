<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Harga</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Harga</li>
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
            <!-- /.card-header -->
            <div class="card-body ">
                <?php
                    $id_estimasi = "";
                    if (isset($_POST["id_estimasi"])){
                        $id_estimasi = $_POST["id_estimasi"];
                    }
                        
                    include "koneksi.php";
                    $sql = "SELECT * FROM estimasi_waktu where id_estimasi like '%".$id_estimasi."%'
                            order by id_estimasi asc";
                    $hasil = mysqli_query($kon, $sql);
                    if (!$hasil){
                        die("Gagal Query..".mysqli_error($kon));
                    }
                        
                ?>
                <table class="table table-bordered ">
                    <tr>
                        <th>No.</th>
                        <th>ID Estimasi Waktu</th>
                        <th>Estimasi Waktu</th>
                        <th>Harga</th>
                        <th>Operasi</th>
                    </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($hasil)){
                    echo " <tr> ";
                    echo " <td> ".$no++."</td>";
                    echo " <td> ".$row['id_estimasi']."</td>";
                    echo " <td> ".$row['estimasi']."</td>";
                    echo " <td> ".$row['harga']."</td>";
                    echo " <td>";
                    echo "<a href = 'estimasi-edit.php?id_estimasi=".$row['id_estimasi']."' title='Edit Data'><i class='fa fa-edit text-orange'></i></a>";
                    echo "</td>";
                    echo " </tr> ";
                }
                ?>
                </table>

            </div>
        </div>
    </div>  
</div>     
<?php
require('footer.php');
?>

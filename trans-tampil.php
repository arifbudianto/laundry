<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Transaksi</li>
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
                <form action = "trans-tampil.php" method = "post">
                    <div class="input-group input-group">
                        <input class="form-control" type = "text" name = "id_transaksi" placeholder="Cari Berdasarkan ID Transaksi"/>
                        <span class="input-group-append">
                            <input type = "submit" class="btn btn-info" value = "Cari"/>
                        </span>
                    </div>
                </form> 
            </div>
        </div>
        <?php
        $id_transaksi = "";
        if (isset($_POST["id_transaksi"])){
            $id_transaksi = $_POST["id_transaksi"];}

        include "koneksi.php";
        $sql = "SELECT pelanggan.id_member, pelanggan.nohp FROM pelanggan";
        $hasil = mysqli_query($kon,$sql);
        $data = mysqli_fetch_array($hasil);
        $nohp = $data['nohp'];
        $id_member = $data['id_member'];

        $sql = "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
                paket.nama_paket, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
                FROM transaksi
                JOIN pelanggan ON transaksi.id_member = pelanggan.id_member
                JOIN paket ON transaksi.id_paket = paket.id_paket
                JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum where id_transaksi like '%".$id_transaksi."%'
                ORDER BY id_transaksi DESC";
        $hasil = mysqli_query($kon, $sql);

        if (!$hasil)
            die("Gagal Query..".mysqli_error($kon));
        ?>

        <div class="card card-default">
            <div class="card-header">
                <a href="trans-input.php" class="btn btn-success btn-md btn-sm"><i class="fa fa-plus"></i> Tambah Data </a>
                
            </div>
            <!-- /.card-header -->
            <div class="card-body ">
        
                <table id="table" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Transaksi</th>
                            <th>Tgl. Masuk</th>
                            <th>Tgl. Keluar</th>
                            <th>No. HP</th>
                            <th>Nama</th>
                            <th>Berat (Kg)</th>
                            <th>Paket</th>
                            <th>Jenis Parfum</th>
                            <th>Total Bayar (Rp)</th>
                            <th class='text-center'>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($hasil)){
                            echo " <tr> ";
                            echo " <td> ".$no++."</td>";
                            echo " <td> ".$row['id_transaksi']."</td>";
                            echo " <td> ".$row['tgl_masuk']."</td>";
                            echo " <td> ".$row['tgl_keluar']."</td>";
                            echo " <td> ".$row['nohp']."</td>";
                            echo " <td> ".$row['nama']."</td>";
                            echo " <td> ".$row['berat']."</td>";
                            echo " <td> ".$row['nama_paket']."</td>";
                            echo " <td> ".$row['jenis_parfum']."</td>";
                            echo " <td> ".$row['total_bayar']."</td>";
                            echo " <td class='text-center'>";
                            if ($row['tgl_keluar'] == NULL || $row['tgl_keluar'] == ''){
                                echo " <a href = 'trans-proses-konfir.php?id_transaksi=".$row['id_transaksi']."' title='Konfirmasi Data'><i class='fa fa-check text-success'></i> </a>";
                            }else{
                                echo " <a href = 'trans-batal-konfir.php?id_transaksi=".$row['id_transaksi']."' title='Batal Konfirmasi Data'><i class='fa fa-times text-dark'></i></a>";
                            }
                            echo "&nbsp;&nbsp;";
                            echo "<a href = 'trans-edit.php?id_transaksi=".$row['id_transaksi']."' title='Edit Data'><i class='fa fa-edit text-orange'></i></a>";
                            echo "&nbsp;&nbsp;";
                            // echo "<a href = 'trans-hapus.php?id_transaksi=".$row['id_transaksi']."' title='Hapus Data'><i class='fa fa-trash text-danger'></i></a>";
                            // echo "&nbsp;&nbsp;";
                            echo "<a href = 'nota-cetak.php?id_transaksi=".$row['id_transaksi']."' title='Cetak'><i class='fa fa-print'></i></a>";
                            echo " </td>";
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
<?php
require('header.php');
require('sidebar.php');
?>
<div id="loading" class="hide">
  <img id="loading-image" src="./dist/img/loading2.gif" alt="Loading..." />
</div>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

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
        $sql = "SELECT pelanggan.nohp FROM pelanggan";
        $hasil = mysqli_query($kon,$sql);
        $data = mysqli_fetch_array($hasil);
        $nohp = $data['nohp'];

        $sql = "SELECT id_transaksi, tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama, paket.id_paket,
                paket.nama_paket, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar, status
                FROM transaksi
                JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
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
                            <th class='text-center'>Status</th>
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
                            echo " <td> ".round($row['berat'],3)."</td>";
                            echo " <td> ".$row['nama_paket']."</td>";
                            echo " <td> ".$row['jenis_parfum']."</td>";
                            echo " <td> ".number_format($row['total_bayar'],0,',','.')."</td>";
                            echo " <td>";
                                if($row['id_paket'] == 'S01' || $row['id_paket'] == 'S02'){
                                    if ($row['status'] == "Baru"){
                                    ?>
                                        <select name = "status" class="badge badge-danger status">
                                            <option value ="<?= $row['id_transaksi']?>_Baru" selected> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Setrika"> Setrika</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else if($row['status']=="Setrika"){
                                    ?>
                                        <select name = "status" class="badge badge-info status" >
                                            <option value ="<?= $row['id_transaksi']?>_Baru"> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Setrika" selected> Setrika</optin>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else{ 
                                    ?>
                                        <button class ="btn btn-success btn-sm dropdown-toggle">Selesai</button>
                                    <?php 
                                    }
                                } elseif ($row['id_paket'] == 'CB4' || $row['id_paket'] == 'CK4'){
                                    if ($row['status'] == "Baru"){
                                    ?>
                                        <select name = "status" class="badge badge-danger status">
                                            <option value ="<?= $row['id_transaksi']?>_Baru" selected> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Pencucian"> Pencucian</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else if($row['status']=="Pencucian"){
                                    ?>
                                        <select name = "status" class="badge badge-warning status" >
                                            <option value ="<?= $row['id_transaksi']?>_Baru"> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Pencucian" selected> Pencucian</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                     <?php 
                                    } else{ 
                                    ?>
                                        <button class ="btn btn-success btn-sm dropdown-toggle">Selesai</button>
                                    <?php 
                                    }
                                } else {
                                    if ($row['status'] == "Baru"){
                                    ?>
                                        <select name = "status" class="badge badge-danger status">
                                            <option value ="<?= $row['id_transaksi']?>_Baru" selected> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Pencucian"> Pencucian</option>
                                            <option value ="<?= $row['id_transaksi']?>_Setrika"> Setrika</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else if($row['status']=="Pencucian"){
                                    ?>
                                        <select name = "status" class="badge badge-warning status" >
                                            <option value ="<?= $row['id_transaksi']?>_Baru"> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Pencucian" selected> Pencucian</option>
                                            <option value ="<?= $row['id_transaksi']?>_Setrika"> Setrika</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else if($row['status']=="Setrika"){
                                    ?>
                                        <select name = "status" class="badge badge-info status" >
                                            <option value ="<?= $row['id_transaksi']?>_Baru"> Baru</option>
                                            <option value ="<?= $row['id_transaksi']?>_Pencucian"> Pencucian</option>
                                            <option value ="<?= $row['id_transaksi']?>_Setrika" selected> Setrika</option>
                                            <option value ="<?= $row['id_transaksi']?>_Selesai"> Selesai</option>
                                        </select>
                                    <?php 
                                    } else{ 
                                    ?>
                                        <button class ="btn btn-success btn-sm dropdown-toggle">Selesai</button>
                                    <?php 
                                        }
                                    }
                            echo "</td>";
                            echo " <td class='text-center'>";
                            if ($row['tgl_keluar'] == NULL || $row['tgl_keluar'] == ''){
                                echo " <a href = 'trans-proses-konfir.php?id_transaksi=".$row['id_transaksi']."' title='Konfirmasi Data'><i class='fa fa-check text-success'></i> </a>";
                            }else{
                                echo " <a href = 'trans-batal-konfir.php?id_transaksi=".$row['id_transaksi']."' title='Batal Konfirmasi Data'><i class='fa fa-times text-dark'></i></a>";
                            }
                            echo "&nbsp;&nbsp;";
                            echo "<a href = 'trans-edit.php?id_transaksi=".$row['id_transaksi']."' title='Edit Transaksi'><i class='fa fa-edit text-orange'></i></a>";
                            echo "&nbsp;&nbsp;";
                            echo "<a href = 'nota-cetak.php?id_transaksi=".$row['id_transaksi']."' title='Cetak'><i class='fa fa-print'></i></a>";
                            echo " </td>";
                            echo "</tr>";
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

    $('#table').on('change','.status', function () {
        var setStatus = $(this).find(":selected").val();
        setStatus = setStatus.split("_");

        var data_status = setStatus[1];
        var data_id_transaksi = setStatus[0];

        $("#loading").removeClass('hide'); 
        $.ajax({
            url : "trans-status.php?status="+data_status+"&id_transaksi="+data_id_transaksi,
            dataType : "json",
            method : "GET",
            success : function(data){
                
                setTimeout(function(){
                    // window.location.reload();
                    $("#loading").addClass('hide');
                }
                , 250);
                
            },
            error:function(e){
                console.log(e);
            }
        });
    });

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
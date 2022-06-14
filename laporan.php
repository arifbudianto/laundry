<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    <div class="col-sm-6">
                <h1 class="m-0">Laporan Order Masuk</h1>
            </div><!-- /.col -->
    <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Order Masuk</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <form action="" method="post">
            <div class="card card-default">
                <div class="card-header">
                    <h5 class="card-title">Filter</h5>
                </div>
                
                <div class="card-body ">
                    <div class="radio">
                        <label><input type="radio" name="filterData"  value="filterAllData" checked id="filterAllData"> Semua Data</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="filterData" value="filterTanggal" id="filterTanggal"> Tanggal</label>
                    </div>
                    <div class="form-inline mb-3" style="display:none">
                        <div class="form-group">
                            <input type="date" class="form-control" name="startDate" value="startDate" id="startDate">
                        </div>
                        <div class="form-group">
                            <label>&nbsp; s/d &nbsp;</label>
                            <input type="date" class="form-control" name="endDate" value="endDate" id="endDate">
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="btnTampil">Tampilkan</button>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <button class="btn btn-default btn-md btn-sm " id="btnPrint" ><i class="fa fa-print"></i> Print Data</button>
                    <button class="btn btn-default btn-md btn-sm " id="btnPrintXls"><i class="far fa-file-excel"></i> Export Excel</button>
                </div>
                
                <div class="card-body ">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tgl. Transaksi</th>
                                <th>Tgl. Keluar</th>
                                <th>Nama Customer</th>
                                <th>Paket</th>
                                <th>Berat (Kg)</th>
                                <th>Harga (Rp)</th>
                                <th>Jenis Parfum</th>
                                <th>Total Bayar (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include "koneksi.php";

                            $filterData='';
                            if(isset($_POST['filterData'])){
                                if($_POST['filterData']=='filterAllData'){
                                    $filterData = '';
                                }
                                else{
                                    if($_POST['startDate'] =='' && $_POST['endDate'] ==''){
                                        $filterData = '';
                                    }else if($_POST['startDate'] =='' && $_POST['endDate'] !=''){
                                        $filterData = "WHERE tgl_masuk ='$_POST[endDate]'";
                                    }else if($_POST['endDate'] =='' && $_POST['startDate'] !=''){
                                        $filterData = "WHERE tgl_masuk ='$_POST[startDate]'";
                                    }
                                    else{
                                        $filterData = "WHERE tgl_masuk BETWEEN '$_POST[startDate]' AND '$_POST[endDate]'";
                                        
                                    }
                                }
                            }
                            

                            $sql = "SELECT tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
                                    paket.nama_paket,paket.harga, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
                                    FROM transaksi
                                    JOIN pelanggan ON transaksi.nohp = pelanggan.nohp
                                    JOIN paket ON transaksi.id_paket = paket.id_paket
                                    JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum 
                                    $filterData
                                    ORDER BY id_transaksi DESC";


                            $hasil = mysqli_query($kon, $sql);
                    
                            if (!$hasil)
                                die("Gagal Query..".mysqli_error($kon));

                                
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($hasil)){
                                echo " <tr> ";
                                echo " <td> ".$no++."</td>";
                                echo " <td> ".$row['tgl_masuk']."</td>";
                                echo " <td> ".$row['tgl_keluar']."</td>";
                                echo " <td> ".$row['nama']."</td>";
                                echo " <td> ".$row['nama_paket']."</td>";
                                echo " <td> ".$row['berat']."</td>";
                                echo " <td> ".$row['harga']."</td>";
                                echo " <td> ".$row['jenis_parfum']."</td>";
                                echo " <td> ".$row['total_bayar']."</td>";
                                echo " </tr> ";
                            }
                            ?>
                            
                        </tbody>
                    </table>
                    
                </div>
                
            </div>

            <!-- print  -->
            <div class="row">
                <div class="col-md-12" id="printData" style="font-family:arial;">
                    <!-- <div style="text-align:center">
                        <h3 style="margin-bottom:-5px; padding:0">Laporan Pemasukan Athaya Laundry</h3>
                        <p style="margin-bottom:-5px;font-size:12px; padding:0">Jl. Janti</p>
                        <p style="margin-bottom:15px;font-size:12px;padding:0">HP: 087 822 555 784</p>
                    </div> -->
                    <table class="table table-bordered" cellspacing=0 cellpadding=3 style="font-size:12px;width:100%;margin:0px 0px 0px 0px" id="test">
                        <thead>
                            <tr>
                                <td colspan="9"><h3 style="margin-bottom:-5px; padding:0;text-align:center">Laporan Pemasukan Athaya Laundry</h3></td>
                            </tr>
                            <tr>
                                <td colspan="9"><p style="margin-bottom:-5px;font-size:12px; padding:0;text-align:center">Jl. Janti</p></td>
                            </tr>
                            <tr>
                                <td colspan="9"><p style="margin-bottom:15px;font-size:12px;padding:0;text-align:center">HP: 087 822 555 784</p></td>
                            </tr>
                            <tr>
                                <th style="border:1px solid #dee2e6">No.</th>
                                <th style="border:1px solid #dee2e6">Tgl. Transaksi</th>
                                <th style="border:1px solid #dee2e6">Tgl. Keluar</th>
                                <th style="border:1px solid #dee2e6">Nama Customer</th>
                                <th style="border:1px solid #dee2e6">Paket</th>
                                <th style="border:1px solid #dee2e6">Berat (Kg)</th>
                                <th style="border:1px solid #dee2e6">Harga (Rp)</th>
                                <th style="border:1px solid #dee2e6">Jenis Parfum</th>
                                <th style="border:1px solid #dee2e6">Total Bayar (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql2 = "SELECT tgl_masuk, tgl_keluar, pelanggan.nohp, pelanggan.nama,
                            paket.nama_paket,paket.harga, parfum.id_parfum, parfum.jenis_parfum, berat, total_bayar
                            FROM transaksi
                            JOIN pelanggan ON transaksi.id_member = pelanggan.id_member
                            JOIN paket ON transaksi.id_paket = paket.id_paket
                            JOIN parfum ON transaksi.jenis_parfum = parfum.jenis_parfum 
                            $filterData
                            ORDER BY id_transaksi DESC";



                            $hasil2 = mysqli_query($kon, $sql2);
                        
                            if (!$hasil2)
                                die("Gagal Query..".mysqli_error($kon));

                            if(mysqli_num_rows($hasil2)!=0){
                                $no2 = 1;
                                while ($row2 = mysqli_fetch_assoc($hasil2)){
                                    echo " <tr> ";
                                    echo " <td style='border:1px solid #dee2e6'> ".$no2++."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['tgl_masuk']."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['tgl_keluar']."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['nama']."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['nama_paket']."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['berat']."</td>";
                                    echo " <td style='border:1px solid #dee2e6;text-align:right'> ".$row2['harga']."</td>";
                                    echo " <td style='border:1px solid #dee2e6'> ".$row2['jenis_parfum']."</td>";
                                    echo " <td style='border:1px solid #dee2e6;text-align:right'> ".$row2['total_bayar']."</td>";
                                    echo " </tr> ";
                                }
                            }else{
                                echo "<tr><td colspan=9 style='border:1px solid #dee2e6;text-align:center'>No data available in table</td></tr>";
                            }

                            
                        ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </form>
    </div>
</div>
<?php
require('footer.php');
?>

<script>
    $("#filterTanggal").change(function(){
        $(".form-inline").css("display","flex");
    });

    $("#filterAllData").change(function(){
        $(".form-inline").css("display","none");
    });
   
    // js print
    function printData()
    {
        var divToPrint=document.getElementById("printData");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }

    $('#btnPrint').on('click',function(){
        printData();
    });

    // export excel
    $(function() {
        $("#btnPrintXls").click(function(e){
            $("#printData").table2excel({
                exclude:".noExl",
                name:"Worksheet Name",
                filename:"Laporan Pemasukan Athaya Laundry",
                fileext:".xls",
                preserveColors:true
            });

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
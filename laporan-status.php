<?php
require('header.php');
require('sidebar.php');
require('koneksi.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Status Laundry</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Status Laundry</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->

<div class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <button class="btn btn-default btn-md btn-sm " id="btnPrint" ><i class="fa fa-print"></i> Print Data</button>
            </div>
            <div class="card-body " id="printData">
                <style>
                    @media print {
                        table {
                            font-family:arial;
                            border-collapse:collapse;
                            width:100%;
                        }
                        table.table{
                            font-size:12px;
                        }
                        table.table , table.table td, table.table th{
                            border:1px solid;
                        }
                        .text-center{
                            text-align:center;
                        }
                        .mb-0{
                            margin-bottom:0;
                        }
                        .pb-1{
                            padding-bottom:10px;
                        }
                        .text-right{
                            text-align:right;
                        }
                        .sub-judul{
                            font-size:12px;
                        }
                    }
                    table{
                        width:100%;
                    }
                    .mb-0{
                        margin-bottom:0;
                    }
                    .pb-1{
                        padding-bottom:10px;
                    }
                </style>
                <table border=0>
                    <tr>
                        <td class="text-center"><h3 class="mb-0">Laporan Status Laundry Athaya Laundry</h3></td>
                    </tr>
                </table>

                <table class="table table-bordered" cellspacing=0 cellpadding=5>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Status Laundry</th>
                        <th class="text-center">Jumlah Laundry</th>
                    </tr>
                    <?php
                    
                    $no = 1;
                    $sql = "SELECT status, COUNT(status) as jumlah FROM transaksi GROUP BY status";
                    $hasil = mysqli_query ($kon,$sql);
                    while ($row = mysqli_fetch_array($hasil)){
                        echo " <tr> ";
                        echo " <td> ".$no++."</td>";
                        echo " <td> ".$row['status']."</td>";
                        echo " <td> ".$row['jumlah']."</td>";
                        echo " </tr>";
                    } 
                    $sql2 = "SELECT status, COUNT(status) as jumlah FROM transaksi";
                    $hasil2 = mysqli_query ($kon,$sql2);
                    $row2 = mysqli_fetch_assoc($hasil2);
                    $jumlah = $row2['jumlah'];
                    echo "<tr><th colspan='2' class='text-center'>Total</th> <th>".$jumlah."</th></tr>";
                ?>
                </table>
                
            </div>
        </div>
        
    </div>
</div>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

<?php    
require('footer.php');
?>

<script>
    function printData()
    {
        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printData").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
    
    $('#btnPrint').on('click',function(){
        printData();
    });
</script>
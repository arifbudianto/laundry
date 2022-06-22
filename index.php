<?php
require('header.php');
require('sidebar.php');
require("koneksi.php");
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php 

// total customer
$sql ="select count(nohp) as nohp from pelanggan";
$data =mysqli_query($kon,$sql);

if(!$data){
    die(mysqli_error($kon));
}

$row =mysqli_fetch_assoc($data);
$total_customer =$row['nohp'];

// transaksi baru
$sql2 ="select count(id_transaksi) as id_transaksi from transaksi where tgl_keluar is null";
$data2 =mysqli_query($kon,$sql2);

if(!$data2){
    die(mysqli_error($kon));
}

$row2 =mysqli_fetch_assoc($data2);
$data_transaksi_baru =$row2['id_transaksi'];

// total transaksi
$sql3 ="select count(id_transaksi) as id_transaksi from transaksi";
$data3 =mysqli_query($kon,$sql3);

if(!$data3){
    die(mysqli_error($kon));
}

$row3 =mysqli_fetch_assoc($data3);
$total_transaksi =$row3['id_transaksi'];


?>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Customer</span>
                        <span class="info-box-number">
                        <?= $total_customer ;?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Transaksi Baru</span>
                        <span class="info-box-number">
                            <?= $data_transaksi_baru; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Transaksi</span>
                        <span class="info-box-number">
                            <?= $total_transaksi; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Grafik Transaksi Periode Bulanan dalam 1 Tahun</h3>
                            <!-- <a href="javascript:void(0);">View Report</a> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                              <span class="text-bold text-lg text-success" id="grand_total_x"></span>
                              <span id="label_grand_total_x" class="text-muted"></span>
                            </p>
                            
                            <p class="ml-5 d-flex flex-column">
                              <span class="text-bold text-lg text-success" id="grand_total_y"></span>
                              <span id="label_grand_total_y" class="text-muted"></span>
                                <!-- <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted">Since last month</span> -->
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="transaksi-chart" height="300"></canvas>
                        </div>

                        <!-- <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> Tahun ini
                            </span>

                            <span>
                            <i class="fas fa-square text-gray"></i> Tahun Lalu
                            </span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php
require('footer.php');
?>

<script>
    $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  // get data with ajax
  $.ajax({
    url:"data_json.php",
    dataType: "json",
    method:"GET",
    success:function(data){

      var count = data.structure.data_result;

      var get_periode = [];
      var data_bulan = [];
      var get_data = [];
      var data_tahun = [];
      var data_parse = [];

      var total_tahun_lalu = [];
      var total_tahun_ini = [];
      var data_bulan_az= [];

      for(var x=0; x<count.length; x++){

        // ambil data bulan
        get_periode[x] = data.structure.data_result[x].data_tgl_periode;
        get_data[x] = get_periode[x].split("-");
        data_bulan[x] = get_data[x][1];
        
        // ambil data tahun
        data_tahun[x] = get_data[x][0];
        data_parse[x] = parseInt(data_tahun[x]);

        var tahun_max = Math.max.apply(Math,data_parse);
        var tahun_min = Math.min.apply(Math,data_parse);


        // membuat bulan numeric ke alfabet
        var data_bulan_x = new Date( data_tahun[x], data_bulan[x], 0);
        data_bulan_az[x] = data_bulan_x.toLocaleString('en-us', { month: 'short' });

        // membuat bulan agar tidak duplicate
        var data_bulan_unique = data_bulan_az.filter(function(item, i, data_bulan_az){
          return i == data_bulan_az.indexOf(item);
        })
      }

      var count_data_tahun = data_tahun.length;
      for( var y=0; y<count_data_tahun; y++){
        // check jika data sma dengan tahun max
        if(tahun_max == data_tahun[y]){
          total_tahun_ini[y] = data.structure.data_result[y].data_total_bayar;

          // menghilangkan value array null
          var total_tahun_ini_x = total_tahun_ini.filter(item => item);
        }else{
          total_tahun_lalu[y] = data.structure.data_result[y].data_total_bayar;
          var total_tahun_lalu_x = total_tahun_lalu.filter(item => item);
        }
      }

      // total bayar 
      var data_total_bayar_a =[];
      var grand_total_x =0;
      for(var yx=0; yx<total_tahun_ini_x.length; yx++){
        data_total_bayar_a[yx] = total_tahun_ini_x[yx];

        // grand total tahun ini
        grand_total_x += parseInt(total_tahun_ini_x[yx]);
      }

      // tampilkan ke DOM
      $("#grand_total_x").text('Rp. '+grand_total_x.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#label_grand_total_x").html('Grand Total <b>'+tahun_max+'</b>');

      var data_total_bayar_b =[];
      var grand_total_y =0;
      for(var yx=0; yx<total_tahun_lalu_x.length; yx++){
        data_total_bayar_b[yx] = total_tahun_lalu_x[yx];
        // grand total tahun ini
        grand_total_y += parseInt(total_tahun_lalu_x[yx]);
      }

      $("#grand_total_y").text('Rp. '+grand_total_y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#label_grand_total_y").html('Grand Total <b>'+tahun_min+'</b>');
   
      var $salesChart = $('#transaksi-chart')

      // eslint-disable-next-line no-unused-vars
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: data_bulan_unique,
          datasets: [
            {
              label: 'Data Tahun '+tahun_max,
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              data : data_total_bayar_a
              // data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
            },
            {
              label: 'Data Tahun '+tahun_min,
              backgroundColor: '#ced4da',
              borderColor: '#ced4da',
              data : data_total_bayar_b
              // data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: true
          },
          scales: {
            yAxes: [{
              // display: true,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'solid'
              }
              ,
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  if (value >= 1000000) {
                    value /= 1000000
                  }

                  return 'Rp.' + value+' jt'
                }
              }, ticksStyle)
            }],
            xAxes: [{
              // display: true,
              gridLines: {
                display: true
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    },
    error:function(data){
      console.log(data);
    }
  });
})
</script>
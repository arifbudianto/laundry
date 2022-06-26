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
                      <h3 class="card-title"><i class="fas fa-chart-bar"></i> Grafik Transaksi Periode Bulanan dalam 1 Tahun</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
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
                            </p>
                        </div>
                        <div class="position-relative mb-4">
                            <canvas id="transaksi-chart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fas fa-chart-bar"></i> Grafik Customer Periode Bulanan dalam 1 Tahun</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                          <p class="d-flex flex-column">
                            <span class="text-bold text-lg text-success" id="total_customer_all_x"></span>
                            <span id="label_total_customer_all_x" class="text-muted"></span>
                          </p>
                          
                          <p class="ml-5 d-flex flex-column">
                            <span class="text-bold text-lg text-success" id="total_customer_all_y"></span>
                            <span id="label_total_customer_all_y" class="text-muted"></span>
                              
                          </p>
                      </div>
                      <div class="position-relative mb-4">
                          <canvas id="pelanggan-chart" height="300"></canvas>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fas fa-chart-pie"></i> Grafik Parfum</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="col-sm-12">
                        <div class="form-inline mb-3" style="justify-content: center;">
                          <label class="col-form-label">Bulan <i class="text-danger">*</i></label>
                          &nbsp;
                          <div class="form-group">
                              <input type ="month" name ="tgl_awal" id="tgl_awal" class="form-control" required><br/>
                          </div>
                          <div class="form-group">
                              <label>&nbsp; s/d &nbsp;</label>
                              <input type="month" class="form-control" name="tgl_akhir" id="tgl_akhir">
                          </div>
                          &nbsp;
                          <div class="form-group">
                              <button class="btn btn-info" id="btn-search" title="Cari"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                      </div>
                      <p class="text-center"><small class="required-tgl_awal text-danger"></small></p>
                      <p class="text-muted text-center"><i class="fa fa-calendar"></i> <span id="info-periode"></span></p>
                      <div class="row">
                        <div class="col-md-12"><hr/></div>
                        <div class="col-md-6">
                          <p class="text-center"><b>Grafik Parfum Keluar(Liter)</b></p>
                          <div class="chart-kondisi" style="display:none">
                            <canvas id="parfum-chart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                          </div>
                          <div class="chart-notkondisi">
                            <canvas id="parfum-chart2" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                        <div class="col-md-6">
                        <p class="text-center"><b>Grafik Parfum Jumlah Peminat</b></p>
                          <div class="chart-kondisi" style="display:none">
                            <canvas id="parfum-peminat-chart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                          </div>
                          <div class="chart-notkondisi">
                            <canvas id="parfum-peminat-chart2" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                      </div>
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

      var count = data.structure.data_result_transaksi;

      var get_periode = [];
      var data_bulan = [];
      var get_data = [];
      var data_tahun = [];
      var data_parse = [];

      var total_tahun_lalu = [];
      var total_tahun_ini = [];
      var total_tahun_lalu2 = [];
      var total_tahun_ini2 = [];
      var data_bulan_az= [];

      for(var x=0; x<count.length; x++){

        // ambil data bulan
        get_periode[x] = data.structure.data_result_transaksi[x].data_tgl_periode;
        get_data[x] = get_periode[x].split("-");
        data_bulan[x] = get_data[x][1];
        
        // ambil data tahun
        data_tahun[x] = get_data[x][0];
        data_parse[x] = parseInt(data_tahun[x]);

        var tahun_max = Math.max.apply(Math,data_parse);
        var tahun_min = Math.min.apply(Math,data_parse);

        if(tahun_max == tahun_min){
          tahun_min = tahun_max-1;
        }


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
        // check jika data sama dengan tahun max
        if(tahun_max == data_tahun[y]){

          // total transaksi per bulan tahun ini
          // transaksi
          total_tahun_ini[y] = data.structure.data_result_transaksi[y].data_total_bayar;

          // pelanggan per bulan tahun ini
          // pelanggan
          total_tahun_ini2[y] = data.structure.data_result_pelanggan[y].total_pelanggan;
          

          // menghilangkan value array null
          // transaksi
          var total_tahun_ini_x = total_tahun_ini.filter(item => item);

          // pelanggan
          var total_tahun_ini_x2 = total_tahun_ini2.filter(item => item);


        }else{
          // total transaksi per bulan tahun lalu
          // transaksi
          total_tahun_lalu[y] = data.structure.data_result_transaksi[y].data_total_bayar;

          // pelanggan per bulan tahun lalu
          // pelanggan
          total_tahun_lalu2[y] = data.structure.data_result_pelanggan[y].total_pelanggan;

          // menghilangkan value array null
          // transaksi
          var total_tahun_lalu_x = total_tahun_lalu.filter(item => item);

          // pelanggan
          var total_tahun_lalu_x2 = total_tahun_lalu2.filter(item => item);
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

      // tampilkan ke DOM transaksi
      $("#grand_total_x").text('Rp. '+grand_total_x.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#label_grand_total_x").html('Grand Total <b>'+tahun_max+'</b>');

  
      var data_total_bayar_b =[];
      var grand_total_y =0;
      if(total_tahun_lalu_x != undefined){
        for(var yx=0; yx<total_tahun_lalu_x.length; yx++){
          data_total_bayar_b[yx] = total_tahun_lalu_x[yx];
          // grand total tahun ini
          grand_total_y += parseInt(total_tahun_lalu_x[yx]);
        }
      }
      
      $("#grand_total_y").text('Rp. '+grand_total_y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#label_grand_total_y").html('Grand Total <b>'+tahun_min+'</b>');


      // total pelanggan
      var total_pelanggan_x =[];
      var total_pelanggan_all_x =0;
      for(var yx=0; yx<total_tahun_ini_x2.length; yx++){
        total_pelanggan_x[yx] = total_tahun_ini_x2[yx];

        // total pelanggan tahun ini
        total_pelanggan_all_x += parseInt(total_tahun_ini_x2[yx]);
      }

      // tampilkan ke DOM pelanggan
      $("#total_customer_all_x").text(total_pelanggan_all_x.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
      $("#label_total_customer_all_x").html('Total Customer <b>'+tahun_max+'</b>');


      var total_pelanggan_y =[];
      var total_pelanggan_all_y =0;
      if(total_tahun_lalu_x2 != undefined){
        for(var yx=0; yx<total_tahun_lalu_x2.length; yx++){
          total_pelanggan_y[yx] = total_tahun_lalu_x2[yx];
          
          // total pelanggan tahun ini
          total_pelanggan_all_y += parseInt(total_tahun_lalu_x2[yx]);
        }
      }

      $("#total_customer_all_y").text(total_pelanggan_all_y.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
      $("#label_total_customer_all_y").html('Total Customer <b>'+tahun_min+'</b>');
   
      // chart transaksi
      var $transaksiChart = $('#transaksi-chart')

      // eslint-disable-next-line no-unused-vars
      var transaksiChart = new Chart($transaksiChart, {
        type: 'bar',
        data: {
          labels: data_bulan_unique,
          datasets: [
            {
              label: 'Data Tahun '+tahun_max,
              backgroundColor: '#28a745',
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
                  if (value >= 1) {
                    value /= 1
                  }

                  return 'Rp.' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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


      // chart pelanggan
      var $pelangganChart = $('#pelanggan-chart')

      // eslint-disable-next-line no-unused-vars
      var pelangganChart = new Chart($pelangganChart, {
        type: 'bar',
        data: {
          labels: data_bulan_unique,
          datasets: [
            {
              label: 'Data Tahun '+tahun_max,
              backgroundColor: '#17a2b8',
              borderColor: '#17a2b8',
              data : total_pelanggan_x
            },
            {
              label: 'Data Tahun '+tahun_min,
              backgroundColor: '#9e9e9e',
              borderColor: '#9e9e9e',
              data : total_pelanggan_y
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
                  if (value >= 1) {
                    value /= 1
                  }

                  return value.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
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

      // =================================================
      // chart parfum
      var data_all = data.structure.data_result_parfum;

      var parfum_liter = [];
      var jenis_parfum = [];
      for(var e=0; e<data_all.length; e++){
        parfum_liter[e] = data.structure.data_result_parfum[e].total_parfum_liter;
        jenis_parfum[e] = data.structure.data_result_parfum[e].jenis_parfum;  
      }
      
      var periode = data.structure.data_result_parfum[0].data_tgl_periode;
      periode = periode.split("-");
      var periode_x = new Date( periode[0],periode[1], 0);
      periode_x = periode_x.toLocaleString('en-us', { month: 'long' })+' '+ periode[0];

      $("#info-periode").html("Periode Data : <b>"+periode_x+"</b>");

      // chart parfum not filter
      
      var parfumChartCanvas = $('#parfum-chart2').get(0).getContext('2d')
      var parfumData        = {
        labels: jenis_parfum,
        datasets: [
          {
            data: parfum_liter,
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
          }
        ]
      }
      var parfumOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      new Chart(parfumChartCanvas, {
        type: 'doughnut',
        data: parfumData,
        options: parfumOptions
      })


      // chart parfum peminat not filter
      var data_all2 = data.structure.data_result_parfum_peminat;
      var parfum_peminat = [];
      for(var f=0; f<data_all2.length; f++){
        parfum_peminat[f] = data.structure.data_result_parfum_peminat[f].total_parfum_peminat;
      }
      var parfumPeminatChartCanvas = $('#parfum-peminat-chart2').get(0).getContext('2d')
      var parfumPeminatData        = {
        labels: jenis_parfum,
        datasets: [
          {
            data: parfum_peminat,
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
          }
        ]
      }
      var parfumPeminatOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      new Chart(parfumPeminatChartCanvas, {
        type: 'doughnut',
        data: parfumPeminatData,
        options: parfumPeminatOptions
      })
      
      $("#btn-search").click(function(){

        $(".chart-kondisi").css("display","block");
        $(".chart-notkondisi").css("display","none");

        // get value form 
        var tgl_awal = $("#tgl_awal").val();
        var tgl_akhir = $("#tgl_akhir").val();

        $.ajax({
          url:"data_json.php",
          dataType:"json",
          method:"GET",
          data:{"tgl_awal":tgl_awal,"tgl_akhir":tgl_akhir},
          success:function(data_parfum){
            var data_all = data_parfum.structure.data_result_parfum;

            var parfum_liter = [];
            var jenis_parfum = [];
            for(var e=0; e<data_all.length; e++){
              parfum_liter[e] = data_parfum.structure.data_result_parfum[e].total_parfum_liter;
              jenis_parfum[e] = data_parfum.structure.data_result_parfum[e].jenis_parfum;
            }
            
            tgl_awal = tgl_awal.split("-");
            var tgl_awal_x = new Date(tgl_awal[0],tgl_awal[1] , 0);
            tgl_awal_x = tgl_awal_x.toLocaleString('en-us', { month: 'long' })+' '+ tgl_awal[0];

            tgl_akhir = tgl_akhir.split("-");
            var tgl_akhir_x = new Date(tgl_akhir[0],tgl_akhir[1] , 0);
            tgl_akhir_x = tgl_akhir_x.toLocaleString('en-us', { month: 'long' })+' '+ tgl_akhir[0];

            // label periode data
            $(".required-tgl_awal").html("");
            if(tgl_awal =='' && tgl_akhir !=''){
              $(".required-tgl_awal").html("Form Awal Wajib Diisi ..!");
            }else if(tgl_akhir !=''){
              $("#info-periode").html("Periode Data : <b>"+tgl_awal_x +" - "+ tgl_akhir_x+"</b>");
            }else if(tgl_awal =='' && tgl_akhir ==''){
              $("#info-periode").html("Periode Data : <b>"+periode_x +"</b>");
            }else{
              $("#info-periode").html("Periode Data : <b>"+tgl_awal_x +"</b>");
            }
            
            // clear form filter
            tgl_awal = $("#tgl_awal").val('');
            tgl_akhir = $("#tgl_akhir").val(''); 

            // function chart parfum
            var parfumChartCanvas = $('#parfum-chart').get(0).getContext('2d')
            var parfumData        = {
              labels: jenis_parfum,
              datasets: [
                {
                  data: parfum_liter,
                  backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
                }
              ]
            }
            var parfumOptions     = {
              maintainAspectRatio : false,
              responsive : true,
            }
            new Chart(parfumChartCanvas, {
              type: 'doughnut',
              data: parfumData,
              options: parfumOptions
            })

            // function chart parfum peminat
            var data_all2 = data_parfum.structure.data_result_parfum_peminat;
            var parfum_peminat = [];
            for(var f=0; f<data_all2.length; f++){
              parfum_peminat[f] = data_parfum.structure.data_result_parfum_peminat[f].total_parfum_peminat;
            }
            var parfumPeminatChartCanvas = $('#parfum-peminat-chart').get(0).getContext('2d')
            var parfumPeminatData        = {
              labels: jenis_parfum,
              datasets: [
                {
                  data: parfum_peminat,
                  backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
                }
              ]
            }
            var parfumPeminatOptions     = {
              maintainAspectRatio : false,
              responsive : true,
            }
            new Chart(parfumPeminatChartCanvas, {
              type: 'doughnut',
              data: parfumPeminatData,
              options: parfumPeminatOptions
            })
          },
          error:function(e){
            console.log(e);
          }
        })
        
      });
    },
    error:function(data){
      console.log(data);
    }
  });
})
</script>
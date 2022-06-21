/* global Chart:false */

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
      for(var yx=0; yx<total_tahun_ini_x.length; yx++){
        data_total_bayar_a[yx] = total_tahun_ini_x[yx];
      }

      var data_total_bayar_b =[];
      for(var yx=0; yx<total_tahun_lalu_x.length; yx++){
        data_total_bayar_b[yx] = total_tahun_lalu_x[yx];
      }
   
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
                  if (value >= 1) {
                    value /= 1
                  }

                  return 'Rp.' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
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

  

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
      datasets: [{
        type: 'line',
        data: [100, 120, 170, 167, 180, 177, 160],
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },
      {
        type: 'line',
        data: [60, 80, 70, 67, 80, 77, 100],
        backgroundColor: 'tansparent',
        borderColor: '#ced4da',
        pointBorderColor: '#ced4da',
        pointBackgroundColor: '#ced4da',
        fill: false
        // pointHoverBackgroundColor: '#ced4da',
        // pointHoverBorderColor    : '#ced4da'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})

// lgtm [js/unused-local-variable]

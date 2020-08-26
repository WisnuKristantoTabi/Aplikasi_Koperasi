@extends('template.admin')

@section('title', 'Aplikasi Akuntansi')


@section('content')

<style type="text/css">
    body{
        font-family: roboto;
    }
</style>






<div class="container">

    <h3>Dashboard Admin</h3>


    <div class="row">
           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-success shadow h-100 py-2">
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kas Saat ini</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($aktiva[0]->jumlah_perkiraan)</div>
                   </div>
                   <div class="col-auto">
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Piutang Saat ini</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($aktiva[1]->jumlah_perkiraan)</div>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>


    <div class="row">

           <div class="col-xl-8 col-lg-7">

             <!-- Area Chart -->
             <div class="card shadow mb-4">
               <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Diagram Arus Kas</h6>
               </div>
               <div class="card-body">
                 <div class="chart-area">
                   <canvas id="kas"></canvas>
                 </div>
                 <hr>
                 Diagram Arus KAS.
               </div>
             </div>

           </div>
       </div>
</div>

<script src="vendor/chart.js/Chart.min.js"></script>

<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

var x = [];
var y = [];
@foreach($kas as $k)
x.push( {{substr($k->tanggal, 5, 2)}} +" ( "+{{substr($k->tanggal, 0, 4)}} +" )" );
//x.push( {{getStringBulan(2)}} );
y.push( {{$k->saldo}} );
@endforeach

// Area Chart Example
var ctx = document.getElementById("kas");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: x,
    datasets: [{
      label: "Kas",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: y,
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '$' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});



</script>

	<script>
		/*var ctx = document.getElementById("kas").getContext('2d');
        var x = [];
        var y = [];
        @foreach($kas as $k)
        x.push( {{substr($k->tanggal, 5, 2)}} +" ( "+{{substr($k->tanggal, 0, 4)}} +" )" );
        //x.push( {{getStringBulan(2)}} );
        y.push( {{$k->saldo}} );
        @endforeach

        console.log(x);


		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: x,
				datasets: [{
					label: '# KAS',
					data: y,
                    borderColor:['rgba(255,0,0,1)'],
                    backgroundColor:['rgba(255,255,255,0.1)'],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});*/
	</script>


@endsection

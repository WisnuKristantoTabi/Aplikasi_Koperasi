@extends('template.member')

@section('title', 'Aplikasi Akuntansi')


@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Rasio Modal Sendiri</h6>
               </div>
               <div class="card-body">
                 <div class="chart-bar">
                   <canvas id="modal"></canvas>
                 </div>
                 <hr>
                 Rasio Modal Sendiri digunakan untuk mengetahui atau mengukur seberapa besar kemampuan modal sendiri yang dimiliki koperasi
                 dalam menghasilkan laba atau Sisa Hasil Usaha. Kriteria rasio modal sendiri yang baik memasukkan nilai <code> lebih besar dari {{$bunga->persen}}</code>
               </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Rasio Likuiditas</h6>
               </div>
               <div class="card-body">
                 <div class="chart-bar">
                   <canvas id="likuid"></canvas>
                 </div>
                 <hr>
                 Rasio Likuiditas digunakan untuk mengukur seberapa besar kemampuan koperasi
                 dalam memenuhi kewajiban finansial jangka pendeknya. Kriteria rasio likuiditas yang
                 baik memasukkan nilai <code> lebih besar dari 200%</code>
               </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Rasio Profitbilitas</h6>
               </div>
               <div class="card-body">
                 <div class="chart-bar">
                   <canvas id="profit"></canvas>
                 </div>
                 <hr>
                 Rasio Profitbilitas digunakan untuk mengukur kemampuan koperasi dalam memperoleh laba
                 baik dalam hubungannya dengan penjualan, aset, maupun terhadap modal sendiri.
                 Kriteria rasio profitbilitas yang baik memasukkan nilai <code> lebih besar dari 15%</code>
               </div>
        </div>
    </div>
</div>



<script src="vendor/chart.js/Chart.min.js"></script>

<script type="text/javascript">
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

const average = list => list.reduce((prev, curr) => prev + curr) / list.length;


var xmodal = [];
var ymodal = [];
@foreach($data as $d)
xmodal.push( {{substr($d->tanggal, 5, 2)}} +" ( "+{{substr($d->tanggal, 0, 4)}} +" )" );
//x.push( {{getStringBulan(2)}} );
ymodal.push( {{($d->modal == 0 ? 0 : ($d->shu / $d->modal)*100)}} );
@endforeach


// Bar Chart Example
var modalctx = document.getElementById("modal");
var modal = new Chart(modalctx, {
type: 'bar',
data: {
labels: xmodal,
datasets: [{
  label: "Rasio Modal Sendiri",
  backgroundColor: ( function(){
      if(average(ymodal)< {{$bunga->persen}} ){
          return "#8B0000";
      }else {
          return "#4e73df";
      }} ),
      //#2e59d9
      //#660000
  hoverBackgroundColor: ( function(){
      if( average(yprofit) < 1){
          return "#2e59d9";
      }else {
          return "#660000";
      }}),
  borderColor: "#4e73df",
  data: ymodal,
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
      unit: 'month'
    },
    gridLines: {
      display: false,
      drawBorder: false
    },
    ticks: {
      maxTicksLimit: 6
    },
    maxBarThickness: 25,
  }],
  yAxes: [{
    ticks: {
      min: 0,
      max: 100,
      maxTicksLimit: 5,
      padding: 10,
      // Include a dollar sign in the ticks
      callback: function(value, index, values) {
        return value + "%";
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
  titleMarginBottom: 10,
  titleFontColor: '#6e707e',
  titleFontSize: 14,
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: false,
  caretPadding: 10,
  callbacks: {
    label: function(tooltipItem, chart) {
      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
      return datasetLabel + ': ' + tooltipItem.yLabel + ' %';
    }
  }
},
}
});


var xlikuid = [];
var ylikuid = [];
@foreach($data as $d)
xlikuid.push( {{substr($d->tanggal, 5, 2)}} +" ( "+{{substr($d->tanggal, 0, 4)}} +" )" );
//x.push( {{getStringBulan(2)}} );
ylikuid.push( {{($d->utang == 0 ? 0 : ($d->aktiva / $d->utang)*100)}} );
@endforeach

// Bar Chart Example
var likuidctx = document.getElementById("likuid");
var likuid = new Chart(likuidctx, {
type: 'bar',
data: {
labels: xlikuid,
datasets: [{
  label: "Likuiditas",
  backgroundColor: ( function(){
      if(average(ylikuid)> 200){
          return "#8B0000";
      }else {
          return "#4e73df";
      }}),
  hoverBackgroundColor: ( function(){
      if( average(yprofit) < 1){
          return "#2e59d9";
      }else {
          return "#660000";
      }}),
  borderColor: "#4e73df",
  data: ylikuid,
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
      unit: 'month'
    },
    gridLines: {
      display: false,
      drawBorder: false
    },
    ticks: {
      maxTicksLimit: 6
    },
    maxBarThickness: 25,
  }],
  yAxes: [{
    ticks: {
      min: 0,
      max: 10000,
      maxTicksLimit: 5,
      padding: 10,
      // Include a dollar sign in the ticks
      callback: function(value, index, values) {
        return value +" %";
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
  titleMarginBottom: 10,
  titleFontColor: '#6e707e',
  titleFontSize: 14,
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: false,
  caretPadding: 10,
  callbacks: {
    label: function(tooltipItem, chart) {
      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
      return datasetLabel + ': ' + tooltipItem.yLabel + " %";
    }
  }
},
}
});


var xprofit = [];
var yprofit = [];
@foreach($data as $d)
xprofit.push( {{substr($d->tanggal, 5, 2)}} +" ( "+{{substr($d->tanggal, 0, 4)}} +" )" );
//x.push( {{getStringBulan(2)}} );
yprofit.push( {{($d->pendapatan == 0 ? 0 : ($d->shu / $d->pendapatan)*100)}} );
@endforeach

// Bar Chart Example
var profitctx = document.getElementById("profit");
var profit = new Chart(profitctx, {
type: 'bar',
data: {
labels: xprofit,
datasets: [{
  label: "Profitbilitas",
  backgroundColor:( function(){
      if( average(yprofit)> 15){
          return " #4e73df";
      }else {
          return " #8B0000";
      }}) ,
  hoverBackgroundColor:( function(){
      if( average(yprofit) > 15){
          return "#2e59d9";
      }else {
          return "#660000";
      }}),
  borderColor: "#4e73df",
  data: yprofit,
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
      unit: 'month'
    },
    gridLines: {
      display: false,
      drawBorder: false
    },
    ticks: {
      maxTicksLimit: 6
    },
    maxBarThickness: 25,
  }],
  yAxes: [{
    ticks: {
      min: 0,
      max: 300,
      maxTicksLimit: 5,
      padding: 10,
      // Include a dollar sign in the ticks
      callback: function(value, index, values) {
        return value + " %";
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
  titleMarginBottom: 10,
  titleFontColor: '#6e707e',
  titleFontSize: 14,
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: false,
  caretPadding: 10,
  callbacks: {
    label: function(tooltipItem, chart) {
      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
      return datasetLabel + ': ' + tooltipItem.yLabel + " %";
    }
  }
},
}
});

</script>


@endsection

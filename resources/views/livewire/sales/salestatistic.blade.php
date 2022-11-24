
@section('css')


<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />

<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto);

body {
  font-family: Roboto, sans-serif;
}

#chart {
  max-width: 60%;
  margin: 35px auto;
}
</style>


@endsection


{{-- <div class="row sales layout-top-spacing">
  <div class="col-sm-12" >

          <!-- Secciones para las Ventas -->
          <div class="widget widget-chart-one">
              <div class="widget-heading text-center">






                <div class="container">
                  <div class="row">
                    <div class="col-12">
                      
                      <h2>
                        Ventas por Mes - 2022
                      </h2>
                      


                    </div>

                    <div class="col-4">



                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select class="form-control">
                          @foreach ($listausuarios as $u)


                            @if($this->verificarpermisosventa($u->id))
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endif






                          @endforeach
                          <option value="Todos" selected>Todos los Usuarios</option>
                      </select>
                      </div>
                    </div>



                    <div class="col-4">
                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Tipo Bs</h6>
                        </div>
                          <select wire:model="usuarioseleccionado" class="form-control">
                              
                              <option value="">Emanuel</option>
                              
                              <option value="Todos" selected>Todos los Usuarios</option>
                          </select>
                      </div>
                    </div>



                    <div class="col-4">
                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Año</h6>
                        </div>
                          <select wire:model="usuarioseleccionado" class="form-control">
                              
                            <option value="">2022</option>
                            <option value="">2022</option>
                            <option value="">2022</option>
                            <option value="">2022</option>
                              
                              <option value="Todos" selected>Todos los Usuarios</option>
                          </select>
                      </div>
                    </div>

                  </div>
                </div>





              </div>


              <div id="chart">
              </div>



          </div>
  </div>
</div> --}}



<div class="">
  <div class="content">
    <div class="page-inner">
      <h4 class="page-title">Chart.js</h4>
      <div class="page-category">Simple yet flexible JavaScript charting for designers & developers. Please checkout their <a href="https://www.chartjs.org/" target="_blank">full documentation</a>.</div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Estadistica Ventas</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="lineChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Bar Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Pie Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Doughnut Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="doughnutChart" style="width: 50%; height: 50%"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Radar Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="radarChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Bubble Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="bubbleChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Multiple Line Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="multipleLineChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Multiple Bar Chart</div>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="multipleBarChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Chart with HTML Legends</div>
            </div>
            <div class="card-body">
              <div class="card-sub">
                Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
              </div>
              <div class="chart-container">
                <canvas id="htmlLegendsChart"></canvas>
              </div>
              <div id="myChartLegend"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="container-fluid">
      <nav class="pull-left">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="https://www.themekita.com">
              ThemeKita
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Help
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Licenses
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright ml-auto">
        2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
      </div>				
    </div>
  </footer>
</div>



    


@section('javascript')

{{-- <script>
      var options = {
      chart: {
        type: 'bar'
      },
      series: [{
        name: 'Ventas Emanuel',
        data: [{{$enero}},{{$febrero}},{{$marzo}},{{$abril}},{{$mayo}},{{$junio}},{{$julio}},{{$agosto}},{{$septiembre}},{{$octubre}},{{$noviembre}},{{$diciembre}}]
      }],
      xaxis: {
        categories: [
          'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'
        ]
      }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script> --}}

{{-- <script>
    var options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'Ventas',
    data: [{{$numero}},40,45,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: ['Emanuel',1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script> --}}


{{-- <script>
    var options = {
          series: [{
          data: [21, 22, 10, 28, 16, 21, 13, 30]
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: colors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: [
            ['John', 'Doe'],
            ['Joe', 'Smith'],
            ['Jake', 'Williams'],
            'Amber',
            ['Peter', 'Brown'],
            ['Mary', 'Evans'],
            ['David', 'Wilson'],
            ['Lily', 'Roberts'], 
          ],
          labels: {
            style: {
              colors: colors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script> --}}



<script>
  var lineChart = document.getElementById('lineChart').getContext('2d'),
  barChart = document.getElementById('barChart').getContext('2d'),
  pieChart = document.getElementById('pieChart').getContext('2d'),
  doughnutChart = document.getElementById('doughnutChart').getContext('2d'),
  radarChart = document.getElementById('radarChart').getContext('2d'),
  bubbleChart = document.getElementById('bubbleChart').getContext('2d'),
  multipleLineChart = document.getElementById('multipleLineChart').getContext('2d'),
  multipleBarChart = document.getElementById('multipleBarChart').getContext('2d'),
  htmlLegendsChart = document.getElementById('htmlLegendsChart').getContext('2d');

  var myLineChart = new Chart(lineChart, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Active Users",
        borderColor: "#1d7af3",
        pointBorderColor: "#FFF",
        pointBackgroundColor: "#1d7af3",
        pointBorderWidth: 2,
        pointHoverRadius: 4,
        pointHoverBorderWidth: 1,
        pointRadius: 4,
        backgroundColor: 'transparent',
        fill: true,
        borderWidth: 2,
        data: [700, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900]
      }]
    },
    options : {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        labels : {
          padding: 10,
          fontColor: '#1d7af3',
        }
      },
      tooltips: {
        bodySpacing: 4,
        mode:"nearest",
        intersect: 0,
        position:"nearest",
        xPadding:10,
        yPadding:10,
        caretPadding:10
      },
      layout:{
        padding:{left:15,right:15,top:15,bottom:15}
      }
    }
  });

  var myBarChart = new Chart(barChart, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets : [{
        label: "Sales",
        backgroundColor: 'rgb(23, 125, 255)',
        borderColor: 'rgb(23, 125, 255)',
        data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
      }],
    },
    options: {
      responsive: true, 
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      },
    }
  });

  var myPieChart = new Chart(pieChart, {
    type: 'pie',
    data: {
      datasets: [{
        data: [50, 35, 15],
        backgroundColor :["#1d7af3","#f3545d","#fdaf4b"],
        borderWidth: 0
      }],
      labels: ['New Visitors', 'Subscribers', 'Active Users'] 
    },
    options : {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        position : 'bottom',
        labels : {
          fontColor: 'rgb(154, 154, 154)',
          fontSize: 11,
          usePointStyle : true,
          padding: 20
        }
      },
      pieceLabel: {
        render: 'percentage',
        fontColor: 'white',
        fontSize: 14,
      },
      tooltips: false,
      layout: {
        padding: {
          left: 20,
          right: 20,
          top: 20,
          bottom: 20
        }
      }
    }
  })

  var myDoughnutChart = new Chart(doughnutChart, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [10, 20, 30],
        backgroundColor: ['#f3545d','#fdaf4b','#1d7af3']
      }],

      labels: [
      'Red',
      'Yellow',
      'Blue'
      ]
    },
    options: {
      responsive: true, 
      maintainAspectRatio: false,
      legend : {
        position: 'bottom'
      },
      layout: {
        padding: {
          left: 20,
          right: 20,
          top: 20,
          bottom: 20
        }
      }
    }
  });

  var myRadarChart = new Chart(radarChart, {
    type: 'radar',
    data: {
      labels: ['Running', 'Swimming', 'Eating', 'Cycling', 'Jumping'],
      datasets: [{
        data: [20, 10, 30, 2, 30],
        borderColor: '#1d7af3',
        backgroundColor : 'rgba(29, 122, 243, 0.25)',
        pointBackgroundColor: "#1d7af3",
        pointHoverRadius: 4,
        pointRadius: 3,
        label: 'Team 1'
      }, {
        data: [10, 20, 15, 30, 22],
        borderColor: '#716aca',
        backgroundColor: 'rgba(113, 106, 202, 0.25)',
        pointBackgroundColor: "#716aca",
        pointHoverRadius: 4,
        pointRadius: 3,
        label: 'Team 2'
      },
      ]
    },
    options : {
      responsive: true, 
      maintainAspectRatio: false,
      legend : {
        position: 'bottom'
      }
    }
  });

  var myBubbleChart = new Chart(bubbleChart,{
    type: 'bubble',
    data: {
      datasets:[{
        label: "Car", 
        data:[{x:25,y:17,r:25},{x:30,y:25,r:28}, {x:35,y:30,r:8}], 
        backgroundColor:"#716aca"
      },
      {
        label: "Motorcycles", 
        data:[{x:10,y:17,r:20},{x:30,y:10,r:7}, {x:35,y:20,r:10}], 
        backgroundColor:"#1d7af3"
      }],
    },
    options: {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        position: 'bottom'
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }],
        xAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      },
    }
  });

  var myMultipleLineChart = new Chart(multipleLineChart, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Python",
        borderColor: "#1d7af3",
        pointBorderColor: "#FFF",
        pointBackgroundColor: "#1d7af3",
        pointBorderWidth: 2,
        pointHoverRadius: 4,
        pointHoverBorderWidth: 1,
        pointRadius: 4,
        backgroundColor: 'transparent',
        fill: true,
        borderWidth: 2,
        data: [30, 45, 45, 68, 69, 90, 100, 158, 177, 200, 245, 256]
      },{
        label: "PHP",
        borderColor: "#59d05d",
        pointBorderColor: "#FFF",
        pointBackgroundColor: "#59d05d",
        pointBorderWidth: 2,
        pointHoverRadius: 4,
        pointHoverBorderWidth: 1,
        pointRadius: 4,
        backgroundColor: 'transparent',
        fill: true,
        borderWidth: 2,
        data: [10, 20, 55, 75, 80, 48, 59, 55, 23, 107, 60, 87]
      }, {
        label: "Ruby",
        borderColor: "#f3545d",
        pointBorderColor: "#FFF",
        pointBackgroundColor: "#f3545d",
        pointBorderWidth: 2,
        pointHoverRadius: 4,
        pointHoverBorderWidth: 1,
        pointRadius: 4,
        backgroundColor: 'transparent',
        fill: true,
        borderWidth: 2,
        data: [10, 30, 58, 79, 90, 105, 117, 160, 185, 210, 185, 194]
      }]
    },
    options : {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        position: 'top',
      },
      tooltips: {
        bodySpacing: 4,
        mode:"nearest",
        intersect: 0,
        position:"nearest",
        xPadding:10,
        yPadding:10,
        caretPadding:10
      },
      layout:{
        padding:{left:15,right:15,top:15,bottom:15}
      }
    }
  });

  var myMultipleBarChart = new Chart(multipleBarChart, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets : [{
        label: "First time visitors",
        backgroundColor: '#59d05d',
        borderColor: '#59d05d',
        data: [95, 100, 112, 101, 144, 159, 178, 156, 188, 190, 210, 245],
      },{
        label: "Visitors",
        backgroundColor: '#fdaf4b',
        borderColor: '#fdaf4b',
        data: [145, 256, 244, 233, 210, 279, 287, 253, 287, 299, 312,356],
      }, {
        label: "Pageview",
        backgroundColor: '#177dff',
        borderColor: '#177dff',
        data: [185, 279, 273, 287, 234, 312, 322, 286, 301, 320, 346, 399],
      }],
    },
    options: {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        position : 'bottom'
      },
      title: {
        display: true,
        text: 'Traffic Stats'
      },
      tooltips: {
        mode: 'index',
        intersect: false
      },
      responsive: true,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }
  });

  // Chart with HTML Legends

  var gradientStroke = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#177dff');
  gradientStroke.addColorStop(1, '#80b6f4');

  var gradientFill = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientFill.addColorStop(0, "rgba(23, 125, 255, 0.7)");
  gradientFill.addColorStop(1, "rgba(128, 182, 244, 0.3)");

  var gradientStroke2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientStroke2.addColorStop(0, '#f3545d');
  gradientStroke2.addColorStop(1, '#ff8990');

  var gradientFill2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientFill2.addColorStop(0, "rgba(243, 84, 93, 0.7)");
  gradientFill2.addColorStop(1, "rgba(255, 137, 144, 0.3)");

  var gradientStroke3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientStroke3.addColorStop(0, '#fdaf4b');
  gradientStroke3.addColorStop(1, '#ffc478');

  var gradientFill3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
  gradientFill3.addColorStop(0, "rgba(253, 175, 75, 0.7)");
  gradientFill3.addColorStop(1, "rgba(255, 196, 120, 0.3)");

  var myHtmlLegendsChart = new Chart(htmlLegendsChart, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [ {
        label: "Subscribers",
        borderColor: gradientStroke2,
        pointBackgroundColor: gradientStroke2,
        pointRadius: 0,
        backgroundColor: gradientFill2,
        legendColor: '#f3545d',
        fill: true,
        borderWidth: 1,
        data: [154, 184, 175, 203, 210, 231, 240, 278, 252, 312, 320, 374]
      }, {
        label: "New Visitors",
        borderColor: gradientStroke3,
        pointBackgroundColor: gradientStroke3,
        pointRadius: 0,
        backgroundColor: gradientFill3,
        legendColor: '#fdaf4b',
        fill: true,
        borderWidth: 1,
        data: [256, 230, 245, 287, 240, 250, 230, 295, 331, 431, 456, 521]
      }, {
        label: "Active Users",
        borderColor: gradientStroke,
        pointBackgroundColor: gradientStroke,
        pointRadius: 0,
        backgroundColor: gradientFill,
        legendColor: '#177dff',
        fill: true,
        borderWidth: 1,
        data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900]
      }]
    },
    options : {
      responsive: true, 
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      tooltips: {
        bodySpacing: 4,
        mode:"nearest",
        intersect: 0,
        position:"nearest",
        xPadding:10,
        yPadding:10,
        caretPadding:10
      },
      layout:{
        padding:{left:15,right:15,top:15,bottom:15}
      },
      scales: {
        yAxes: [{
          ticks: {
            fontColor: "rgba(0,0,0,0.5)",
            fontStyle: "500",
            beginAtZero: false,
            maxTicksLimit: 5,
            padding: 20
          },
          gridLines: {
            drawTicks: false,
            display: false
          }
        }],
        xAxes: [{
          gridLines: {
            zeroLineColor: "transparent"
          },
          ticks: {
            padding: 20,
            fontColor: "rgba(0,0,0,0.5)",
            fontStyle: "500"
          }
        }]
      }, 
      legendCallback: function(chart) { 
        var text = []; 
        text.push('<ul class="' + chart.id + '-legend html-legend">'); 
        for (var i = 0; i < chart.data.datasets.length; i++) { 
          text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>'); 
          if (chart.data.datasets[i].label) { 
            text.push(chart.data.datasets[i].label); 
          } 
          text.push('</li>'); 
        } 
        text.push('</ul>'); 
        return text.join(''); 
      }  
    }
  });

  var myLegendContainer = document.getElementById("myChartLegend");

  // generate HTML legend
  myLegendContainer.innerHTML = myHtmlLegendsChart.generateLegend();

  // bind onClick event to all LI-tags of the legend
  var legendItems = myLegendContainer.getElementsByTagName('li');
  for (var i = 0; i < legendItems.length; i += 1) {
    legendItems[i].addEventListener("click", legendClickCallback, false);
  }

</script>


@endsection

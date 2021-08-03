@extends('layouts.app')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>
<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="hospital-tiles primary">
                <img src="{{ asset('assets/images/hospital/appointment.svg') }}" alt="Appointments" />
                <p>Appointments</p>
                <h2>{{count($appointments)}}</h2>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="hospital-tiles blue" style="cursor: url(hand.cur), pointer" onClick = "window.location.href = 'patient'">
                <img src="{{ asset('assets/images/hospital/patient.svg') }}"  alt="Patients" />
                <p>New Patients</p>
                <h2>{{count($patients)}}</h2>
            </div>
        </div>        
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="hospital-tiles green">
                <img src="{{ asset('assets/images/hospital/doctor.svg') }}"  alt="Doctors" />
                <p>Doctors</p>
                <h2>{{count($doctors)}}</h2>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="hospital-tiles secondary">
                <img src="{{ asset('assets/images/hospital/staff.svg') }}"  alt="Staff" />
                <p>Users</p>
                <h2>{{count($users)}}</h2>
            </div>
        </div>        
    </div>
<!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Clinic target</div>
                </div>
                <div class="card-body">
                    <div class="line-chart" id="filledLineChart" style="min-height:350px"></div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function(){
var series = 
{
	"monthDataSeries1": {
		"prices":[110, 80, 125, 65, 95, 75, 90, 110, 80, 125, 70, 95],
		"dates": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	}
}


var options = {
	chart: {
		height: 300,
		type: 'area'		
	},
	dataLabels: {
		enabled: false
	},
	stroke: {
		curve: 'smooth',
		width: 3,
	},
	series: [{
		name: "",
		data: series.monthDataSeries1.prices
	}],	
	grid: {
		row: {
			colors: ['#f4f5fb', '#ffffff'], // takes an array which will be repeated on columns
			opacity: 0.5
		},
	},
	labels: series.monthDataSeries1.dates,
	xaxis: {
		type: 'month',
	},
	yaxis: {
		opposite: true
	},	
	theme: {
		monochrome: {
			enabled: true,
			color: '#074b9c',
			shadeIntensity: 0.1
		},
	},
	markers: {
		size: 0,
		opacity: 0.2,
		colors: ["#074b9c"],
		strokeColor: "#fff",
		strokeWidth: 2,
		hover: {
			size: 7,
		}
	},
}

var chart = new ApexCharts(
	document.querySelector("#filledLineChart"),
	options
);

chart.render();
});

// !(function (NioApp, $) {
//     "use strict";

//     var filledLineChart = {
//         labels : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
//         dataUnit : 'USD',
//         lineTension : .4,
//         datasets : [{
//             label : "Total Received",
//             color : "#9d72ff",
//             background : NioApp.hexRGB('#9d72ff',.4),
//             data: [110, 80, 125, 65, 95, 75, 90, 110, 80, 125, 70, 95]
//         }]
//     };


//     function lineChart(selector, set_data){
//         var $selector = (selector) ? $(selector) : $('.line-chart');
//         $selector.each(function(){
//             var $self = $(this), _self_id = $self.attr('id'), _get_data = (typeof set_data === 'undefined') ? eval(_self_id) : set_data;
//             var selectCanvas = document.getElementById(_self_id).getContext("2d");

//             var chart_data = [];
//             for (var i = 0; i < _get_data.datasets.length; i++) {
//                 chart_data.push({
//                     label: _get_data.datasets[i].label,
//                     tension:_get_data.lineTension,
//                     backgroundColor: _get_data.datasets[i].background,
//                     borderWidth:2,
//                     borderColor: _get_data.datasets[i].color,
//                     pointBorderColor: _get_data.datasets[i].color,
//                     pointBackgroundColor: '#fff',
//                     pointHoverBackgroundColor: "#fff",
//                     pointHoverBorderColor: _get_data.datasets[i].color,
//                     pointBorderWidth: 2,
//                     pointHoverRadius: 4,
//                     pointHoverBorderWidth: 2,
//                     pointRadius: 4,
//                     pointHitRadius: 4,
//                     data: _get_data.datasets[i].data,
//                 });
//             } 
//             var chart = new Chart(selectCanvas, {
//                 type: 'line',
//                 data: {
//                     labels: _get_data.labels,
//                     datasets: chart_data,
//                 },
//                 options: {
//                     legend: {
//                         display: (_get_data.legend) ? _get_data.legend : false,
//                         rtl: NioApp.State.isRTL,
//                         labels: {
//                             boxWidth:12,
//                             padding:20,
//                             fontColor: '#6783b8',
//                         }
//                     },
//                     maintainAspectRatio: false,
//                     tooltips: {
//                         enabled: true,
//                         rtl: NioApp.State.isRTL,
//                         callbacks: {
//                             title: function(tooltipItem, data) {
//                                 return data['labels'][tooltipItem[0]['index']];
//                             },
//                             label: function(tooltipItem, data) {
//                                 return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
//                             }
//                         },
//                         backgroundColor: '#eff6ff',
//                         titleFontSize: 20,
//                         titleFontColor: '#6783b8',
//                         titleMarginBottom: 6,
//                         bodyFontColor: '#9eaecf',
//                         bodyFontSize: 12,
//                         bodySpacing:4,
//                         yPadding: 10,
//                         xPadding: 10,
//                         footerMarginTop: 0,
//                         displayColors: false
//                     },
//                     scales: {
//                         yAxes: [{
//                             display: true,
//                             position : NioApp.State.isRTL ? "right" : "left",
//                             ticks: {
//                                 beginAtZero: false,
//                                 fontSize:12,
//                                 fontColor:'#9eaecf',
//                                 padding: 10
//                             },
//                             gridLines: { 
//                                 color: NioApp.hexRGB("#526484",.2),
//                                 tickMarkLength:0,
//                                 zeroLineColor: NioApp.hexRGB("#526484",.2)
//                             },
//                         }],
//                         xAxes: [{
//                             display: true,
//                             ticks: {
//                                 fontSize:12,
//                                 fontColor:'#9eaecf',
//                                 source: 'auto',
//                                 padding: 5,
//                                 reverse: NioApp.State.isRTL
//                             },
//                             gridLines: {
//                                 color: "transparent",
//                                 tickMarkLength:10,
//                                 zeroLineColor: NioApp.hexRGB("#526484",.2),
//                                 offsetGridLines: true,
//                             }
//                         }]
//                     }
//                 }
//             });
//         })
//     }

//     // init line chart
//     lineChart();


// })(NioApp, jQuery);
</script>

@endsection

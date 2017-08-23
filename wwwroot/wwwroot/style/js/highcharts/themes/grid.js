/**
 * Grid theme for Highcharts JS
 * @author Torstein Hønsi
 */

Highcharts.theme = {
	colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	chart: {
		backgroundColor: {
			linearGradient: [0, 0, 500, 500],
			stops: [
				[0, 'rgb(255, 255, 255)'],
				[1, 'rgb(240, 240, 255)']
			]
		},
		borderWidth: 2,
		plotBackgroundColor: 'rgba(255, 255, 255, .9)',
		plotShadow: true,
		plotBorderWidth: 1
	},
	title: {
		style: {
			color: '#333',
			font: 'bold 16px Verdana, "Microsoft YaHei", Arial'
		}
	},
	subtitle: {
		style: {
			color: '#666666',
			font: 'bold 12px Verdana,"Microsoft YaHei",Arial'
		}
	},
	xAxis: {
		gridLineWidth: 1,
		lineColor: '#222',
		tickColor: '#222',
		labels: {
			style: {
				color: '#222',
				font: '11px Verdana,"Microsoft YaHei",Arial'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Verdana,"Microsoft YaHei",Arial'

			}
		}
	},
	yAxis: {
		minorTickInterval: 'auto',
		lineColor: '#222',
		lineWidth: 1,
		tickWidth: 1,
		tickColor: '#222',
		labels: {
			style: {
				color: '#222',
				font: '11px Verdana,"Microsoft YaHei",Arial'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Verdana,"Microsoft YaHei",Arial'
			}
		}
	},
	legend: {
		itemStyle: {
			font: '9pt Verdana,"Microsoft YaHei",Arial',
			color: 'black'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		}
	},
	labels: {
		style: {
			color: '#99b'
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);


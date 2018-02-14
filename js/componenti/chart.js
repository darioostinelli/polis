function Charts (rawData) {
	this.data = rawData;
	
	this.displayCharts = function(){
		$('#metrics-container').html("");
    	for(let i = 0; i < this.data.length; i++){    		
    		$('#metrics-container').append("<div class='chart-container' id='metrics-container"+i+"'></div>");
    		displayChart(i, this.data[i].metric, this.data[i].unit, this.data[i].list);
    	}
  
    }
	
	this.displayChart = function(index, title, unit, data){
		list = getDataSeries(this.data);
		Highcharts.chart('metrics-container'+index, {

			chart: {
		        type: 'spline'
		    },
		    
			title: {
		        text: title
		    },
		    
		    xAxis: {
		        type: 'datetime',	       
		        title: {
		            text: 'Date'
		        }
		    },

		    yAxis: {
		        title: {
		            text: unit
		        }
		    },
		    legend: {
		        layout: 'vertical',
		        align: 'right',
		        verticalAlign: 'middle'
		    },

		    plotOptions: {
		        series: {
		            label: {
		                connectorAllowed: false
		            }
		            
		        }
		    },

		    series: [{
		        name: title,
		        data: list
		    }],

		    responsive: {
		        rules: [{
		            condition: {
		                maxWidth: 500
		            },
		            chartOptions: {
		                legend: {
		                    layout: 'horizontal',
		                    align: 'center',
		                    verticalAlign: 'bottom'
		                }
		            }
		        }]
		    }

		});
	}

	this.getDataSeries = function(list){
		var serie = [];
		for(let i = 0; i < list.length; i++){
			var d = new Date(list[i].time_stamp);		
			var date = Date.UTC(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes(), d.getSeconds());
			var value = parseFloat(list[i].value);
			var item = [date, value];
			serie.push(item);
		}
		return serie;
	}

	this.getTimeString = function(date){
		string = date.getHours() + ":";
		string += date.getMinutes() >= 10 ? date.getMinutes() : "0" + date.getMinutes();
		string += ":";
		string += date.getSeconds() >= 10 ? date.getSeconds() : "0" + date.getSeconds();
		return string;
	}
	
	function compareTimeStamps(a,b) {
		  if (a.time_stamp < b.time_stamp)
		    return 1;
		  if (a.time_stamp > b.time_stamp)
		    return -1;
		  return 0;
		}
}

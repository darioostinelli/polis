$().ready(function(){
		$( "#chart-options" ).change(function(){
			var val = $(this).val();
			console.log(val);
			switch(val){
				case 'today': charts.displayTodaysData(); break;
				case '5-val': charts.displayLastN(5); break;
				case '10-val': charts.displayLastN(10); break;
				case '20-val': charts.displayLastN(20); break;
				case '2-days': charts.displayLastNDays(2); break;
				case '7-days': charts.displayLastNDays(7); break;
				case '14-days': charts.displayLastNDays(14); break;
				case '30-days': charts.displayLastNDays(30); break;
				case 'all': charts.displayAll(); break;
				
			}
		})
	});
function Charts (rawData) {
	this.currentData = rawData;
	this.originalData = rawData;
	
	
	this.displayCharts = function(){
		$('#metrics-container').html("");
		this.currentData.sort(compareTimeStamps);
    	for(let i = 0; i < this.currentData.length; i++){    		
    		$('#metrics-container').append("<div class='chart-container' id='metrics-container"+i+"'></div>");
    		this.displayChart(i, this.currentData[i].metric, this.currentData[i].unit, this.currentData[i].list);
    	}
  
    }
	this.displayTodaysData = function(){
		
		this.currentData = JSON.parse(JSON.stringify(this.originalData));
		for(let i = 0; i < this.originalData.length; i++){			
			for(let j = 0; j < this.currentData[i].list.length; j++){
				if(!this.isToday(this.currentData[i].list[j].time_stamp)){
					this.currentData[i].list.splice(j, 1);
					j--;
				}
			}
		}
		this.displayCharts();
	}
	this.displayAll = function(){
		this.currentData = this.originalData;		
		this.displayCharts();
	}
	this.displayLastN = function(n){
		this.currentData = JSON.parse(JSON.stringify(this.originalData));
		for(let i = 0; i < this.originalData.length; i++){			
			if(this.originalData[i].list.length >= n){
				var a = this.currentData[i].list.length - n;
				var a = this.currentData[i].list.splice(0, a);
			}
		}
		this.displayCharts();
	}
	
	this.displayLastNDays = function(n){
		this.currentData = JSON.parse(JSON.stringify(this.originalData));
		for(let i = 0; i < this.originalData.length; i++){			
			for(let j = 0; j < this.currentData[i].list.length; j++){
				var today = new Date();
				var date = new Date(this.currentData[i].list[j].time_stamp);
				if(this.getDifferenceDays(date, today) > n){
					this.currentData[i].list.splice(j, 1);
					j--;
				}
			}
		}
		this.displayCharts();
	}
	this.isToday = function(tdString) {
	    var d = new Date();
	    var td = new Date(tdString);
	    return td.getDate() == d.getDate() && td.getMonth() == d.getMonth() && td.getFullYear() == d.getFullYear();
	}
	
	this.getDifferenceDays = function(date1, date2){
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		return Math.ceil(timeDiff / (1000 * 3600 * 24));
	}
	this.displayChart = function(index, title, unit, list){
		list = getDataSeries(list);
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

var ChartWrapper = {};
      
      ChartWrapper.drawChart = function (options, json_data, chartContainerID, horizontal, width,height, show_table) {
            var chart;
            if(typeof google!='undefined'){//ensure google charts lib is loaded
		  $('#reference').addClass('show_analysis');
                  $('#chart_div').addClass('show_analysis');
                  
                  show_table = (show_table==null)? false : show_table;//show_table is now an optional parameter. Default value is false.
                  
                        var data;
      
                        /**CREATE DATA OBJECTS**/
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'method');
                        data.addColumn('number', 'points');
                        var pointSum = 0;
                        for(json_index in json_data){
                              var row = json_data[json_index];
                              data.addRow([row.method, row.number]);
                              pointSum = pointSum + row.number;
                        }
                        var data_rf = null;
                        if(options.result_type === "nominal"){
                              data_rf= new google.visualization.DataTable();
                              data_rf.addColumn('string', 'method');
                              data_rf.addColumn('number', 'points');                        
                              for(json_index in json_data){
                                    var row = json_data[json_index];
                                    data_rf.addRow([row.method, row.number/pointSum]);
                              }
                        }
      
                        /**DRAW THE CHART**/
                        var chart;
                        if(horizontal==false){
                              chart = new google.visualization.ColumnChart(document.getElementById(chartContainerID));                                                     
                              if(options.result_type === "ordinal"){
                                    chart.draw(data, {
                                        width: width, 
                                        height: height, 
                                        legend: 'none',
                                        colors:['#A3CAF9'],    
                                        enableInteractivity: false,
                                          vAxis: {
                                                  minValue: options.min_points,
                                                  maxValue: options.max_points,
                                                  viewWindow:{min:options.min_points, max:options.max_points},
                                                  
                                                  viewWindowMode:'explicit',
                                                  gridlines:{count: (options.max_points - options.min_points+1)},
                                                  format : '0'
                                                },
                                    });                       
            
                              }
                              else if(options.result_type === "nominal"){
                                    chart.draw(data_rf, {
                                        width: width, 
                                        height: height, 
                                        legend: 'none',
                                        vAxis: {
                                          minValue:0,
                                          maxValue:100,
                                          format:'#.###%',
                                          viewWindow:{min:0, max:1},
                                          viewWindowMode:'explicit',
                                          gridlines:{count: 6}
                                        },
                                          enableInteractivity: false,
                                          colors:['#A3CAF9']
                                    });                       
                                    
                              }
                        }
                        else{//horizontal==true
                              chart = new google.visualization.BarChart(document.getElementById(chartContainerID));
                              if(options.result_type === "ordinal"){
                                    chart.draw(data, {
                                        width: width, 
                                        height: height, 
                                        legend: 'none',
                                        hAxis: {
                                          minValue:options.min_points,
                                          maxValue:options.max_points,
                                          format:'##.##',
                                          viewWindow:{min:options.min_points, max:options.max_points},
                                          viewWindowMode:'explicit',
                                          gridlines:{count: (options.max_points - options.min_points+1)}
                                        },
                                          enableInteractivity: false,
                                          colors:['#A3CAF9']
                                    });   
                              }
                              else if(options.result_type === "nominal"){
                                    chart.draw(data_rf, {
                                        width: width, 
                                        height: height, 
                                        legend: 'none',
                                        hAxis: {
                                          minValue:0,
                                          maxValue:100,
                                          format:'#.###%',
                                          viewWindow:{min:0, max:1},
                                          viewWindowMode:'explicit',
                                          gridlines:{count: 6}
                                        },
                                          enableInteractivity: false,
                                          colors:['#A3CAF9']
                                    });                       
                                    
                              }
                        }
                        
                        /**DRAW THE TABLE**/
                        if(show_table == true){
                              var cssClassNames = {
                                    'tableCell': 'analysis_table_cell'
                              }
                              var tbl = new google.visualization.Table(document.getElementById(chartContainerID+"_table"));
                              tbl.draw(data,{
                                    title:'Points received by Similarity Measure',
                                    'cssClassNames': cssClassNames
                              });
      
                        }
                              

            }
            return chart;
      }

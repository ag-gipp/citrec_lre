      //the chart lib needs to be included before the onload listener
      google.load('visualization', '1.0', {'packages':['corechart', 'table']});
      var Analysis={};

     Analysis.drawGraphs = function(ex_id){
                var optionsUrl = "analysis/options/" + ex_id;
                $.getJSON(optionsUrl,function(options){
                        
                        $.getJSON("analysis/experiment/"+ ex_id,function(data){
                                ChartWrapper.drawChart(options, data, "chart_div_all",false, 450,200,true);
                        });
                        $.getJSON("analysis/experiment/"+ ex_id +"/for_current_user",function(data){
                                ChartWrapper.drawChart(options, data, "chart_div_user",false, 450,200,true);
                        });
                        //ChartWrapper.drawChart(options, "analysis/experiment/"+ ex_id +"/for_current_user", "chart_div_user",false, 450,200,true);
                });      
        }
    
    $(document).ready(function() {
           
            Analysis.drawGraphs($('#experiment').val());
            $('#experiment').change(function(){
                Analysis.drawGraphs($('#experiment').val());
            });
            
            $("#form_reload").click(function(){
                Analysis.drawGraphs($('#experiment').val());
            });
    });
    
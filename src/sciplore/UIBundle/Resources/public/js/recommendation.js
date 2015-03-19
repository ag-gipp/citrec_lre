      //the chart lib needs to be included before the onload listener
        var Recommendation = {};
        if(typeof google!='undefined'){
            google.load('visualization', '1.0', {'packages':['corechart']});
        }
        Recommendation.highlightArticles = function (id){
            $(".article").removeClass('article-highlight');
            $('.article input[type="radio"]').each(function(){
                if($(this).attr("value")==id){
                    $(this).closest(".article").addClass("article-highlight");//navigate up to the corresponding article and highlight it
                }
            });
        }
	
	Recommendation.PBLABEL="";
	Recommendation.graphData=null, Recommendation.options=null;
	
	Recommendation.renderIfReady = function (){
	    //!!Not Multithreading Safe!!. Only works with SingleThreading.
	    if(Recommendation.graphData != null && Recommendation.options != null){
		ChartWrapper.drawChart(Recommendation.options, Recommendation.graphData, "chart_graphics",true, 300,75,false);
	    }
	}
	
	
	Recommendation.showProgressBar = function (json){

             //load the current progress in the progressbar
            var val = (json.cur+1) / json.max * 100;
            Recommendation.PBLABEL= "Recomendation " + (json.cur+1) + " of " + (json.max);
            $('#progressbar').progressbar('value', val);
	}
        //ONLOAD / MAIN Function
	$(function() {
	    
	    $.getJSON("current_data",function(json){
		Recommendation.graphData = json;
		Recommendation.renderIfReady();
	    });
	    //load the options and draw the graph
	    $.getJSON("current_options",function(json){
	        Recommendation.options = json;
	        Recommendation.renderIfReady();
	    });
	    //initalize the progressbar
	    $('#progressbar').progressbar({
                value: 0,
                change: function(event, ui) {
                $('.pblabel').text(Recommendation.PBLABEL);
              }
            });
	    
             //load the progressbar
	    $.getJSON('../experiment/progress',function(json){
	        Recommendation.showProgressBar(json);
	    });	    
            //highlight current article
            var id = $('article .article_footer input[checked="true"]').first().attr("value");
            if(id != null){
                Recommendation.highlightArticles(id);
            }

            //add eventhandler for article highlighting
            $(".select_radio").change(function(event){
                var select_radio = $(this);
		var id = select_radio.val();
                Recommendation.highlightArticles(id);
            });

	   
	});
$(function() {
   $(".delete_results").submit(function(e){
      var confirm_result = confirm('Do you really want to delete all your results of this experiment? You CANNOT undo this action!');
      if (confirm_result) {               
         return true;
      }
      else {
          //Prevent the submit event and remain on the screen
         e.preventDefault();
         return false;
      }
  
    }); 
});
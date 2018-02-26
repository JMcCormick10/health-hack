//Created By Rahul Malik
 $(document).ready(function() {

    

     $('.ratings_stars').click(
     // Handles the mouseover
     function () {
         // set rating
         $(this).prevAll().addClass('ratings_vote');
         $(this).addClass('ratings_vote');
         var numItems = $('.ratings_vote').length;
         $("#RatNum").val(numItems);
        
     }
     );
      $('.ratings_stars').hover(
      // Handles the mouseover
      function() {
          $(this).prevAll().addClass('ratings_over');
          $(this).addClass('ratings_over');
          $(this).nextAll().removeClass('ratings_vote');
      },
      // Handles the mouseout
      function() {
          $(this).prevAll().removeClass('ratings_over');
          $(this).removeClass('ratings_over');
          
          
      }
      );

	  $('#SubmitRating').click(
     // Handles the save click event
    function () {
		
	  document.getElementById('FrmRating').submit();
        
        
     }
     );
      


  });

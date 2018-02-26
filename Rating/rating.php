<?php
/*Created By Rahul Malik*/

?>
<div id="rating_div">
  <h2>Rating</h2>
  <p>Let us know what do you think...</p>
  <form id="FrmRating" name="FrmRating" action="/health-hack/rating/submit_rating.php" method="post">
    <input type="hidden" name="ModuleID" id="ModuleID" value="<?php echo($ModuleID);?>">
    </input>
    <input type="hidden" name="RatNum" id="RatNum" value=""></input>
    <textarea cols="45" rows="10" name="Description" id="Description"></textarea>
    <div>
      <div>
        <div class='rate_choice'>

          <div id="r1" class="rate_widget">
            <div class="star_1 ratings_stars"></div>
            <div class="star_2 ratings_stars"></div>
            <div class="star_3 ratings_stars"></div>
            <div class="star_4 ratings_stars"></div>
            <div class="star_5 ratings_stars"></div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div>
		<a href="#" id="SubmitRating" class="btn btn-info btn-lg offset-md-0">
						<span class="glyphicon glyphicon-circle-arrow-left"></span>Save Rating
					</a>
        
      </div>
    </div>
    <?php 
        require_once '../Models/Rating.php';
        $RatingObj = new Rating();
       $AvgRating=$RatingObj->GetAvgRating($ModuleID);
       $TopRating=$RatingObj->GetTopRating($ModuleID);
       
      ?>
    <div>
      <div id="AvgDiv">
        <div id="AvgRating">Avergage Rating: </div>
        <div id='AvgChoice'>

          <div id="r2" class="rate_widget">
            <img src="../opt-imgs/<?php echo($AvgRating);?>star.jpg"></img>


          </div>
        </div>
      </div>
    </div>
    <div>
        <div>
          <div id="RatingContainer">
            <?php for($i=0;$i<count($TopRating);$i++) {?>
              <div class="TopRatingDiv">
                <?php echo($TopRating[$i]['description']);?> 
              </div>
             
             <?php } ?>
          </div>
        </div>
      </div>
     
    </form>

  </div>
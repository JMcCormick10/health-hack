<!-- 02-2-3. Footer -->
<footer id="footer" class="col-md-12 col-sm-12 col-12">
    <p class="white">Health Hack</p>
</footer>
<!--end site canvas-->
</div>
<!--end wrapper-->
</div>
</body>
<!-- Importing Files -->
<?php
$currentpage = $_SERVER['REQUEST_URI'];
?>
<!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/9760713875.js"></script>
<?php if($homepage == $currentpage || $homepage2 == $currentpage) { ?>
    <script src="Scripts/script.js"></script>
<?php } else { ?>
    <script src="../Scripts/script.js"></script>
<?php } ?>
</html>

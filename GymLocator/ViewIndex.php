<?php

    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>
    <div id="mapHolder" class="col-sm-9">
        <h2>Find Your Gym</h2>

        <a href="/health-hack" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>

        <input type="text" id="pac-input" class="controls" placeholder="Enter place to search for Gyms around">

        <div id="map">
        </div>

        <div id="infowindow-content">
            <span id="place-name" class="title"></span><br>
            <span id="place-address"></span><br>
            <img id="place-photo" src=""  width="50" height="50" /><br>
            <form id="add-gym-form" action="../Gym/index.php" method="post">
                <input type="hidden" name="place-id" id="place-id-input">
                <input type="hidden" name="place-name" id="place-name-input">
                <input type="hidden" name="place-address" id="place-address-input">
                <input type="hidden" name="place-lat" id="place-lat-input">
                <input type="hidden" name="place-lng" id="place-lng-input">
                <input type="submit" name="addGym" class="btn btn-info" value="Add to Gyms">
            </form>
        </div>

        <div id="infowindow-content-place">
            <span id="search-place-name" class="title"></span><br>
            <span id="search-place-address"></span>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-eAHJBHdVL8yYg7eeHsY5rg8f1Q1qZ4Q&libraries=places" async defer></script>
    <script src="../Scripts/GymLocator.js"></script>
<?php
    require_once('../Common Views/Footer.php');
?>

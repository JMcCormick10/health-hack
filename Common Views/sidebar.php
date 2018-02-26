<?php



?>
<!-- 02-2. Main Content -->
<main id="main" class="row">
    <!-- 02-2-1. Nav -->
    <nav id="nav" class="col-md-3 col-sm-0 col-0">
        <!-- 02-2-1-1. Profile Photo -->
        <div class="profile">

            <?php
            if($homepage == $currentpage || $homepage2 == $currentpage || preg_match($access, $currentpage2))
            {?>
                <?php if ($img)
                {?>
                <img src="opt-imgs/<?php echo $img; ?>" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" />
                <?php }
                else
                {?>
                <img src="opt-imgs/login-photo.png" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" />
                <?php }?>
            <?php
            }
            else
            {
            ?>
                <?php if ($img)
            {?>
                <img src="../opt-imgs/<?php echo $img; ?>" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" />
            <?php }
            else
            {?>
                <img src="../opt-imgs/login-photo.png" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" />
            <?php }?>
            <?php
            }
            ?>
            <!--<img src="../opt-imgs/profile-photo.png" class="profile-photo" alt="Profile Photo" />-->
            <!-- 02-2-1-2. User Details -->
            <h2><?php if(isset($userName)){ echo $userName; } ?></h2>
            <p class="dark-grey center-text"><?php if(isset($userEmail)){ echo $userEmail; } ?></p>
        </div>
        <!-- 02-2-1-3. Links -->
        <div class="nav-links">
            <ul>
                <li class="link-hover"><a href="/health-hack/Dashboard" title="Dashboard Link">Dashboard</a></li>
                <li class="link-hover"><a href="/health-hack/Calendar" title="Calendar Link">Calendar</a></li>
                <li class="link-hover"><a href="/health-hack/FitnessProgress" title="Fitness Link">Fitness Progress</a></li>
                <li class="link-hover"><a href="/health-hack/GymLocator" title="Gym Locator Link">Gym Locator</a></li>
                <li class="link-hover"><a href="/health-hack/GroceryList" title="Nutrition Link">Nutrition</a></li>
                <li class="link-hover"><a href="/health-hack/logout.php" title="Log Out Link" >Log Out</a></li>
            </ul>
        </div>
    </nav>
    
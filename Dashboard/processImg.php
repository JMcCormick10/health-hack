<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 */

// valid that image has no errors
function ImgCode($img)
{

    $file_error_code = $img;

    // if there is a problem, inform user of error
    if ($file_error_code > 0)
    {
        echo "Problem";
        switch ($file_error_code)
        {
            // if the file exceeds the max upload size
            case 1:
                echo "File exceeded upload_max_filesize.";
                break;
            // if the file exceeds the max
            case 2:
                echo "File exceeded max_file_size";
                break;
            // if the file is only partially uploaded
            case 3:
                echo "File only partially uploaded.";
                break;
            // if no file is present
            case 4:
                echo "No file uploaded.";
                break;
        }
        // if a problem occurs, exit the function
        exit;
    }
    //if a success return true
    return true;
}

// valid size of image
function ImgSize($img)
{

    $file_size = $img;

    $max_file_size = 200000;
    if($file_size > $max_file_size)
    {
        echo "file size too big";
        exit;
    }

    //if a success return true
    return true;
}

// map the path of img
function ImgPath($img, $username)
{

    //require_once '../opt-imgs';
    $imgPath = $img;
    $user = $username;
    //set up target path
    $target_path = "opt-imgs/";

    // create path for image and move image there
    $path = $target_path . "user?" .  $user . "/profile-image?" . $imgPath;
    return $path;
}

//resize Images to 139x139
// based on "How to Work with files, uploads, and images" Joel Murach, PHP/MySQL 2nd Edition (Chapter 23, 773-776)
//
//function ProfileImageSize($original, $new, $width = 139 ,$height = 139)
//{
//    //get image type
//    $imgInfo = getimagesize($original);
//    $type = $imgInfo[2];
//
//    //set up function names (based upon image extensions)
//    switch($type)
//    {
//        case IMAGETYPE_JPEG:
//            $fromFile = "imagecreatefromjpeg";
//            $toFile = "ImgJPEG";
//            break;
//        case IMAGETYPE_GIF:
//            $fromFile = "imagecreatefromgif";
//            $toFile = "ImgGIF";
//            break;
//        case IMAGETYPE_PNG:
//            $fromFile = "imagecreatefrompng";
//            $toFile = "ImgPNG";
//            break;
//        default:
//            echo "File Must be a JPEG, GIF, or PNG image";
//            exit;
//    }
//
//    // get old image & height/width
//    $oldImg = $fromFile($original);
//    $oldWidth = imagesx($oldImg);
//    $oldHeight = imagesy($oldImg);
//
//    // calculate height and width ratios
//    $widthRatio = $oldWidth / $width;
//    $heightRatio = $oldHeight / $height;
//
//    // if image is larger than specified ratio, create new image
//    if ($widthRatio > 1 || $heightRatio > 1)
//    {
//        // calculate heigth & width for new image
//        $ratio = max($widthRatio, $heightRatio);
//        $newHeight = round($oldHeight / $ratio);
//        $newWidth = round($oldWidth / $ratio);
//
//        // create new image
//        $new_image = imagecreatetruecolor($newHeight,$newWidth);
//
//        // copy old image to new image - resizes image
//        $new_x = 0;
//        $new_y = 0;
//        $old_x = 0;
//        $old_y = 0;
//        imagecopyresampled($new_image, $oldImg, $new_x, $new_y, $old_x, $old_y, $newWidth, $newHeight, $oldWidth, $oldHeight);
//
//        // write new image to a new file
//        //$toFile($new_image, $new);
//        imagepng($new, $original);
//
//        // free any memory associated with new image
//        imagedestroy($new_image);
//    }
//    else
//    {
//        //write old image to new file
//        imagepng($new, $original);
//    }
//
//    // free any memory associated with old image
//    imagedestroy($oldImg);
//}


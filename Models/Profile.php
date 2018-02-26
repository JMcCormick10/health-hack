<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 */
require_once 'Database.php';

class Profile
{
    private $userInfo, $validUser, $return;

    public function UserInfo($userid,$age,$weight,$profileImg){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();

        // insert statement (into PROFILES tbl)
        $insert = "INSERT INTO PROFILES (user_id, age, weight, profile_image) VALUES (:userid, :age, :weight, :profileImg)";

        //prepare query
        $Profile = $connect->prepare($insert);
        //bind values
        $Profile->bindValue(":userid", $userid);
        $Profile->bindValue(":age", $age);
        $Profile->bindValue(":weight", $weight);
        $Profile->bindValue(":profileImg", $profileImg);

        // return the execution of the insert statement
        return $Profile->execute();
    }
    public function GetUserIdByToken($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $return = array();

        // query to grab user info by access_token
        $select = "SELECT user_id from USERS WHERE access_token = :token";

        //prepare query
        $userInfo = $connect->prepare($select);
        //bind value
        $userInfo->bindValue(":token", $id);
        //execute
        $userInfo->execute();
        //Allow for access of return values by object reference
        $return = $userInfo->fetch(PDO::FETCH_OBJ);
        $userInfo->closeCursor();

        return $return;
    }

    public function GetUserIdByResetToken($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $return = array();

        // query to grab user info by access_token
        $select = "SELECT user_id from USERS WHERE resetToken = :token";

        //prepare query
        $userInfo = $connect->prepare($select);
        //bind value
        $userInfo->bindValue(":token", $id);
        //execute
        $userInfo->execute();
        //Allow for access of return values by object reference
        $return = $userInfo->fetch(PDO::FETCH_OBJ);
        $userInfo->closeCursor();

        return $return;
    }

    public function ResetPassword($password,$email,$id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();

        //encrypt password using SHA1
        $newPassword = sha1($email . $password);

        $update = "UPDATE USERS SET password = :password WHERE user_id = :id";
        // prepare statement
        $updateStmt = $connect->prepare($update);
        //bind values for $token, $email
        $updateStmt->bindValue(":password", $newPassword);
        $updateStmt->bindValue(":id", $id);

        return $updateStmt->execute();
    }


    public function getUserProfileImg($id)
    {
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $results = array();

        $select = "SELECT profile_image FROM PROFILES WHERE user_id = :id";
        // prepare
        $selectImg = $connect->prepare($select);
        //bind value
        $selectImg->bindValue(":id", $id);
        //execute
        $selectImg->execute();
        $results = $selectImg->fetch(PDO::FETCH_OBJ);
        $selectImg->closeCursor();

        return $results;

    }

    public function getUserProfileIinfo($id)
    {
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();

        $select = "SELECT * FROM PROFILES WHERE user_id = :id LIMIT 1";
        // prepare
        $selectInfo = $connect->prepare($select);
        //bind value
        $selectInfo->bindValue(":id", $id);
        //execute
        $selectInfo->execute();
        $results = $selectInfo->fetch(PDO::FETCH_OBJ);
        $selectInfo->closeCursor();

        return $results;

    }

    public function updateUserProfileInformation($age,$weight,$profile,$id)
    {
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();

        $update = "UPDATE PROFILES SET age = :age, weight = :weight, profile_image = :image WHERE user_id = :id";
        //prepare
        $updateInfo = $connect->prepare($update);
        $updateInfo->bindValue(":age", $age);
        $updateInfo->bindValue(":weight", $weight);
        $updateInfo->bindValue(":image", $profile);
        $updateInfo->bindValue(":id", $id);

        return $updateInfo->execute();
    }
}
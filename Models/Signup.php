<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 */

require_once 'Database.php';

class Signup
{
    private $newUser, $validUser, $return;

    public function newUser($fname,$lname,$email,$password, $access){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();


        //encrypt password using SHA1
        $shaPassword = sha1($email . $password);
        // assign current date & time to a variable
        $join_date = date('Y-m-d H:i:s');

        // Query to insert new record of user
        $insert = "INSERT INTO USERS (first_name, last_name, email, password, join_date, access_token) VALUES (:fName, :lName, :email, :pass, :jdate, :access)";
        //prepare query
        $newUser = $connect->prepare($insert);
        //bind values
        $newUser->bindValue(":fName", $fname);
        $newUser->bindValue(":lName", $lname);
        $newUser->bindValue(":email",$email);
        $newUser->bindValue(":pass",$shaPassword);
        $newUser->bindValue(":jdate", $join_date);
        $newUser->bindValue(":access", $access);
        // return execution of statement
        return $newUser->execute();
    }


    public function isValidUser($email,$password)
    {
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $return = array();

        //encrypt password using SHA1
        $shaPassword = sha1($email . $password);

        // user_id
        // *
        try{
            $select = "SELECT * FROM USERS WHERE email = :email AND password = :password LIMIT 1";
            //prepare query
            $validUser = $connect->prepare($select);
            //bind values
            $validUser->bindValue(":email", $email);
            $validUser->bindValue(":password", $shaPassword);
            $validUser->execute();
            $return = $validUser->fetch(PDO::FETCH_OBJ);
            $validUser->closeCursor();
        } catch (PDOException $e){
            $e->getMessage();
        }

        return $return;
    }

    public function userInfo($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $return = array();

        try{
            $select = "SELECT * FROM USERS WHERE user_id = :id";
            //prepare statement
            $slctUser = $connect->prepare($select);
            //bind value for $id
            $slctUser->bindValue(":id", $id);
            $slctUser->execute();
            $return = $slctUser->fetch(PDO::FETCH_OBJ);
            $slctUser->closeCursor();
        } catch (PDOException $e){
            $e->getMessage();
        }
        return $return;
    }

    public function userInfoByEmail($email){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $return = array();

        $select = "SELECT email,first_name,last_name FROM USERS WHERE email = :email";
        //prepare statement
        $slctEmail = $connect->prepare($select);
        //bind value for $email
        $slctEmail->bindValue(":email", $email);
        $slctEmail->execute();
        $return = $slctEmail->fetch(PDO::FETCH_OBJ);
        $slctEmail->closeCursor();

        return $return;
    }
    public function grantPasswordResetToken($token,$email){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();

        $update = "UPDATE USERS SET resetToken = :token WHERE email = :email";
        // prepare statement
        $updateStmt = $connect->prepare($update);
        //bind values for $token, $email
        $updateStmt->bindValue(":token", $token);
        $updateStmt->bindValue(":email", $email);

        return $updateStmt->execute();
    }

    public function IsExistingUser($email)
    {
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDbFromAWS();
        $results = Array();

        $select = "SELECT * FROM USERS WHERE email = :email LIMIT 1";
        //prepare statement
        $slctUser = $connect->prepare($select);
        //bind value
        $slctUser->bindValue(":email", $email);
        //execute
        $slctUser->execute();
        $results = $slctUser->fetch(PDO::FETCH_OBJ);
        //close
        $slctUser->closeCursor();

        return $results;

    }

}
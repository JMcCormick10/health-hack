<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 1:21 PM
 */
class Database
{

    private $dsn = "mysql:host=localhost;dbname=joshmcc_health-hack";
    private $username = "joshmcc_d9132_cg";
    private $password = "pdhsgcmsws24";
    private $db;

    public function getDbFromAWS(){

        try {
            $this->db = new PDO($this->dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'connected';

        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->db;
    }

    public function getDbTwo(){

        try {
            $this->db = new PDO($this->dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'connected';

        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->db;
    }

    public function getDbWithPass($password) {
        try {
            $this->db = new PDO($this->dsn, $this->username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->db;
    }

    // public function getDbFromAWS() {
    //     try {
    //         $dbhost = 'health-hack.ceqjmflvpjil.us-east-1.rds.amazonaws.com';
    //         $dbport = '3307';
    //         $dbname = 'healthHack';
    //         $charset = 'utf8';
    //         $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
    //         $username = 'boss';
    //         $password = 'bossboss';
    //         $this->db = new PDO($dsn, $username, $password);
    //         $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         //$this->db->exec('SET search_path TO healthHack');
    //     } catch(PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    //     return $this->db;
    // }
}
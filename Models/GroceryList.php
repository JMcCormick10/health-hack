<?php

/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-03-12
 * Time: 12:33 PM
 */
class GroceryList
{
    //properties
    private $list_id, $list_name, $list_details, $user_id;

    //get list_id
    public function getListId()
    {
        return $this->list_id;
    }

    //set list_id
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }

    //get list_name
    public function getListName()
    {
        return $this->list_name;
    }

    //set list_name
    public function setListName($list_name)
    {
        $this->list_name = $list_name;
    }

    //get list_details
    public function getListDetails()
    {
        return $this->list_details;
    }

    //set list_details
    public function setListDetails($list_details)
    {
        $this->list_details = $list_details;
    }

    //get user_id
    public function getUserId()
    {
        return $this->user_id;
    }

    //set user_id
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
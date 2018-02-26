<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-05
 * Time: 5:13 PM
 */
class Routine
{
    private $routine_id, $user_id, $name, $monday_cardio, $monday_strength, $tuesday_cardio, $tuesday_strength, $wednesday_cardio, $wednesday_strength, $thursday_cardio, $thursday_strength, $friday_cardio, $friday_strength, $saturday_cardio, $saturday_strength, $sunday_cardio, $sunday_strength, $active;

    /**
     * @return mixed
     */
    public function getRoutineId()
    {
        return $this->routine_id;
    }

    /**
     * @param mixed $routine_id
     */
    public function setRoutineId($routine_id)
    {
        $this->routine_id = $routine_id;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMondayCardio()
    {
        return $this->monday_cardio;
    }

    /**
     * @param mixed $monday_cardio
     */
    public function setMondayCardio($monday_cardio)
    {
        $this->monday_cardio = $monday_cardio;
    }

    /**
     * @return mixed
     */
    public function getMondayStrength()
    {
        return $this->monday_strength;
    }

    /**
     * @param mixed $monday_strength
     */
    public function setMondayStrength($monday_strength)
    {
        $this->monday_strength = $monday_strength;
    }

    /**
     * @return mixed
     */
    public function getTuesdayCardio()
    {
        return $this->tuesday_cardio;
    }

    /**
     * @param mixed $tuesday_cardio
     */
    public function setTuesdayCardio($tuesday_cardio)
    {
        $this->tuesday_cardio = $tuesday_cardio;
    }

    /**
     * @return mixed
     */
    public function getTuesdayStrength()
    {
        return $this->tuesday_strength;
    }

    /**
     * @param mixed $tuesday_strength
     */
    public function setTuesdayStrength($tuesday_strength)
    {
        $this->tuesday_strength = $tuesday_strength;
    }

    /**
     * @return mixed
     */
    public function getWednesdayCardio()
    {
        return $this->wednesday_cardio;
    }

    /**
     * @param mixed $wednesday_cardio
     */
    public function setWednesdayCardio($wednesday_cardio)
    {
        $this->wednesday_cardio = $wednesday_cardio;
    }

    /**
     * @return mixed
     */
    public function getWednesdayStrength()
    {
        return $this->wednesday_strength;
    }

    /**
     * @param mixed $wednesday_strength
     */
    public function setWednesdayStrength($wednesday_strength)
    {
        $this->wednesday_strength = $wednesday_strength;
    }

    /**
     * @return mixed
     */
    public function getThursdayCardio()
    {
        return $this->thursday_cardio;
    }

    /**
     * @param mixed $thursday_cardio
     */
    public function setThursdayCardio($thursday_cardio)
    {
        $this->thursday_cardio = $thursday_cardio;
    }

    /**
     * @return mixed
     */
    public function getThursdayStrength()
    {
        return $this->thursday_strength;
    }

    /**
     * @param mixed $thursday_strength
     */
    public function setThursdayStrength($thursday_strength)
    {
        $this->thursday_strength = $thursday_strength;
    }

    /**
     * @return mixed
     */
    public function getFridayCardio()
    {
        return $this->friday_cardio;
    }

    /**
     * @param mixed $friday_cardio
     */
    public function setFridayCardio($friday_cardio)
    {
        $this->friday_cardio = $friday_cardio;
    }

    /**
     * @return mixed
     */
    public function getFridayStrength()
    {
        return $this->friday_strength;
    }

    /**
     * @param mixed $friday_strength
     */
    public function setFridayStrength($friday_strength)
    {
        $this->friday_strength = $friday_strength;
    }

    /**
     * @return mixed
     */
    public function getSaturdayCardio()
    {
        return $this->saturday_cardio;
    }

    /**
     * @param mixed $saturday_cardio
     */
    public function setSaturdayCardio($saturday_cardio)
    {
        $this->saturday_cardio = $saturday_cardio;
    }

    /**
     * @return mixed
     */
    public function getSaturdayStrength()
    {
        return $this->saturday_strength;
    }

    /**
     * @param mixed $saturday_strength
     */
    public function setSaturdayStrength($saturday_strength)
    {
        $this->saturday_strength = $saturday_strength;
    }

    /**
     * @return mixed
     */
    public function getSundayCardio()
    {
        return $this->sunday_cardio;
    }

    /**
     * @param mixed $sunday_cardio
     */
    public function setSundayCardio($sunday_cardio)
    {
        $this->sunday_cardio = $sunday_cardio;
    }

    /**
     * @return mixed
     */
    public function getSundayStrength()
    {
        return $this->sunday_strength;
    }

    /**
     * @param mixed $sunday_strength
     */
    public function setSundayStrength($sunday_strength)
    {
        $this->sunday_strength = $sunday_strength;
    }

}
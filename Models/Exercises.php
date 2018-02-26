<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 8:11 PM
 */
class Exercises
{
private $user_id, $name, $strength_workout_id;
    /**
 * @return mixed
 */
public function getUserId()
{
    return $this->user_id;
}/**
 * @param mixed $user_id
 */
public function setUserId($user_id)
{
    $this->user_id = $user_id;
}/**
 * @return mixed
 */
public function getName()
{
    return $this->name;
}/**
 * @param mixed $name
 */
public function setName($name)
{
    $this->name = $name;
}/**
 * @return mixed
 */
public function getStrengthWorkoutId()
{
    return $this->strength_workout_id;
}/**
 * @param mixed $strength_workout_id
 */
public function setStrengthWorkoutId($strength_workout_id)
{
    $this->strength_workout_id = $strength_workout_id;
}


}
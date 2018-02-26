<?php
    class GymLocation
    {
        private $id;
        //private $userId;
        private $name;
        private $address;
        private $lat;
        private $lng;

        public function __construct($gymInfo)
        {
            $this->id = $gymInfo['place-id'];
            $this->name = $gymInfo['place-name'];
            $this->address = $gymInfo['place-address'];
            $this->lat = $gymInfo['place-lat'];
            $this->lng = $gymInfo['place-lng'];
        }

        public function getGymName()
        {
            return $this->name;
        }

        public function getGymAddress()
        {
            return $this->address;
        }

        public function getGymLat()
        {
            return $this->lat;
        }

        public function getGymLng()
        {
            return $this->lng;
        }

        public function getGymId()
        {
            return $this->id;
        }
    }
?>
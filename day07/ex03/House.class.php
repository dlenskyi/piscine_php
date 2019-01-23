<?php

abstract Class House {
    public function introduce() {
        print('House '.$this->getHouseName().' of '.$this->getHouseSeat().' : "'.$this->getHouseMotto().'"'.PHP_EOL);
    }
    public abstract function getHouseName();
    public abstract function getHouseMotto();
    public abstract function getHouseSeat();
}

?>
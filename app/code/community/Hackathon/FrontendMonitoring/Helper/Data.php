<?php

class Hackathon_FrontendMonitoring_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getNow($onlyDate = false)
    {
        return now($onlyDate);
    }
}
<?php

class Hackathon_FrontendMonitoring_Model_Resource_User_Action extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('hackathon_frontendmonitoring/user_action', 'action_id');  
    }

}
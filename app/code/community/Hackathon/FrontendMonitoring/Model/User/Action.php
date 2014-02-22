<?php

/**
 * Class Hackathon_FrontendMonitoring_Model_User_Action
 *
 * @method setSessionId($sessionId)
 * @method setCustomerId($customerId)
 * @method setModel($object)
 * @method setAction($action)
 * @method setTimestamp($timestamp)
 * @method string getSessionId()
 * @method int getCustomerId()
 * @method string getModel()
 * @method string getAction()
 * @method int getTimestamp()
 */
class Hackathon_FrontendMonitoring_Model_User_Action extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        $this->_init('hackathon_frontendmonitoring/user_action');
    }
}
<?php

class Hackathon_FrontendMonitoring_Model_Observer
{
    const LOG_ACTION_WHITELIST_PREFIX = 'hackathon_frontendmonitoring/log_action/';

    public function modelSaveAfter(Varien_Event_Observer $observer)
    {
        // only log if the model is on the whitelist
        if (Mage::getStoreConfig(self::LOG_ACTION_WHITELIST_PREFIX . get_class($observer->getObject())) !== null) {

            $customerSession = Mage::getSingleton('customer/session');

            $action = Mage::getModel('hackathon_frontendmonitoring/user_action');
            $action->setSessionId($customerSession->getSessionId());
            $action->setCustomerId( $customerSession->getCustomerId());
            $action->setModel(get_class($observer->getObject()));
            $action->setAction('save_after');
            $action->setTimestamp(Mage::helper('hackathon_frontendmonitoring')->getNow());

            $action->save();
        }
    }
}

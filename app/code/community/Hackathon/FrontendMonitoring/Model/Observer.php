<?php

class Hackathon_FrontendMonitoring_Model_Observer
{
    const LOG_ACTION_WHITELIST_PREFIX = 'hackathon_frontendmonitoring/log_action/';

    public function modelSaveAfter(Varien_Event_Observer $observer)
    {
        // only log if the model is on the whitelist
        if (Mage::getStoreConfig(self::LOG_ACTION_WHITELIST_PREFIX . get_class($observer)) !== null) {
            $action = Mage::getModel('hackathon_frontendmonitoring/user_action');
            $action->setSessionId(Mage::getSingleton('core/session')->getSessionId());
            $action->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
            $action->setModel(get_class($observer));
            $action->setAction('save_after');
            $action->setTimestamp(now());

            $action->save();
        }
    }
}

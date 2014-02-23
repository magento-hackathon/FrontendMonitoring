<?php

class Hackathon_FrontendMonitoring_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Hackathon_FrontendMonitoring_Model_Observer
     */
    protected $model;

    protected function setUp()
    {
        $this->model = Mage::getModel('hackathon_frontendmonitoring/observer');
    }


    /**
     * @loadFixture
     */
    public function testModelSaveAfterWithSave()
    {
        // mock customer session for session id and
        $customerSessionMock = $this->mockSession('customer/session', array('getSessionId', 'getCustomerId'));

        $sessionId = '314159265';
        $customerId = '4711';
        $date = '2012-01-91 12:00:00';
        $classname = 'Mage_Catalog_Model_Product';


        $customerSessionMock
            ->expects($this->once())
            ->method('getSessionId')
            ->will($this->returnValue($sessionId));

        $customerSessionMock
            ->expects($this->once())
            ->method('getCustomerId')
            ->will($this->returnValue($customerId));

        $this->replaceByMock('singleton', 'customer/session', $customerSessionMock);

        // mock userAction to check whether it is saved
        $userActionMock = $this->getModelMock(
            'hackathon_frontendmonitoring/user_action',
            array(
                'save',
                'setSessionId',
                'setCustomerId',
                'setModel',
                'setAction',
                'setTimestamp',
            )
        );
        $userActionMock->expects($this->once())->method('setSessionId')->with($sessionId);
        $userActionMock->expects($this->once())->method('setCustomerId')->with($customerId);
        $userActionMock->expects($this->once())->method('setModel')->with($classname);
        $userActionMock->expects($this->once())->method('setAction')->with('save_after');
        $userActionMock->expects($this->once())->method('setTimestamp')->with($date);

        $userActionMock->expects($this->once())->method('save')->will($this->returnValue(true));


        $this->replaceByMock('model', 'hackathon_frontendmonitoring/user_action', $userActionMock);

        // mock helper to check wether the time is fetched
        $helper = $this->getHelperMock('hackathon_frontendmonitoring', array('getNow'));
        // Y-m-d H:i:s
        $helper->expects($this->once())->method('getNow')->will($this->returnValue($date));

        $this->replaceByMock('helper', 'hackathon_frontendmonitoring', $helper);

        $observer = $this->buildObserver(array('object' => new $classname()));

        $this->model->modelSaveAfter($observer);
    }

    public function testModelSaveAfterWithoutSave()
    {
        // use any existing class which is definitly not in the whitelist
        $classname = 'Mage_Core_Model_App';
        // mock userAction to check whether it is saved
        $userActionMock = $this->getModelMock(
            'hackathon_frontendmonitoring/user_action', array('save')
        );
        $userActionMock->expects($this->never())->method('save');


        $this->replaceByMock('model', 'hackathon_frontendmonitoring/user_action', $userActionMock);

        $observer = $this->buildObserver(array('object' => new $classname()));

        $this->model->modelSaveAfter($observer);
    }


    /**
     * Build correct observer structure
     *
     * @param $data array
     */
    protected function buildObserver(array $data)
    {
        $observer = new Varien_Event_Observer();
        $event = new Varien_Event();

        $event->setData($data);

        $data['event'] = $event;

        $observer->setData($data);
        return $observer;
    }
}
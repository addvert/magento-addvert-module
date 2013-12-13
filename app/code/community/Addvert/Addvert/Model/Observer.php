<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
 */
class Addvert_Addvert_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function registerOrderId(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('addvert.tracking');
        if ($block) {
            $block->setOrderId($orderIds[0]);
        }
    }
}
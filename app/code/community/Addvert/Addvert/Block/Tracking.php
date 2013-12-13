<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
 */
class Addvert_Addvert_Block_Tracking extends Mage_Core_Block_Template
{
    const SCRIPT_BASE_URL = 'http://addvert.it';

    protected $_order = null;

    public function getOrderKey()
    {
        $helper = Mage::helper('addvert');

        $ecommerceId = $helper->getEcommerceId();
        $secretKey = $helper->getSecretKey();

        $orderId = $this->_getOrder()->getIncrementId();
        $orderTotal = $this->_getOrder()->getBaseGrandTotal();

        $url = sprintf(self::SCRIPT_BASE_URL . '/api/order/prep_total?ecommerce_id=%s&secret=%s&tracking_id=%s&total=%s', $ecommerceId, $secretKey, $orderId, $orderTotal);
        $client = new Zend_Http_Client($url);

        $response = $client->request()->getBody();

        return $response;
    }

    public function getTrackingHtml()
    {
        return '<script src="' . self::SCRIPT_BASE_URL . '/api/order/send_total?key=' . $this->getOrderKey() . '"></script>';
    }

    protected function _toHtml()
    {
        return $this->getTrackingHtml();
    }

    /**
     * @return Mage_Sales_Model_Order
    */
    protected function _getOrder()
    {
        if (null === $this->_order) {
            $this->_order = Mage::getModel('sales/order')->load($this->getOrderId());
        }
        return $this->_order;
    }
}
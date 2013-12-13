<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
*/ 
class Addvert_Addvert_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ECOMMERCE_ID = 'addvert/addvert/ecommerce_id';

    const XML_PATH_SECRET_KEY = 'addvert/addvert/secret';

    public function getEcommerceId()
    {
        return Mage::getStoreConfig(self::XML_PATH_ECOMMERCE_ID);
    }

    public function getSecretKey()
    {
        return Mage::getStoreConfig(self::XML_PATH_SECRET_KEY);
    }
}
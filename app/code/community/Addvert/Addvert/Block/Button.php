<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
*/
class Addvert_Addvert_Block_Button extends Mage_Core_Block_Template
{
    const SCRIPT_BASE_URL = 'http://addvert.it';

    const XML_PATH_BUTTON_LAYOUT = 'addvert/addvert/button_layout';

    /**
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    public function getScriptUrl()
    {
        return self::SCRIPT_BASE_URL . '/api/js/addvert-btn.js';
    }

    public function getButtonLayout()
    {
        return Mage::getStoreConfig(self::XML_PATH_BUTTON_LAYOUT);
    }
}
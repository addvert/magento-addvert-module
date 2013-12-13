<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
*/
class Addvert_Addvert_Model_Source_ButtonLayout
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'standard',
                'label' => Mage::helper('addvert')->__('Standard')
            ),
            array(
                'value' => 'small',
                'label' => Mage::helper('addvert')->__('Small')
            ),
        );
    }
}
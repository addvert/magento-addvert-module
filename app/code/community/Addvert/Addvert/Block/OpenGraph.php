<?php
/**
 * @category Addvert
 * @package  Addvert_Addvert
 * @author   Gennaro Vietri <gennaro.vietri@gmail.com>
*/
class Addvert_Addvert_Block_OpenGraph extends Mage_Core_Block_Template
{
    protected $_tags = null;

    protected $_categories = null;

    const ADDVERT_TYPE = 'product';

    /**
     * @return Mage_Catalog_Model_Product
    */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Aggiunge i meta nell'head della scheda prodotto
    */
    public function getMetaHtml()
    {
        $product = $this->_getProduct();

        $metas = array(
            array('property' => 'og:url',           'content' => $product->getProductUrl()),
            array('property' => 'og:title',         'content' => $product->getName()),
            array('property' => 'og:description',   'content' => $product->getDescription()),
            array('property' => 'og:image',         'content' => Mage::helper('catalog/image')->init($product, 'image')),
            array('name' => 'addvert:type',         'content' => self::ADDVERT_TYPE),
            array('name' => 'addvert:ecommerce_id', 'content' => Mage::helper('addvert')->getEcommerceId()),
            array('name' => 'addvert:category',     'content' => implode(',', $this->_getCategories())),
            array('name' => 'addvert:price',        'content' => number_format(Mage::helper('core')->currency($product->getFinalPrice(), false, false), 2)),
        );

        foreach ($this->_getTags() as $tag) {
            $metas[] = array('name' => 'addvert:tag', 'content' => $tag);
        }

        $metaHtml = '';
        foreach ($metas as $meta) {
            $metaHtml .= '<meta';
            foreach ($meta as $attribute => $value) {
                 $metaHtml .= sprintf(' %s="%s"', $attribute, $this->escapeHtml($value));
            }
            $metaHtml .= ' />' . "\n";
        }

        return $metaHtml;
    }

    protected function _getCategories()
    {
        if (null === $this->_categories) {
            $this->_categories = array();
            foreach ($this->_getProduct()->getCategoryCollection()->addAttributeToSelect('name') as $category) {
                if ($category->getLevel() > 1) {
                    $this->_categories[] = $category->getName();
                }
            }
        }

        return $this->_categories;
    }

    protected function _getTags()
    {
        if (null === $this->_tags) {
            $this->_tags = array();
            $model = Mage::getModel('tag/tag');
            $tags = $model->getResourceCollection()
                ->addPopularity()
                ->addStatusFilter($model->getApprovedStatus())
                ->addProductFilter($this->_getProduct()->getId())
                ->setFlag('relation', true)
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->setActiveFilter()
                ->load();

            foreach ($tags as $tag) {
                $this->_tags[] = $tag->getName();
            }
        }

        return $this->_tags;
    }

    protected function _toHtml()
    {
        return $this->getMetaHtml();
    }
}
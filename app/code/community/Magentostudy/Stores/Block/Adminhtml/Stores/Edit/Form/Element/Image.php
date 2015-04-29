<?php
/**
 * Custom image form element that generates correct thumbnail image URL
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_Adminhtml_Stores_Edit_Form_Element_Image extends Varien_Data_Form_Element_Image
{
    /**
     * Get image preview url
     *
     * @return string
     */
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('magentostudy_stores/image')->getBaseUrl() . '/' . $this->getValue();
        }
        return $url;
    }
}
<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlCatalogProductEditTabInventory.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ UIqkekYmiZahUokw('cffa79206dcf4e24f826ee3f79ea8dee'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlCatalogProductEditTabInventory extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Inventory
{	
	private $_restrictedTypes = array(
		Mage_Catalog_Model_Product_Type::TYPE_BUNDLE,
		Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE,
		Mage_Catalog_Model_Product_Type::TYPE_GROUPED,
		Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
	);
	private $_currentAitProduct = null;	

	public function getAitCurrentProduct()
	{
		return $this->getProduct();		
	}

	public function getDisabled()
	{
		return $this->isPreorder() ? '' : 'disabled="disabled"';
	}

	public function getPreorderDescription()
	{
		$description = $this->getAitCurrentProduct()->getPreorderdescript();
		return strlen($description) ? $description : '';
	}

	public function isPreorder()
	{
		return (int) $this->getAitCurrentProduct()->getPreorder() == 1;
	}

	public function getDataArray()
	{
		return array(			
			'is_preorder' => $this->isPreorder(),
			'preorder_description' => $this->getPreorderDescription(),
			'disabled' => $this->getDisabled(),
		);
	}

	public function getRestrictedTypes()
	{
		return $this->_restrictedTypes;
	}

	public function canShowBlock()
	{
		return !in_array($this->getAitCurrentProduct()->getData('type_id'), $this->getRestrictedTypes());
	}

	public function getDescriptionAttributeScope()
	{
		$html = '';
		$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'preorderdescript');
		
        if ($attribute->isScopeGlobal()) {
            $html.= '[GLOBAL]';
        }
        elseif ($attribute->isScopeWebsite()) {
            $html.= '[WEBSITE]';
        }
        elseif ($attribute->isScopeStore()) {
            $html.= '[STORE VIEW]';
        }

        return $html;
	}
	
    protected function _toHtml()
    {
		$result = parent::_toHtml();

		if ($this->canShowBlock())
		{
			$preorder = $this->getLayout()
				->createBlock('core/template', '', $this->getDataArray())
				->setTemplate('aitpreorder/preorderinventory.phtml')
				->setDescriptionAttributeScope($this->getDescriptionAttributeScope())
				->toHtml();
			
			$result = str_replace(__('Backorders') . '</label>', __('Backorders') . '\\' . __('Pre-Orders')  . '</label>', $result);
			$result = str_replace('</table>', $preorder, $result);
		}

		return $result;
    }     
    
} } 
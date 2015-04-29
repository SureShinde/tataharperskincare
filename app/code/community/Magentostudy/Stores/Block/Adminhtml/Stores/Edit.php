<?php
/**
 * Stores List admin edit form container
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_Adminhtml_Stores_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit form container
     *
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'magentostudy_stores';
        $this->_controller = 'adminhtml_stores';

        parent::__construct();

        if (Mage::helper('magentostudy_stores/admin')->isActionAllowed('save')) {
            $this->_updateButton('save', 'label', Mage::helper('magentostudy_stores')->__('Save Stores Item'));
            $this->_addButton('saveandcontinue', array(
                'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }

        if (Mage::helper('magentostudy_stores/admin')->isActionAllowed('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('magentostudy_stores')->__('Delete Stores Item'));
        } else {
            $this->_removeButton('delete');
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        $model = Mage::helper('magentostudy_stores')->getStoresItemInstance();
        if ($model->getId()) {
            return Mage::helper('magentostudy_stores')->__("Edit Stores Item '%s'",
                 $this->escapeHtml($model->getTitle()));
        } else {
            return Mage::helper('magentostudy_stores')->__('New Stores Item');
        }
    }
}
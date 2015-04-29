<?php
/**
 * Stores List admin grid container
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_Adminhtml_Stores extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'magentostudy_stores';
        $this->_controller = 'adminhtml_stores';
        $this->_headerText = Mage::helper('magentostudy_stores')->__('Manage Stores');

        parent::__construct();

        if (Mage::helper('magentostudy_stores/admin')->isActionAllowed('save')) {
            $this->_updateButton('add', 'label', Mage::helper('magentostudy_stores')->__('Add New Stores'));
        } else {
            $this->_removeButton('add');
        }
        $this->addButton(
            'stores_flush_images_cache',
            array(
                'label'      => Mage::helper('magentostudy_stores')->__('Flush Images Cache'),
                'onclick'    => 'setLocation(\'' . $this->getUrl('*/*/flush') . '\')',
            )
        );

    }
}
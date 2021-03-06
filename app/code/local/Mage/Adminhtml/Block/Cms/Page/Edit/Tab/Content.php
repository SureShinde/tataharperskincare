<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_Cms_Page_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        /** @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('cms_page');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('content_fieldset', array('legend'=>Mage::helper('cms')->__('Content'),'class'=>'fieldset-wide'));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId())
        );
        /*
        $fieldset->addField('content_heading', 'text', array(
            'name'      => 'content_heading',
            'label'     => Mage::helper('cms')->__('Content Heading'),
            'title'     => Mage::helper('cms')->__('Content Heading'),
            'disabled'  => $isElementDisabled
        ));
        */
        $contentField = $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'    => Mage::helper('cms')->__('Main content/Tab 1'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => true,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

        // custom added by AX 4.4.13
        // http://www.netismine.com/magento/add-custom-field-to-cms-page
        $customThscFieldset = $form->addFieldset('custom_thsc_fieldset', array( // I'm creating banner fieldset here - you can rename it however you see fit
            'legend' => Mage::helper('cms')->__('Custom THSC Fieldset'), // Change the name here
            'class'  => 'fieldset-wide',
            'disabled'  => $isElementDisabled
        ));
        
        // custom added by AX 4.4.13
        // http://www.netismine.com/magento/add-custom-field-to-cms-page
        $customThscFieldset->addField('custom_image_url', 'editor', array( 
            'name'     => 'custom_image_url',
            'label'    => Mage::helper('cms')->__('Custom Image URL'),
            'style'    => 'height:36em;',
            'required' => false,
            'disabled' => $isElementDisabled,
        ));

        $customThscFieldset->addField('tab_one_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_one_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 1 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $customThscFieldset->addField('tab_two_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_two_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 2 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $customThscFieldset->addField('tab_three_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_three_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 3 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $customThscFieldset->addField('tab_four_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_four_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 4 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $customThscFieldset->addField('tab_five_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_five_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 5 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $customThscFieldset->addField('tab_six_name', 'text', array( // instead of $bannerFieldset put in a name of the fieldset where you want the field to appear - whether it's custom name or one of the defaults, like $layoutFieldset. Instead of banners_no put in a codename of the field you're adding. Has to be lower caps, no spaces. See other fields for example. Remember what you put in, we'll need it later
            'name'     => 'tab_six_name', // put in the same value here as you did in the line above
            'label'    => Mage::helper('cms')->__('Tab 6 Name'), // this is the name of the field
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $customThscFieldset->addField('tab_two_content', 'editor', array(
            'name'      => 'tab_two_content',
            'label'    => Mage::helper('cms')->__('Sidebar/Tab 2 Content'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => false,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

       $customThscFieldset->addField('tab_three_content', 'editor', array(
            'name'      => 'tab_three_content',
            'label'    => Mage::helper('cms')->__('Tab 3 Content'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => false,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

        $customThscFieldset->addField('tab_four_content', 'editor', array(
            'name'      => 'tab_four_content',
            'label'    => Mage::helper('cms')->__('Tab 4 Content'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => false,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

        $customThscFieldset->addField('tab_five_content', 'editor', array(
            'name'      => 'tab_five_content',
            'label'    => Mage::helper('cms')->__('Tab 5 Content'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => false,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

        $customThscFieldset->addField('tab_six_content', 'editor', array(
            'name'      => 'tab_six_content',
            'label'    => Mage::helper('cms')->__('Tab 6 Content'), // this is the name of the field
            'style'     => 'height:36em;',
            'required'  => false,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));
        
        // Setting custom renderer for content field to remove label column
        /*$renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
                    ->setTemplate('cms/page/edit/form/renderer/content.phtml');
        $contentField->setRenderer($renderer);
        */
        $form->setValues($model->getData());

        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_content_prepare_form', array('form' => $form));

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('cms')->__('Content');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('cms')->__('Content');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }
}

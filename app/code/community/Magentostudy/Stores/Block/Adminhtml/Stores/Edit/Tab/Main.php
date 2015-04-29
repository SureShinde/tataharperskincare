<?php
/**
 * Stores List admin edit form main tab
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_Adminhtml_Stores_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::helper('magentostudy_stores')->getStoresItemInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('magentostudy_stores/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('stores_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('magentostudy_stores')->__('Stores Item Info')
        ));

        if ($model->getId()) {
            $fieldset->addField('stores_id', 'hidden', array(
                'name' => 'stores_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'     => 'title',
            'label'    => Mage::helper('magentostudy_stores')->__('Stores Title'),
            'title'    => Mage::helper('magentostudy_stores')->__('Stores Title'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        /* NEW */

        $fieldset->addField('address', 'text', array(
            'name'     => 'address',
            'label'    => Mage::helper('magentostudy_stores')->__('Address'),
            'title'    => Mage::helper('magentostudy_stores')->__('Address'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('city', 'text', array(
            'name'     => 'city',
            'label'    => Mage::helper('magentostudy_stores')->__('City'),
            'title'    => Mage::helper('magentostudy_stores')->__('City'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('state', 'text', array(
            'name'     => 'state',
            'label'    => Mage::helper('magentostudy_stores')->__('State'),
            'title'    => Mage::helper('magentostudy_stores')->__('State'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('zip', 'text', array(
            'name'     => 'zip',
            'label'    => Mage::helper('magentostudy_stores')->__('Zip'),
            'title'    => Mage::helper('magentostudy_stores')->__('Zip'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('phone', 'text', array(
            'name'     => 'phone',
            'label'    => Mage::helper('magentostudy_stores')->__('Phone'),
            'title'    => Mage::helper('magentostudy_stores')->__('Phone'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('website', 'text', array(
            'name'     => 'website',
            'label'    => Mage::helper('magentostudy_stores')->__('Website'),
            'title'    => Mage::helper('magentostudy_stores')->__('Website'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('lat', 'text', array(
            'name'     => 'lat',
            'label'    => Mage::helper('magentostudy_stores')->__('Latitude'),
            'title'    => Mage::helper('magentostudy_stores')->__('Longitude'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('lng', 'text', array(
            'name'     => 'lng',
            'label'    => Mage::helper('magentostudy_stores')->__('Longitude'),
            'title'    => Mage::helper('magentostudy_stores')->__('Longitude'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        /* END NEW */

        $fieldset->addField('author', 'text', array(
            'name'     => 'author',
            'label'    => Mage::helper('magentostudy_stores')->__('Author'),
            'title'    => Mage::helper('magentostudy_stores')->__('Author'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('published_at', 'date', array(
            'name'     => 'published_at',
            'format'   => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'    => $this->getSkinUrl('images/grid-cal.gif'),
            'label'    => Mage::helper('magentostudy_stores')->__('Publishing Date'),
            'title'    => Mage::helper('magentostudy_stores')->__('Publishing Date'),
            'required' => false
        ));

        Mage::dispatchEvent('adminhtml_stores_edit_tab_main_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('magentostudy_stores')->__('Stores Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('magentostudy_stores')->__('Stores Info');
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
}

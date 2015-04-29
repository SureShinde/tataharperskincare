<?php

/**
 * Product:       Xtento_GridActions (1.8.1)
 * ID:            89pdzbyLZI/Wh0ymDZ6dnEySdA4PIpMFN4ILDVKCqdw=
 * Packaged:      2015-04-10T16:37:54+00:00
 * Last Modified: 2013-06-30T18:35:14+02:00
 * File:          app/code/local/Xtento/GridActions/Block/Adminhtml/Sales/Order/Grid/Widget/Massaction.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_GridActions_Block_Adminhtml_Sales_Order_Grid_Widget_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Massaction
{
    public function isAvailable()
    {
        /* Compatibility with Amasty extensions */
        Mage::dispatchEvent('am_grid_massaction_actions', array(
            'block' => $this,
            'page' => $this->getRequest()->getControllerName(),
        ));
        return parent::isAvailable();
    }

    public function getJavaScript()
    {
        /* Compatibility with Amasty extensions */
        $result = new Varien_Object(array(
            'js' => parent::getJavaScript(),
            'page' => $this->getRequest()->getControllerName(),
        ));
        Mage::dispatchEvent('am_grid_massaction_js', array('result' => $result));

        if (in_array($this->getRequest()->getControllerName(), Mage::getSingleton('gridactions/observer')->getControllerNames())) {
            if (Mage::helper('gridactions/data')->getModuleEnabled() && Mage::getStoreConfigFlag('gridactions/general/add_trackingnumber_from_grid')) {
                return str_replace('varienGridMassaction', 'extendedGridMassaction', $result->getJs());
            }
        }
        return $result->getJs();
    }
}

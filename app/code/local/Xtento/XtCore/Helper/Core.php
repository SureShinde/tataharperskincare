<?php

/**
 * Product:       Xtento_XtCore (1.1.7)
 * ID:            89pdzbyLZI/Wh0ymDZ6dnEySdA4PIpMFN4ILDVKCqdw=
 * Packaged:      2015-04-10T16:37:54+00:00
 * Last Modified: 2013-04-29T15:53:27+02:00
 * File:          app/code/local/Xtento/XtCore/Helper/Core.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_XtCore_Helper_Core extends Mage_Core_Helper_Abstract
{
    /* Fix for compatibility with Magento version <1.4 */
    public function escapeHtml($data, $allowedTags = null)
    {
        if (Mage::helper('xtcore/utils')->mageVersionCompare(Mage::getVersion(), '1.4.1.0', '>=')) {
            return Mage::helper('core')->escapeHtml($data, $allowedTags);
        } else {
            return Mage::helper('core')->htmlEscape($data, $allowedTags);
        }
    }
}
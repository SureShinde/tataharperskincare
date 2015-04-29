<?php
/**
 * Authorize.Net CIM - Customer card manager - Card add/edit form
 *
 * Paradox Labs, Inc.
 * http://www.paradoxlabs.com
 * 717-431-3330
 *
 * Having a problem with the plugin?
 * Not sure what something means?
 * Need custom development?
 * Give us a call!
 *
 * @category    ParadoxLabs
 * @package     ParadoxLabs_AuthorizeNetCim
 * @author      Ryan Hoerr <ryan@paradoxlabs.com>
 */

class ParadoxLabs_AuthorizeNetCim_Block_Adminhtml_Customer_Edit extends ParadoxLabs_AuthorizeNetCim_Block_Adminhtml_Customer_View
{
	public function _construct() {
		parent::_construct();
		
		$this->setTemplate('authorizenetcim/edit.phtml');
	}
}

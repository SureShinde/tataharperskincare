<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 /***************************************
 *         MAGENTO EDITION USAGE NOTICE *
 *****************************************/
 /* This package designed for Magento COMMUNITY edition
 * BelVG does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * BelVG does not provide extension support in case of
 * incorrect edition usage.
 /***************************************
 *         DISCLAIMER                   *
 *****************************************/
 /* Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *****************************************************
 * @category   Belvg
 * @package    Belvg_Android
 * @copyright  Copyright (c) 2010 - 2011 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
?>
<form id="co-shipping-form" action="">
<?php if ($this->customerHasAddresses()): ?>
 <p><?php echo $this->__('Select a shipping address from your address book or enter a new address.') ?></p>
 <p class="select300inner"><?php echo $this->getAddressesHtmlSelect('shipping') ?></p>
<?php endif ?>

<fieldset class="group-select" id="shipping-new-address-form" <?php if ($this->customerHasAddresses()): ?>style="display:none"<?php endif ?>>
	<input type="hidden" name="shipping[address_id]" value="<?php echo $this->getAddress()->getId() ?>" id="shipping:address_id">
	<ul class="form-list">
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:firstname"><?php echo $this->__('First Name') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="text" id="shipping:firstname" name="shipping[firstname]" value="<?php echo $this->htmlEscape($this->getAddress()->getFirstname()) ?>" title="<?php echo $this->__('First Name') ?>" class="required-entry input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:lastname"><?php echo $this->__('Last Name') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="text" id="shipping:lastname" name="shipping[lastname]" value="<?php echo $this->htmlEscape($this->getAddress()->getLastname()) ?>" title="<?php echo $this->__('Last Name') ?>" class="required-entry input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:company"><?php echo $this->__('Company') ?></label>
			</div><div class="col-2">
				<input type="text" id="shipping:company" name="shipping[company]" value="<?php echo $this->htmlEscape($this->getAddress()->getCompany()) ?>" title="<?php echo $this->__('Company') ?>" class="input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<?php if(false): ?>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:email"><?php echo $this->__('Email Address') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="email" name="shipping[email]" id="shipping:email" value="<?php echo $this->htmlEscape($this->getAddress()->getEmail()) ?>" title="<?php echo $this->__('Email Address') ?>" class="validate-email required-entry input-text">
			</div></div>
		</li>
		<?php endif ?>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:street1"><?php echo $this->__('Address') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="text" title="<?php echo $this->__('Street Address') ?>" name="shipping[street][1]" id="shipping:street1" value="<?php echo $this->htmlEscape($this->getAddress()->getStreet(1)) ?>" class="required-entry input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				&nbsp;
			</div><div class="col-2">
				<input type="text" title="<?php echo $this->__('Street Address 2') ?>" name="shipping[street][2]" id="shipping:street2" value="<?php echo $this->htmlEscape($this->getAddress()->getStreet(2)) ?>" class="input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:city"><?php echo $this->__('City') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="text" title="<?php echo $this->__('City') ?>" name="shipping[city]" value="<?php echo $this->htmlEscape($this->getAddress()->getCity()) ?>" class="required-entry input-text" id="shipping:city" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:region"><?php echo $this->__('State/Province') ?> <span class="required">*</span></label>
			</div><div class="col-2 select190inner">
				<select id="shipping:region_id" name="shipping[region_id]" title="<?php echo $this->__('State/Province') ?>" class="validate-select" style="display:none">
					<option value=""><?php echo $this->__('Please select region, state or province') ?></option>
				</select>
				<script>
					$('shipping:region_id').setAttribute('defaultValue',"<?php echo $this->getAddress()->getRegionId() ?>");
				</script>
				<input type="text" id="shipping:region" name="shipping[region]" value="<?php echo $this->htmlEscape($this->getAddress()->getRegion()) ?>" title="<?php echo $this->__('State/Province') ?>" class="input-text" style="display:none">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:postcode"><?php echo $this->__('Zip/Postal Code') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="text" title="<?php echo $this->__('Zip/Postal Code') ?>" name="shipping[postcode]" id="shipping:postcode" value="<?php echo $this->htmlEscape($this->getAddress()->getPostcode()) ?>" class="validate-zip-international required-entry input-text" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:country_id"><?php echo $this->__('Country') ?> <span class="required">*</span></label>
			</div><div class="col-2 select190inner">
				<?php echo $this->getCountryHtmlSelect('shipping') ?>
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:telephone"><?php echo $this->__('Telephone') ?> <span class="required">*</span></label>
			</div><div class="col-2">
				<input type="tel" name="shipping[telephone]" value="<?php echo $this->htmlEscape($this->getAddress()->getTelephone()) ?>" title="<?php echo $this->__('Telephone') ?>" class="required-entry input-text" id="shipping:telephone" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<label for="shipping:fax"><?php echo $this->__('Fax') ?></label>
			</div><div class="col-2">
				<input type="text" name="shipping[fax]" value="<?php echo $this->htmlEscape($this->getAddress()->getFax()) ?>" title="<?php echo $this->__('Fax') ?>" class="input-text" id="shipping:fax" onchange="shipping.setSameAsBilling(false);">
			</div></div>
		</li>
		<?php if ($this->isCustomerLoggedIn() && $this->customerHasAddresses()):?>
		<li>
			<div class="col2-alt-set"><div class="col-1">
				<input type="checkbox" name="shipping[save_in_address_book]" value="1" title="<?php echo $this->__('Save in address book') ?>" id="shipping:save_in_address_book" onchange="shipping.setSameAsBilling(false);"<?php if ($this->getAddress()->getSaveInAddressBook()):?> checked<?php endif;?>>
			</div><div class="col-2">
				<label for="shipping:save_in_address_book"><?php echo $this->__('Save in address book') ?></label>
			</div></div>
		</li>
		<?php else:?>
			<input type="hidden" name="shipping[save_in_address_book]" value="1">
		<?php endif;?>
	</ul>
</fieldset>
<p><input type="checkbox" name="shipping[same_as_billing]" id="shipping:same_as_billing" value="1" <?php if($this->getAddress()->getSameAsBilling()): ?>checked<?php endif ?> onclick="shipping.setSameAsBilling(this.checked)"> &nbsp;<label for="shipping:same_as_billing"><?php echo $this->__('Use Billing Address') ?></label></p>
</form>

<div class="col2-alt-set button-set">
	<div class="col-1">
		<p class="required"><?php echo $this->__('* Required Fields') ?></p>
	</div>
	<div class="col-2">&nbsp;</div>
</div>
<div class="col2-alt-set button-set" style="padding-top:0;">
	<div class="col-1" style="padding-top:8px;">
		<a href="#" class="left" onclick="checkout.back(); return false;"><?php echo $this->__('&laquo Back') ?></a>
	</div>
	<div class="col-2">
		<div class="form-buttons">
			<span id="shipping-buttons-container">
				<span id="shipping-please-wait" style="display:none;" class="opc-please-wait">
					<img src="<?php echo $this->getSkinUrl('images/opc-ajax-loader.gif') ?>" class="v-middle" alt=""> &nbsp; <?php echo $this->__('Loading next step...') ?> &nbsp;
				</span><br>
				<button type="button" class="form-button" onclick="shipping.save();"><span><?php echo $this->__('Continue') ?></span></button>
			</span>
		</div>
	</div>
</div>
<script>
<!--
	var shipping = new Shipping('co-shipping-form', '<?php echo $this->getUrl('checkout/onepage/getAddress') ?>address/', '<?php echo $this->getUrl('checkout/onepage/saveShipping') ?>',
		'<?php echo $this->getUrl('checkout/onepage/shippingMethod') ?>');
	var shippingForm = new VarienForm('co-shipping-form');
	shippingForm.extraChildParams = ' onchange="shipping.setSameAsBilling(false);"';
	//shippingForm.setElementsRelation('shipping:country_id', 'shipping:region', '<?php echo $this->getUrl('directory/json/childRegion') ?>', '<?php echo $this->__('Select State/Province...') ?>');
	$('shipping-address-select') && shipping.newAddress(!$('shipping-address-select').value);

	var shippingRegionUpdater = new RegionUpdater('shipping:country_id', 'shipping:region', 'shipping:region_id', countryRegions, undefined, 'shipping:postcode');
//-->
</script>
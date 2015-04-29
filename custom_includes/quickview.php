<?php ?>
<?php 
require_once("../app/Mage.php");

Mage::app();
if ($_POST['sku'])
    $sku = $_POST['sku'];
else
    $sku = 'TSE9991';
    $product_id = Mage::getModel("catalog/product")->getIdBySku($sku);
    $_product = Mage::getModel('catalog/product')->load($product_id);

?>

<div class='quickview'>
    <?php echo $product_id; ?>
    <div class="imageleftpop">
        <div class="imgcontain">
            <a href="<?php echo $_product->getProductUrl() ?>">
                <img src="<?php echo $_product->getMediaConfig()->getMediaUrl($_product->getData('image')) ?>" class='quickview-prod-img' />
            </a>
        </div>
    </div>

    <div class="rightcontentpop">
        <h2 class="prodtitle">
            <a href="<?php echo $_product->getProductUrl() ?>"><?php echo $_product->getName() ?>
            </a>
        </h2>

        <?php $product = Mage::getModel('catalog/product')->load('product_id');
        $attributeNames = array_keys($product->getData()); ?>

        <?php if ($_product->getShortDescription()) {
            echo "<span class='productshort'>" . $_product->getShortDescription() . "<br /></span>";
            } ?>

        <div class="desc std">
            <p><?php $_product->getShortDescription() ?></p>
            <a href="<?php echo $_product->getProductUrl() ?>">Learn more</a>
        </div>

        <!-- PRICE -->
        <?php $_formattedActualPrice = Mage::helper('core')->currency($_product->getPrice(),true,false); ?>

        <span class="price"><?php echo $_formattedActualPrice; ?></span>
    
        <!-- QUANTITY -->
        <div class="quantity">
            <label for="qty">Quantity: </label>
            <input type="text" title="qty" class="qty" name="qty" value="1"></input>
        </div>

        <!-- ADD TO CART -->
        <?php if($_product->isSaleable()): ?>
           <!--  <button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation('<?php echo Mage::helper('checkout/cart')->getAddUrl($_product) ?>   ')">Add to Cart</button> -->
           <button type="button" data-id="<?php echo $product_id; ?>" title="Add to Cart" class="button btn-cart add-to-cart">Add to Cart</button> 

        <?php endif; ?>

        <!-- ADD TO WISHLIST -->
        <button type="button" title="Add to Wishlist" class="button btn-cart btn-wishlist" onclick="setLocation('<?php echo Mage::helper('wishlist')->getAddUrl($_product) ?>   ')">Add to Wishlist</button>


</div>

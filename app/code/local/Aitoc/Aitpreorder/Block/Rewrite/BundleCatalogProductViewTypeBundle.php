<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/BundleCatalogProductViewTypeBundle.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ IcprBrSywDZqIirh('dbf906e1d42307a5cbdc65ce93f82d7b'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/
class Aitoc_Aitpreorder_Block_Rewrite_BundleCatalogProductViewTypeBundle extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle                                          
{
    public function getJsonConfig()
    {
      
        $ins="\n
        bundle.reloadPrice = function() {
        var calculatedPrice = 0;
        var dispositionPrice = 0;
        var haveselectedpreorder=0;var descript='';
        for (var option in this.config.selected) {
            if (this.config.options[option]) {
                for (var i=0; i < this.config.selected[option].length; i++) {
                    var prices = this.selectionPrice(option, this.config.selected[option][i]);
                    calculatedPrice += Number(prices[0]);
                    
                    var selId=this.config.selected[option][i];
                    
                    if(this.config.options[option].selections[selId]['ispreorder']==1)
                    {
                        haveselectedpreorder=1;
                        descript=this.config.options[option].selections[selId]['preorderdescript'];
                    }                    
                    dispositionPrice += Number(prices[1]);
                }
            }
        }

      
        var masAvail=$$('.availability');
        var elmas=masAvail[0];
        var childEl = elmas.childElements();
        var spanEl = childEl[0]; 
        if(haveselectedpreorder==1)
        {
       
            if(spanEl.innerHTML!=descript)
            {
               
                bundle.st=spanEl.innerHTML;
            }
            spanEl.update(descript);
        }
        else
        {
            if(bundle.st)
            {
                spanEl.update(bundle.st);
            }            
        }
        
        if (this.config.specialPrice) {
            var newPrice = (calculatedPrice*this.config.specialPrice)/100;
            calculatedPrice = Math.min(newPrice, calculatedPrice);
        }

        optionsPrice.changePrice('bundle', calculatedPrice);
        optionsPrice.changePrice('nontaxable', dispositionPrice);
        optionsPrice.reload();
        return calculatedPrice;
    }";
    
    
    
    
      
      
        return parent::getJsonConfig().');'.$ins.'//';
        
    }
  
} } 
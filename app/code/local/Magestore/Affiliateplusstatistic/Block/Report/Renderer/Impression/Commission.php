<?php
class Magestore_Affiliateplusstatistic_Block_Report_Renderer_Impression_Commission extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row){
		$totals = 0;
        $storeId = Mage::app()->getRequest()->getParam('store',0);
         if($row->getBannerId()){
            $accountId = $row->getAccountId();
            $bannerId = $row->getBannerId();
            $type = $row->getType();
            
            $createdDate = $row->getVisitAt();
            $collection = Mage::getModel('affiliateplus/transaction')
                            ->getCollection()
                            ->addFieldToFilter('account_email',$row->getAccountEmail())
                            ->addFieldToFilter('banner_id',$bannerId)
                            ->addFieldToFilter('type',1)
                            ->addFieldToFilter('date(created_time)',array('eq'=>$createdDate))
                            ;
            if (Mage::helper('affiliateplus/config')->getSharingConfig('balance') == 'store')
                if($storeId)
                    $collection->addFieldToFilter('store_id', $storeId);
            if ($fromDate = Mage::app()->getRequest()->getParam('date_from'))
                $collection->addFieldToFilter('DATE_FORMAT(created_time, "%Y-%m-%d")', array('from' => $this->formatData($fromDate)));
            if ($toDate = Mage::app()->getRequest()->getParam('date_to'))
                $collection->addFieldToFilter('DATE_FORMAT(created_time, "%Y-%m-%d")', array('to' => $this->formatData($toDate)));
            $collection->getSelect()->group('type')->columns(array('total_commission'=>'SUM(commission)'));
            if($collection->getSize())
                $totals = $collection->getFirstItem()->getTotalCommission();
         }else{
            $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
            $requestData = $this->_filterDates($requestData, array('from', 'to'));
            $requestData['store_ids'] = Mage::app()->getRequest()->getParam('store_ids');
            $params = new Varien_Object();

            foreach ($requestData as $key => $value)
                if (!empty($value))
                    $params->setData($key, $value);
            //$account = Mage::getSingleton('affiliateplus/session')->getAccount();
            $collection = Mage::getModel('affiliateplus/transaction')->getCollection();
            if (Mage::helper('affiliateplus/config')->getSharingConfig('balance') == 'store')
                if($storeId)
                    $collection->addFieldToFilter('store_id', $storeId);
            $collection ->addFieldToFilter('type', 1)
                        ->setOrder('created_time', 'ASC')
                    ;

            if ($fromDate = $params->getData('from'))
                $collection->addFieldToFilter('DATE_FORMAT(created_time, "%Y-%m-%d")', array('from' => $this->formatData($fromDate)));
            if ($toDate = $params->getData('to'))
                $collection->addFieldToFilter('DATE_FORMAT(created_time, "%Y-%m-%d")', array('to' => $this->formatData($toDate)));
            $collection->getSelect()->group('type')->columns(array('total_commission'=>'SUM(commission)'));
            if($collection->getSize())
                $totals = $collection->getFirstItem()->getTotalCommission();
            
         }
            
        return Mage::helper('core')->currency($totals);
	}
    
    protected function _filterDates($array, $dateFields)
    {
        if (empty($dateFields)) {
            return $array;
        }
        $filterInput = new Zend_Filter_LocalizedToNormalized(array(
            'date_format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));
        $filterInternal = new Zend_Filter_NormalizedToLocalized(array(
            'date_format' => Varien_Date::DATE_INTERNAL_FORMAT
        ));

        foreach ($dateFields as $dateField) {
            if (array_key_exists($dateField, $array) && !empty($dateField)) {
            $array[$dateField] = $filterInput->filter($array[$dateField]);
            $array[$dateField] = $filterInternal->filter($array[$dateField]);
            }
        }
        return $array;
    }
    
    public function formatData($date) {
        $intPos = strrpos($date, "-");
        $str1 = substr($date, 0, $intPos);
        $str2 = substr($date, $intPos + 1);
        if (strlen($str2) == 4) {
            $date = $str2 . "-" . $str1;
        }
        return $date;
    }
}
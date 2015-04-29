<?php

class Magestore_Affiliateplusstatistic_Block_Frontend_Report_Clicks_Grid extends Magestore_Affiliateplusstatistic_Block_Report_Grid_Abstract
{
    public function __construct() {
        parent::__construct();
        $this->_resourceCollectionName = 'affiliateplusstatistic/report_clicks_collection';
        
    }
    
    protected function _getGroupByColumn()
    {
        if(!$this->hasData('group_by_column')){
            $group_by = $this->getRequest()->getParam('group_by');
            $this->setData('group_by_column',$group_by);
        }
        return $this->getData('group_by_column');
    }
    
    protected function _prepareColumns()
    {
        $form = $this->getLayout()->createBlock('affiliateplusstatistic/frontend_report_clicks_form');
        $form->setFilterData($this->getFilterData());
        $this->setChild('grid.filter.form',$form);
        if ($this->_getGroupByColumn() == '2') {
            $this->addColumn('account_email',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Account Email'),
                'index'		=> 'account_email',
                'type'		=> 'string',
                'sortable'	=> false,
                'totals_label'	=> Mage::helper('adminhtml')->__('Total'),
                'html_decorators'	=> array('nobr'),
            ));
            
            $this->addColumn('visit_at',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Period'),
                'index'		=> 'visit_at',
                'width'		=> 100,
                'sortable'	=> false,
                'period_type'	=> $this->getPeriodType(),
                'renderer'	=> 'adminhtml/report_sales_grid_column_renderer_date',
            ));
            
            $this->addColumn('banner_id', array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Banner'),
                'index'		=> 'banner_id',
                'renderer'	=> 'affiliateplusstatistic/report_renderer_banner',
                'totals_label'	=> '',
                'sortable'	=> false
            ));
        } elseif ($this->_getGroupByColumn() == '3') {
            $this->addColumn('banner_id', array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Banner'),
                'index'		=> 'banner_id',
                'renderer'	=> 'affiliateplusstatistic/report_renderer_banner',
                'sortable'	=> false,
                'totals_label'	=> Mage::helper('adminhtml')->__('Total'),
                'html_decorators'	=> array('nobr'),
            ));
            
            $this->addColumn('visit_at',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Period'),
                'index'		=> 'visit_at',
                'width'		=> 100,
                'sortable'	=> false,
                'period_type'	=> $this->getPeriodType(),
                'renderer'	=> 'adminhtml/report_sales_grid_column_renderer_date',
            ));

            $this->addColumn('account_email',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Account Email'),
                'index'		=> 'account_email',
                'type'		=> 'string',
                'sortable'	=> false
            ));
        } else {
            $this->addColumn('visit_at',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Period'),
                'index'		=> 'visit_at',
                'width'		=> 100,
                'sortable'	=> false,
                'period_type'	=> $this->getPeriodType(),
                'renderer'	=> 'adminhtml/report_sales_grid_column_renderer_date',
                'totals_label'	=> Mage::helper('adminhtml')->__('Total'),
                'html_decorators'	=> array('nobr'),
            ));

            $this->addColumn('account_email',array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Account Email'),
                'index'		=> 'account_email',
                'type'		=> 'string',
                'sortable'	=> false
            ));
            
            $this->addColumn('banner_id', array(
                'header'	=> Mage::helper('affiliateplusstatistic')->__('Banner'),
                'index'		=> 'banner_id',
                'renderer'	=> 'affiliateplusstatistic/report_renderer_banner',
                'totals_label'	=> '',
                'sortable'	=> false
            ));
        }
		
		$this->addColumn('referer',array(
			'header'	=> Mage::helper('affiliateplusstatistic')->__('Traffic Source'),
			'index'		=> 'referer',
			'renderer'	=> 'affiliateplusstatistic/report_renderer_referer',
			'totals_label'	=> '',
			'sortable'	=> false
		));
		
		$this->addColumn('url_path',array(
			'header'	=> Mage::helper('affiliateplusstatistic')->__('Url Path'),
			'index'		=> 'url_path',
			'renderer'	=> 'affiliateplusstatistic/report_renderer_path',
			'totals_label'	=> '',
			'sortable'	=> false
		));
		
		$this->addColumn('totals',array(
			'header'	=> Mage::helper('affiliateplusstatistic')->__('Clicks'),
			'index'		=> 'totals',
			'type'		=> 'number',
			'total'		=> 'sum',
			'sortable'	=> false
		));
		
		$this->addColumn('is_unique',array(
			'header'	=> Mage::helper('affiliateplusstatistic')->__('Unique Clicks'),
			// 'index_prefix'	=> 'DISTINCT ',
			'index'		=> 'is_unique',
			'type'		=> 'number',
			'total'		=> 'sum',
			// 'renderer'	=> 'affiliateplusstatistic/report_renderer_uniques',
			'sortable'	=> false
		));
		//Zend_Debug::dump($this->getCollection()->getAllIds());
		$this->addExportType('*/*/exportClicksCsv', Mage::helper('adminhtml')->__('CSV'));
		$this->addExportType('*/*/exportClicksExcel', Mage::helper('adminhtml')->__('Excel XML'));
		
		return parent::_prepareColumns();
    }
}
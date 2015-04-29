<?php ?>
 <?php
 /**
 * Stores frontend controller
 *
 * @author Magento
 */
class Magentostudy_Stores_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Pre dispatch action that allows to redirect to no route page in case of disabled extension through admin panel
     */
    public function preDispatch()
    {
        parent::preDispatch();
        
        if (!Mage::helper('magentostudy_stores')->isEnabled()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }        
    }
    
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();

        $listBlock = $this->getLayout()->getBlock('stores.list');

        if ($listBlock) {
            $currentPage = abs(intval($this->getRequest()->getParam('p')));
            if ($currentPage < 1) {
                $currentPage = 1;
            }
            $listBlock->setCurrentPage($currentPage);
        }

        $this->renderLayout();
    }

    /**
     * Stores view action
     */
    public function viewAction()
    {
        $storesId = $this->getRequest()->getParam('id');
        if (!$storesId) {
            return $this->_forward('noRoute');
        }

        /** @var $model Magentostudy_Stores_Model_Stores */
        $model = Mage::getModel('magentostudy_stores/stores');
        $model->load($storesId);

        if (!$model->getId()) {
            return $this->_forward('noRoute');
        }

        Mage::register('stores_item', $model);
        
        Mage::dispatchEvent('before_stores_item_display', array('stores_item' => $model));

        $this->loadLayout();
        $itemBlock = $this->getLayout()->getBlock('stores.item');
        if ($itemBlock) {
            $listBlock = $this->getLayout()->getBlock('stores.list');
            if ($listBlock) {
                $page = (int)$listBlock->getCurrentPage() ? (int)$listBlock->getCurrentPage() : 1;
            } else {
                $page = 1;
            }
            $itemBlock->setPage($page);
        }
        $this->renderLayout();
    }
}

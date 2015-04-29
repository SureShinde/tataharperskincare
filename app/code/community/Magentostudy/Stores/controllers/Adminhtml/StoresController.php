<?php
/**
 * Stores controller
 *
 * @author Magento
 */
class Magentostudy_Stores_Adminhtml_StoresController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Magentostudy_Stores_Adminhtml_StoresController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('stores/manage')
            ->_addBreadcrumb(
                  Mage::helper('magentostudy_stores')->__('Stores'),
                  Mage::helper('magentostudy_stores')->__('Stores')
              )
            ->_addBreadcrumb(
                  Mage::helper('magentostudy_stores')->__('Manage Stores'),
                  Mage::helper('magentostudy_stores')->__('Manage Stores')
              )
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Stores'))
             ->_title($this->__('Manage Stores'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Stores item
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Stores item
     */
    public function editAction()
    {
        $this->_title($this->__('Stores'))
             ->_title($this->__('Manage Stores'));

        // 1. instance stores model
        /* @var $model Magentostudy_Stores_Model_Item */
        $model = Mage::getModel('magentostudy_stores/stores');

        // 2. if exists id, check it and load data
        $storesId = $this->getRequest()->getParam('id');
        if ($storesId) {
            $model->load($storesId);

            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('magentostudy_stores')->__('Stores item does not exist.')
                );
                return $this->_redirect('*/*/');
            }
            // prepare title
            $this->_title($model->getTitle());
            $breadCrumb = Mage::helper('magentostudy_stores')->__('Edit Item');
        } else {
            $this->_title(Mage::helper('magentostudy_stores')->__('New Item'));
            $breadCrumb = Mage::helper('magentostudy_stores')->__('New Item');
        }

        // Init breadcrumbs
        $this->_initAction()->_addBreadcrumb($breadCrumb, $breadCrumb);

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('stores_item', $model);

        // 5. render layout
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectPath   = '*/*';
        $redirectParams = array();

        // check if data sent
        $data = $this->getRequest()->getPost();
        if ($data) {
            $data = $this->_filterPostData($data);
            // init model and set data
            /* @var $model Magentostudy_Stores_Model_Item */
            $model = Mage::getModel('magentostudy_stores/stores');

            // if stores item exists, try to load it
            $storesId = $this->getRequest()->getParam('stores_id');
            if ($storesId) {
                $model->load($storesId);
            }
            // save image data and remove from data array
            if (isset($data['image'])) {
                $imageData = $data['image'];
                unset($data['image']);
            } else {
                $imageData = array();
            }
            $model->addData($data);

            try {
                $hasError = false;
                /* @var $imageHelper Magentostudy_Stores_Helper_Image */
                $imageHelper = Mage::helper('magentostudy_stores/image');
                // remove image

                if (isset($imageData['delete']) && $model->getImage()) {
                    $imageHelper->removeImage($model->getImage());
                    $model->setImage(null);
                }

                // upload new image
                $imageFile = $imageHelper->uploadImage('image');
                if ($imageFile) {
                    if ($model->getImage()) {
                        $imageHelper->removeImage($model->getImage());
                    }
                    $model->setImage($imageFile);
                }
                // save the data
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('magentostudy_stores')->__('The stores item has been saved.')
                );

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $redirectPath   = '*/*/edit';
                    $redirectParams = array('id' => $model->getId());
                }
            } catch (Mage_Core_Exception $e) {
                $hasError = true;
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $hasError = true;
                $this->_getSession()->addException($e,
                    Mage::helper('magentostudy_stores')->__('An error occurred while saving the stores item.')
                );
            }

            if ($hasError) {
                $this->_getSession()->setFormData($data);
                $redirectPath   = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
            }
        }

        $this->_redirect($redirectPath, $redirectParams);
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        $itemId = $this->getRequest()->getParam('id');
        if ($itemId) {
            try {
                // init model and delete
                /** @var $model Magentostudy_Stores_Model_Item */
                $model = Mage::getModel('magentostudy_stores/stores');
                $model->load($itemId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('magentostudy_stores')->__('Unable to find a stores item.'));
                }
                $model->delete();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('magentostudy_stores')->__('The stores item has been deleted.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('magentostudy_stores')->__('An error occurred while deleting the stores item.')
                );
            }
        }

        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('stores/manage/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('stores/manage/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('stores/manage');
                break;
        }
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    /**
     * Grid ajax action
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Flush Stores Posts Images Cache action
     */
    public function flushAction()
    {
        if (Mage::helper('magentostudy_stores/image')->flushImagesCache()) {
            $this->_getSession()->addSuccess('Cache successfully flushed');
        } else {
            $this->_getSession()->addError('There was error during flushing cache');
        }
        $this->_forward('index');
    }
}
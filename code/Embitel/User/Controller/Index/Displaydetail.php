<?php

namespace Embitel\User\Controller\Index;

use \Magento\Framework\App\Action\HttpGetActionInterface;
use \Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action;

class Displaydetail extends Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Prints the information
     * @return Page
     */


    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\News\Career\Model\Sample::class);
            // return $this->resultPageFactory->create();
            // die($id);
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
             /** \Magento\Framework\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect =  $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
                
            }
            
        }
          
            $resultPage = $this->_resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Career Details'));
           
            // var_dump($resultPage->getLayout()->getBlock('news_career'));

            $resultPage->getLayout()->getBlock('news_career')->setData('news_career', $model);
            return $resultPage;
    }
}

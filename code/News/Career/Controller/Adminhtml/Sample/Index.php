<?php

namespace News\Career\Controller\Adminhtml\Sample;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Backend\Model\View\Result\ForwardFactory;

class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ACTION_RESOURCE='News_Career::career';
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;
    /**
     * Result PageFactory
     *
     * @var PageFactory
     *
     */
    protected $resultPageFactory;
    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactoty;
    /**
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactoty
     * @param Context $context
     */
    public function __construct(
         Registry $registry,

       PageFactory $resultPageFactory,

          ForwardFactory $resultForwardFactoty,
          Context $context)
          {
            $this->coreRegistry =$registry;
            $this->resultPageFactory =$resultPageFactory;

            $this->resultForwardFactory =$resultForwardFactoty;
            parent::__construct($context);
          }
          /**
           * @return \Magento\Framework\View\Result\Page
           */
          public function execute()
          {
        $resultPage=$this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('New career_module'),__('New Career_module'));
        $resultPage->getConfig()->getTitle()->prepend(__('New Career_module'));
        return $resultPage;


          }
        }
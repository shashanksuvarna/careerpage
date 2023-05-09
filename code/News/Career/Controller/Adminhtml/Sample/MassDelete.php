<?php

namespace News\Career\Controller\Adminhtml\Sample;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use News\Career\Model\ResourceModel\Sample\CollectionFactory;

class MassDelete extends Action
{
    /**
     * Mass Action Filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Collection Factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context            $context
     * @param Filter             $filter
     * @param CollectionFactory  $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // Get collection of samples to be deleted
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        // echo($collection->getSize());die;
        // Delete each sample in the collection
        $deleteCount = 0;
        foreach ($collection->getItems() as $sample) {
            $sample->delete();
            $deleteCount++;
        }

        // Add success message
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $deleteCount));

        // Redirect to sample grid
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }

    /**
     * Check if the current user is allowed to access this action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('News_Career::sample_delete');
    }
}

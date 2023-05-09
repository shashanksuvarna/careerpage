<?php
namespace Embitel\User\Block;

use \Magento\Framework\View\Element\Template;

use News\Career\Model\Sample; //used backend model file

class Displaydetail extends Template
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        Sample $sample,
        array $data = []
    ) {
        $this->_sample = $sample;
        parent::__construct($context, $data);
    }

    /**
     * @return Post[]
     */
    public function getArticles()
    {
        return $this->_sample->getCollection();
    }

    public function getAssetUrl($asset)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }
}

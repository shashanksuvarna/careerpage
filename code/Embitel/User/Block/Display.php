<?php
namespace Embitel\User\Block;

use \Magento\Framework\View\Element\Template;

use News\Career\Model\Sample; //used model file

class Display extends Template
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
        
    ){
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
}
?>


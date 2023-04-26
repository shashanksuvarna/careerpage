<?php
namespace News\Career\Model\ResourceModel\Sample;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;



class Collection extends AbstractCollection
{
    /**
     
     * @var string
     */
    protected $id_fieldname='id';
    
    protected function _construct()
    {
        $this->_init(
            'News\Career\Model\Sample',
            'News\Career\Model\ResourceModel\Sample'

        );
    }
    
}
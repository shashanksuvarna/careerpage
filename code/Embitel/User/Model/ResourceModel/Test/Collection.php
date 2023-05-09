<?php
namespace Embitel\User\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Embitel\User\Model\Test',
            'Embitel\User\Model\ResourceModel\Test'
        );
    }
}

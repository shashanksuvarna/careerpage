<?php
namespace Embitel\User\Model;

use Magento\Framework\Model\AbstractModel;

class Test extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Embitel\User\Model\ResourceModel\Test');
    }
}

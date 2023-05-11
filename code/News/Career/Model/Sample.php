<?php
namespace News\Career\Model;

use Magento\Framework\Model\AbstractModel;

class Sample extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('News\Career\Model\ResourceModel\Sample');
    }
}

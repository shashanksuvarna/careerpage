<?php
namespace News\Career\Model;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use News\Career\Model\ResourceModel\Sample\CollectionFactory;

/**
 * class SampleProvider
 *
 * Model
 */
class SampleProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */

     protected $dataPersistor;
     /**
      * @var array
      */
      protected $loadedData;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $sampleCollectionFactory,
        array $meta = [],
        array $data = []
    ) {

        $this->collection=$sampleCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    public function getData()
    {

        $this->loadedData=[];
        return $this->loadedData;
    }
}

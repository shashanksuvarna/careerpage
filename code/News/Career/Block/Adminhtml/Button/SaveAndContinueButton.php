<?php
namespace News\Career\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class SaveAndContinueButton extends Generic implements ButtonProviderInterface
{
     /**

      * @return array

      */
    public function getButtonData()
    {

        return [
        'label' => __('Save and Continue Edit'),
        'class' => 'save',
        'data_attribute' => [
        'mage-init' => [
        'button' => [
        'event' => 'saveAndContinueEdit' ],
                ],
            ],
        'sort_order' => 80,
        ];
    }
}

<?php

namespace News\Career\Model\Page\Source;

class EnablingPin implements \Magento\Framework\Option\ArrayInterface

{
 public function toOptionArray()
 {

$options = [
 [

 'label' => __('--Choose Option--'),
 'value' => '', ],
 [
 'label' => __('Yes'),
 'value' => 'Yes',
 ],
 [
    'label' => __('No'),
    'value' => 'No',
 ],


];
return $options;
}

}

?>
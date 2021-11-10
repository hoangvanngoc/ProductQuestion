<?php
 namespace AHT\ProductQuestions\Model;
 
class Answers extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AHT\ProductQuestions\Model\ResourceModel\Answers');
    }
}
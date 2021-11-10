<?php
 
 namespace AHT\ProductQuestions\Model\ResourceModel\Questions;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
 
    protected function _construct()
    {
        $this->_init('AHT\ProductQuestions\Model\Questions', 'AHT\ProductQuestions\Model\ResourceModel\Questions');
    }
}
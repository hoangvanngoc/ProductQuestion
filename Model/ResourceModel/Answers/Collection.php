<?php
 namespace AHT\ProductQuestions\Model\ResourceModel\Answers;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
 
    protected function _construct()
    {
        $this->_init('AHT\ProductQuestions\Model\Answers', 'AHT\ProductQuestions\Model\ResourceModel\Answers');
    }
}
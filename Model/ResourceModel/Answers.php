<?php
 
namespace AHT\ProductQuestions\Model\ResourceModel;
 
class Answers extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_idFieldName = 'entity_id';


    protected function _construct()
    {
        $this->_init('product_answers', 'entity_id');
    }
}
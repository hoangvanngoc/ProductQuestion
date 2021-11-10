<?php
 
namespace AHT\ProductQuestions\Model\ResourceModel;
 
class Questions extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_questions', 'entity_id');
    }

}
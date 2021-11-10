<?php
 namespace AHT\ProductQuestions\Model;
 
class Questions extends \Magento\Framework\Model\AbstractModel
{
    const QUESTIONS_STATUS_PENDDING = 0;
    const QUESTIONS_STATUS_APROVED = 1;

     public function getQuestionStatus()
    {
        return [self::QUESTIONS_STATUS_PENDDING => __('Pending'), self::QUESTIONS_STATUS_APROVED => __('Approved')];
    }
    
    protected function _construct()
    {
        $this->_init('AHT\ProductQuestions\Model\ResourceModel\Questions');
    }
}
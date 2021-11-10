<?php
namespace AHT\ProductQuestions\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface 
{
    protected $_questions;
    protected $_answers;

    public function __construct(
        \AHT\ProductQuestions\Model\Questions $questions,
        \AHT\ProductQuestions\Model\AnswersFactory $answers
     )
    {
        $this->_questions = $questions;
        $this->_answers = $answers;
    }
    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $optionStatus = $this->QuestionStatus();
        $options = [];
        if( $optionStatus) {
            foreach ( $optionStatus as $key => $value) {
                $options[] = [
                    'label' => $value,
                    'value' => $key,
                ];
            }
        }
        return $options;
    }
    
    private function QuestionStatus() {
       return  $this->_questions->getQuestionStatus();
    } 

}
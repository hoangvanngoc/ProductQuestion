<?php

namespace AHT\ProductQuestions\Block;

class ProductQuestion extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;
    protected $_questionsCollectionFactory;
    protected $_anwsersCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \AHT\ProductQuestions\Model\ResourceModel\Questions\CollectionFactory $questionsCollectionFactory,
        \AHT\ProductQuestions\Model\ResourceModel\Answers\CollectionFactory $anwsersCollectionFactory,
        \Magento\Catalog\Model\Session $catalogSession,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_catalogSession = $catalogSession;
        $this->_questionsCollectionFactory = $questionsCollectionFactory;
        $this->_anwsersCollectionFactory = $anwsersCollectionFactory;
      
        parent::__construct($context, $data);
    }

    /*
     * return bool
     */
    public function getLogin()
    {
        
        return $this->_customerSession->isLoggedIn();
    }

    public function getAnswer($id) {
        $answer = $this->_anwsersCollectionFactory->create();
        $answer->addFieldToFilter('question_id', array('eq'=> $id));
		$answer->addFieldToFilter('status', array('eq'=> 1));
        return $answer;
    } 

    public function getProductQuestions() {
        $productId =  $this->_catalogSession->getData('last_viewed_product_id');
		$question = $this->_questionsCollectionFactory->create();
		$question->addFieldToFilter('product_id', array('eq'=> $productId));
		$question->addFieldToFilter('status', array('eq'=> 1));

		return $question;
    }
}

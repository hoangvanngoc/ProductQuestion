<?php

namespace AHT\ProductQuestions\Controller\Adminhtml\Index;

class Save extends \Magento\Framework\App\Action\Action
{
    const IS_AWSWER_ON = 1;

    protected $_redirect;
    protected $_questionsFactory;
    protected $_answersFactory;
    private  $_helperData;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory,
        \AHT\ProductQuestions\Model\QuestionsFactory $questionsFactory,
        \AHT\ProductQuestions\Model\AnswersFactory $answersFactory,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \AHT\ProductQuestions\Helper\Data $helperData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->_redirect = $redirect;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_questionsFactory = $questionsFactory;
        $this->_answersFactory = $answersFactory;
        $this->_helperData = $helperData;
        $this->_scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $request = $this->_redirect->getRefererUrl();
        $request = explode('/', $request);
        $questionId = $request[9];

        $data = $this->getRequest()->getParams();
        $question = $this->_questionsFactory->create()->load($questionId);
        //send email 
        if ($question->getIsSendEmail() == 1) {
            //send mail
            $templateId = $this->_scopeConfig->getValue('aht/product/email_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE); 
            $fromEmail = $this->_scopeConfig->getValue('aht/product/email_sender', \Magento\Store\Model\ScopeInterface::SCOPE_STORE); 
            $fromName = 'Admin';             // sender Name
            $toEmail = 'ngochv@quantsville.com';
            // $question->getEmail()
            //check name if exit
            $name = $question->getAuthorName();
            if ($name == "") {
                $name = "user";
            }

            $this->_helperData->sendEmail($templateId, $fromEmail, $fromName, $toEmail, $question->getQuestion(), strip_tags($data['answer']), $name);
        }

        $answer = $this->_answersFactory->create();
        try {
            //save data
            $answer->setAnswer($data['answer']);
            $answer->setQuestionId($questionId);
            $answer->setStatus($data['status']);
            $question->setStatus($data['status']);
            $answer->setCreatedAt(date('Y-m-d H:i:s'));
            $answer->setUpdatedAt(date('Y-m-d H:i:s'));
            $answer->save();

            $question->setIsAnswer(self::IS_AWSWER_ON);
            $question->save();
            $this->messageManager->addSuccess(__('Save Successfully'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error ' . $e));
        }
    }
}

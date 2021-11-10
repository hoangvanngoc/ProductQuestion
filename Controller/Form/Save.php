<?php
namespace AHT\ProductQuestions\Controller\Form;

use Magento\Framework\Controller\ResultFactory;


class Save extends \Magento\Framework\App\Action\Action
{
    const SEND_EMAIL_TRUE = 1;
    const SEND_EMAIL_FALSE = 0;
    
    /*
    * @var $resultRedirect
    * @var $formFactory
    * @var $_customerSession;
    */
    protected $_questionFactory;
    protected $_cacheTypeList;
    protected $_cacheFrontendPool;
    protected $_customerSession;
    protected $_catalogSession;
    protected $_redirect;
    protected $_resultPageFactory;
 
    /*
    * @param Action\Context $context
    * @param FormFactory $formFactory
    * @param \Magento\Customer\Model\Session $customerSession
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \AHT\ProductQuestions\Model\QuestionsFactory $questionFactory, 
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Framework\Controller\Result\Redirect $redirect,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory
    )
    {
        $this->_questionFactory = $questionFactory;
        parent::__construct($context);
        $this->_customerSession = $customerSession;
        $this->_catalogSession = $catalogSession;
        $this->_resultPageFactory = $resultPageFactory;
    }
 
    public function execute()
    {
        $customerMail = $this->_customerSession->getCustomer()->getEmail();
        $productId = $this->_catalogSession->getData('last_viewed_product_id');

        $data = $this->getRequest()->getParams();
        $productQuestion = $this->_questionFactory->create();
        try{
            $productQuestion->setProductId($productId);
            $productQuestion->setCustomerId($this->_customerSession->getCustomer()->getId());
            $productQuestion->setQuestion($data['question']);
            $productQuestion->setAuthorName($data['author_name']);
            $productQuestion->setStatus('pending');
            // is logged
            if ($this->_customerSession->isLoggedIn()) 
            {
                $productQuestion->setEmail($customerMail);
            } else {
                $productQuestion->setEmail($data['email']);
            }
            // is send email check
            if(isset($data['send_email']))
            {
                $productQuestion->setIsSendEmail(self::SEND_EMAIL_TRUE);
            }
            else
            {
                $productQuestion->setIsSendEmail(self::SEND_EMAIL_FALSE);
            }
            $productQuestion->setIsAnswer("No");
            $productQuestion->setCreatedAt(date('Y-m-d H:i:s'));
            $productQuestion->setUpdatedAt(date('Y-m-d H:i:s'));
        
            $productQuestion->save();
            
            $this->messageManager->addSuccess(__('Your questions sended successfully, Please wait Admin reply!'));

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;

        }catch (\Exception $e){
            $this->messageManager->addError(__('Error!'.$e));
        }
        
    }
}

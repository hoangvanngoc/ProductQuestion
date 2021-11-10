<?php

namespace AHT\ProductQuestions\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Approved extends \Magento\Backend\App\Action
{
    protected $_filter;
    protected $_collectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \AHT\ProductQuestions\Model\ResourceModel\Questions\CollectionFactory $collectionFactory
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        // Get collection
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        // Update status to approved
        foreach ($collection as $item) {
            $item->setStatus(1);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been approved.', $collection->getSize()));

        // Redirect to List page
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }
}

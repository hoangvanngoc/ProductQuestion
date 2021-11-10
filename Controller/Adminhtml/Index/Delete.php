<?php
namespace AHT\ProductQuestions\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use AHT\ProductQuestions\Model\ResourceModel\Questions\CollectionFactory;
use AHT\ProductQuestions\Model\QuestionsFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;
 
class Delete extends Action
{
    private $questionFactory;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;
 
    public function __construct(
        Action\Context $context,
        QuestionsFactory $questionFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->questionFactory = $questionFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }
 
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getData() as $item) {
            $deleteQuestion = $this->questionFactory->create()->load($item['entity_id']);
            try {
                $deleteQuestion->delete();
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }
 
        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }
 
        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('questions/index/index');
    }
}
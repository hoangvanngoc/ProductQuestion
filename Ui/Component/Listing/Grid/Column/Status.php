<?php

namespace AHT\ProductQuestions\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class Action
 * @package AHT\ProductQuestions\Ui\Component\Listing\Grid\Column
 */
class Status extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Action constructor.
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['status'] == 0) {
                    $item['status'] = '<span class="grid-severity-critical"><span>' . 'Pendding' . '</span></span>';
                }
                if ($item['status'] == 1) {
                    $item['status'] = '<span class="grid-severity-notice"><span>' . 'Approved' . '</span></span>';
                }
            }
        }

        return $dataSource;
    }
} ?>
<?php

?>
<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category UiComponent
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface,
    Magento\Framework\View\Element\UiComponent\ContextInterface,
    Magento\Framework\View\Element\UiComponentFactory,
    Magento\Ui\Component\Listing\Columns\Column
        ;

/**
 * Class PostActions
 */
class PostActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT    = 'wblog/post/edit';
    const URL_PATH_DELETE  = 'wblog/post/delete';
    const URL_PATH_DETAILS = 'wblog/post/details';

   /**
    * @var UrlBuilder 
    */
    protected $actionUrlBuilder;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder         $actionUrlBuilder
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    /**
     * Prepare Data Source
     *
     * @param  array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['post_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_EDIT,
                                    [ 'post_id' => $item['post_id'] ]
                                ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_DELETE,
                                    [ 'post_id' => $item['post_id'] ]
                                ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }
                
                //TODO: make preview link
//                if (isset($item['identifier'])) {
//                    $item[$name]['preview'] = [
//                        'href' => $this->actionUrlBuilder->getUrl(
//                            $item['identifier'],
//                            /*isset($item['_first_store_id']) ? $item['_first_store_id'] :*/ null,
//                            /*isset($item['store_code']) ? $item['store_code'] :*/ null
//                        ),
//                        'label' => __('Preview')
//                    ];
//                }
            }
        }

        return $dataSource;
    }
}

<?php

namespace Windigo\Blog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class PostActions
 */
class PostActions extends Column
{
	/**
	 * Url path
	 */
	const URL_PATH_EDIT = 'wblog/post/edit';
	const URL_PATH_DELETE = 'wblog/post/delete';
	const URL_PATH_DETAILS = 'wblog/post/details';

	/**
	 * @var UrlInterface
	 */
	protected $urlBuilder;

	/**
	 * Constructor
	 *
	 * @param ContextInterface $context
	 * @param UiComponentFactory $uiComponentFactory
	 * @param UrlInterface $urlBuilder
	 * @param array $components
	 * @param array $data
	 */
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		UrlInterface $urlBuilder,
		array $components = [],
		array $data = []
	) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	/**
	 * @param array $items
	 * @return array
	 */
	/**
	 * Prepare Data Source
	 *
	 * @param array $dataSource
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
								[
									'post_id' => $item['post_id']
								]
							),
							'label' => __('Edit')
						],
						'delete' => [
							'href' => $this->urlBuilder->getUrl(
								static::URL_PATH_DELETE,
								[
									'post_id' => $item['post_id']
								]
							),
							'label' => __('Delete'),
							'confirm' => [
								'title' => __('Delete "${ $.$data.title }"'),
								'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
							]
						]
					];
				}
			}
		}

		return $dataSource;
	}
}

<?php

namespace Windigo\Blog\Block\Adminhtml\Post;

/**
 * Adminhtml post grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
	/**
	 * @var \Windigo\Blog\Model\Resource\Post\CollectionFactory
	 */
	protected $_collectionFactory;

	/**
	 * @var \Windigo\Blog\Model\Post
	 */
	protected $_post;

	/**
	 * @param \Magento\Backend\Block\Template\Context $context
	 * @param \Magento\Backend\Helper\Data $backendHelper
	 * @param \Windigo\Blog\Model\Post $post
	 * @param \Windigo\Blog\Model\Resource\Post\CollectionFactory $collectionFactory
	 * @param array $data
	 */
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Backend\Helper\Data $backendHelper,
		\Windigo\Blog\Model\Post $post,
		\Windigo\Blog\Model\Resource\Post\CollectionFactory $collectionFactory,
		array $data = []
	) {
		$this->_collectionFactory = $collectionFactory;
		$this->_post = $post;
		parent::__construct($context, $backendHelper, $data);
	}

	/**
	 * @return void
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setId('postGrid');
		$this->setDefaultSort('identifier');
		$this->setDefaultDir('ASC');
	}

	/**
	 * Prepare collection
	 *
	 * @return \Magento\Backend\Block\Widget\Grid
	 */
	protected function _prepareCollection()
	{
		$collection = $this->_collectionFactory->create();
		/* @var $collection \Windigo\Blog\Model\Resource\Post\Collection */
		$collection->setFirstStoreFlag(true);
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	/**
	 * Prepare columns
	 *
	 * @return \Magento\Backend\Block\Widget\Grid\Extended
	 */
	protected function _prepareColumns()
	{
		$this->addColumn('title', ['header' => __('Title'), 'index' => 'title']);

		$this->addColumn('identifier', ['header' => __('URL Key'), 'index' => 'identifier']);

		$this->addColumn(
			'is_active',
			[
				'header' => __('Status'),
				'index' => 'is_active',
				'type' => 'options',
				'options' => $this->_post->getAvailableStatuses()
			]
		);

		$this->addColumn(
			'creation_time',
			[
				'header' => __('Created'),
				'index' => 'creation_time',
				'type' => 'datetime',
				'header_css_class' => 'col-date',
				'column_css_class' => 'col-date'
			]
		);

		$this->addColumn(
			'update_time',
			[
				'header' => __('Modified'),
				'index' => 'update_time',
				'type' => 'datetime',
				'header_css_class' => 'col-date',
				'column_css_class' => 'col-date'
			]
		);

		$this->addColumn(
			'post_actions',
			[
				'header' => __('Action'),
				'sortable' => false,
				'filter' => false,
				'renderer' => 'Windigo\Blog\Block\Adminhtml\Post\Grid\Renderer\Action',
				'header_css_class' => 'col-action',
				'column_css_class' => 'col-action'
			]
		);

		return parent::_prepareColumns();
	}

	/**
	 * After load collection
	 *
	 * @return void
	 */
	protected function _afterLoadCollection()
	{
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}

	/**
	 * Filter store condition
	 *
	 * @param \Magento\Framework\Data\Collection $collection
	 * @param \Magento\Framework\DataObject $column
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	protected function _filterStoreCondition($collection, \Magento\Framework\DataObject $column)
	{
		if (!($value = $column->getFilter()->getValue())) {
			return;
		}

		$this->getCollection()->addStoreFilter($value);
	}

	/**
	 * Row click url
	 *
	 * @param \Magento\Framework\DataObject $row
	 * @return string
	 */
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', ['post_id' => $row->getId()]);
	}
}

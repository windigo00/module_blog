<?php
namespace Windigo\Blog\Model;

use Windigo\Blog\Api\PostRepositoryInterface,
	Windigo\Blog\Api\Data\PostInterface,
	Windigo\Blog\Model\Resource\Post as ResourcePost,
	Windigo\Blog\Model\Resource\Post\CollectionFactory as PostCollectionFactory,
	Magento\Framework\Api\DataObjectHelper,
	Magento\Framework\Api\SortOrder,
	Magento\Framework\Exception\CouldNotDeleteException,
	Magento\Framework\Exception\CouldNotSaveException,
	Magento\Framework\Exception\NoSuchEntityException,
	Magento\Framework\Reflection\DataObjectProcessor,
	Magento\Framework\Api\AbstractSimpleObject,
	Magento\Framework\Api\SearchCriteriaInterface
		;
/**
 * PostRepository
 *
 * @author KuBik
 */
class PostRepository extends AbstractSimpleObject implements PostRepositoryInterface {
	
	/**
	 * @var ResourcePost
	 */
	protected $resource;

	/**
	 * @var PostFactory
	 */
	protected $blogFactory;

	/**
	 * @var PostCollectionFactory
	 */
	protected $blogCollectionFactory;

	/**
	 * @var \Windigo\Blog\Api\Data\PostSearchResultsInterfaceFactory
	 */
	protected $searchResultsFactory;

	/**
	 * @var DataObjectHelper
	 */
	protected $dataObjectHelper;

	/**
	 * @var DataObjectProcessor
	 */
	protected $dataObjectProcessor;

	/**
	 * @var \Windigo\Blog\Api\Data\PostInterfaceFactory
	 */
	protected $dataPostFactory;
	
	/**
	 * @param ResourcePost $resource
	 * @param PostFactory $blogFactory
	 * @param \Windigo\Blog\Api\Data\PostInterfaceFactory $dataPostFactory
	 * @param PostCollectionFactory $blogCollectionFactory
	 * @param \Windigo\Blog\Api\Data\PostSearchResultsInterfaceFactory $searchResultsFactory
	 * @param DataObjectHelper $dataObjectHelper
	 * @param DataObjectProcessor $dataObjectProcessor
	 */
	public function __construct(
		ResourcePost $resource,
		PostFactory $blogFactory,
		\Windigo\Blog\Api\Data\PostInterfaceFactory $dataPostFactory,
		PostCollectionFactory $blogCollectionFactory,
		\Windigo\Blog\Api\Data\PostSearchResultsInterfaceFactory $searchResultsFactory,
		DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor
	) {
		$this->resource = $resource;
		$this->blogFactory = $blogFactory;
		$this->blogCollectionFactory = $blogCollectionFactory;
		$this->searchResultsFactory = $searchResultsFactory;
		$this->dataObjectHelper = $dataObjectHelper;
		$this->dataPostFactory = $dataPostFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
	}
	
	/**
	 * Delete Post
	 *
	 * @param \Windigo\Blog\Api\Data\PostInterface $blog
	 * @return bool
	 * @throws CouldNotDeleteException
	 */
	public function delete(PostInterface $blog) {
		try {
			$this->resource->delete($blog);
		} catch (\Exception $exception) {
			throw new CouldNotDeleteException(__($exception->getMessage()));
		}
		return true;
	}
	/**
	 * Delete Post by given Post Identity
	 *
	 * @param string $blogId
	 * @return bool
	 * @throws CouldNotDeleteException
	 * @throws NoSuchEntityException
	 */
	public function deleteById($blogId) {
		return $this->delete($this->getById($blogId));
	}
	
	/**
	 * Load Post data by given Post Identity
	 *
	 * @param string $blogId
	 * @return Post
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 */
	public function getById($blogId) {
		$blog = $this->blogFactory->create();
		$blog->load($blogId);
		if (!$blog->getId()) {
			throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $blogId));
		}
		return $blog;
	}

	/**
	 * Load Post data collection by given search criteria
	 *
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
	 * @return \Windigo\Blog\Model\ResourceModel\Post\Collection
	 */
	public function getList(SearchCriteriaInterface $searchCriteria) {
		$searchResults = $this->searchResultsFactory->create();
		$searchResults->setSearchCriteria($criteria);

		$collection = $this->blogCollectionFactory->create();
		foreach ($criteria->getFilterGroups() as $filterGroup) {
			foreach ($filterGroup->getFilters() as $filter) {
				if ($filter->getField() === 'store_id') {
					$collection->addStoreFilter($filter->getValue(), false);
					continue;
				}
				$condition = $filter->getConditionType() ?: 'eq';
				$collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
			}
		}
		$searchResults->setTotalCount($collection->getSize());
		$sortOrders = $criteria->getSortOrders();
		if ($sortOrders) {
			/** @var SortOrder $sortOrder */
			foreach ($sortOrders as $sortOrder) {
				$collection->addOrder(
					$sortOrder->getField(),
					($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
				);
			}
		}
		$collection->setCurPage($criteria->getCurrentPage());
		$collection->setPageSize($criteria->getPageSize());
		$blogs = [];
		/** @var Post $blogModel */
		foreach ($collection as $blogModel) {
			$blogData = $this->dataPostFactory->create();
			$this->dataObjectHelper->populateWithArray(
				$blogData,
				$blogModel->getData(),
				'Windigo\Blog\Api\Data\PostInterface'
			);
			$blogs[] = $this->dataObjectProcessor->buildOutputDataArray(
				$blogData,
				'Windigo\Blog\Api\Data\PostInterface'
			);
		}
		$searchResults->setItems($blogs);
		return $searchResults;
	}

	/**
	 * Save Post data
	 *
	 * @param \Windigo\Blog\Api\Data\PostInterface $blog
	 * @return Post
	 * @throws CouldNotSaveException
	 */
	public function save(PostInterface $blog) {
		try {
			$this->resource->save($blog);
		} catch (\Exception $exception) {
			throw new CouldNotSaveException(__($exception->getMessage()));
		}
		return $blog;
	}
}

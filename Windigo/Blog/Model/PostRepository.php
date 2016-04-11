<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Model
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
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
 * @author Windigo <jakub.kuris@gmail.com>
 */
class PostRepository extends AbstractSimpleObject implements PostRepositoryInterface
{
    
    /**
     * @var ResourcePost
     */
    protected $resource;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

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
     * @param ResourcePost                                             $resource
     * @param PostFactory                                              $postFactory
     * @param \Windigo\Blog\Api\Data\PostInterfaceFactory              $dataPostFactory
     * @param PostCollectionFactory                                    $postCollectionFactory
     * @param \Windigo\Blog\Api\Data\PostSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                                         $dataObjectHelper
     * @param DataObjectProcessor                                      $dataObjectProcessor
     */
    public function __construct(
        ResourcePost $resource,
        PostFactory $postFactory,
        \Windigo\Blog\Api\Data\PostInterfaceFactory $dataPostFactory,
        PostCollectionFactory $postCollectionFactory,
        \Windigo\Blog\Api\Data\PostSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPostFactory = $dataPostFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }
    
    /**
     * Delete Post
     *
     * @param  \Windigo\Blog\Api\Data\PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post) 
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    /**
     * Delete Post by given Post Identity
     *
     * @param  string $postId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($postId) 
    {
        return $this->delete($this->getById($postId));
    }
    
    /**
     * Load Post data by given Post Identity
     *
     * @param  string $postId
     * @return Post
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($postId) 
    {
        $post = $this->postFactory->create();
        $post->load($postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }
        return $post;
    }

    /**
     * Load Post data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param                                        \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return                                       \Windigo\Blog\Model\ResourceModel\Post\Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria) 
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->postCollectionFactory->create();
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
            /**
 * @var SortOrder $sortOrder 
*/
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $posts = [];
        /**
 * @var Post $postModel 
*/
        foreach ($collection as $postModel) {
            $postData = $this->dataPostFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $postData,
                $postModel->getData(),
                'Windigo\Blog\Api\Data\PostInterface'
            );
            $posts[] = $this->dataObjectProcessor->buildOutputDataArray(
                $postData,
                'Windigo\Blog\Api\Data\PostInterface'
            );
        }
        $searchResults->setItems($posts);
        return $searchResults;
    }

    /**
     * Save Post data
     *
     * @param  \Windigo\Blog\Api\Data\PostInterface $post
     * @return Post
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post) 
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $post;
    }
}

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

use Windigo\Blog\Api\BlogRepositoryInterface,
    Windigo\Blog\Api\Data\BlogInterface,
    Windigo\Blog\Model\Resource\Blog as ResourceBlog,
    Windigo\Blog\Model\Resource\Blog\CollectionFactory as BlogCollectionFactory,
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
 * BlogRepository
 *
 * @author KuBik
 */
class BlogRepository extends AbstractSimpleObject implements BlogRepositoryInterface
{
    
    /**
     * @var ResourceBlog
     */
    protected $resource;

    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * @var BlogCollectionFactory
     */
    protected $blogCollectionFactory;

    /**
     * @var \Windigo\Blog\Api\Data\BlogSearchResultsInterfaceFactory
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
     * @var \Windigo\Blog\Api\Data\BlogInterfaceFactory
     */
    protected $dataBlogFactory;
    
    /**
     * @param ResourceBlog                                             $resource
     * @param BlogFactory                                              $blogFactory
     * @param \Windigo\Blog\Api\Data\BlogInterfaceFactory              $dataBlogFactory
     * @param BlogCollectionFactory                                    $blogCollectionFactory
     * @param \Windigo\Blog\Api\Data\BlogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                                         $dataObjectHelper
     * @param DataObjectProcessor                                      $dataObjectProcessor
     */
    public function __construct(
        ResourceBlog $resource,
        BlogFactory $blogFactory,
        \Windigo\Blog\Api\Data\BlogInterfaceFactory $dataBlogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        \Windigo\Blog\Api\Data\BlogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBlogFactory = $dataBlogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }
    
    /**
     * Delete Blog
     *
     * @param  \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog) 
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    /**
     * Delete Blog by given Blog Identity
     *
     * @param  string $blogId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId) 
    {
        return $this->delete($this->getById($blogId));
    }
    
    /**
     * Load Blog data by given Blog Identity
     *
     * @param  string $blogId
     * @return Blog
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($blogId) 
    {
        $blog = $this->blogFactory->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Blog with id "%1" does not exist.', $blogId));
        }
        return $blog;
    }

    /**
     * Load Blog data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param                                        \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return                                       \Windigo\Blog\Model\ResourceModel\Blog\Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria) 
    {
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
        $blogs = [];
        /**
 * @var Blog $blogModel 
*/
        foreach ($collection as $blogModel) {
            $blogData = $this->dataBlogFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $blogData,
                $blogModel->getData(),
                'Windigo\Blog\Api\Data\BlogInterface'
            );
            $blogs[] = $this->dataObjectProcessor->buildOutputDataArray(
                $blogData,
                'Windigo\Blog\Api\Data\BlogInterface'
            );
        }
        $searchResults->setItems($blogs);
        return $searchResults;
    }

    /**
     * Save Blog data
     *
     * @param  \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return Blog
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog) 
    {
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blog;
    }
}

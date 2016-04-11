<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Interface
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Blog CRUD interface.
 *
 * @api
 */
interface BlogRepositoryInterface
{
    /**
     * Save blog.
     *
     * @param  \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return \Windigo\Blog\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Windigo\Blog\Api\Data\BlogInterface $blog);


    /**
     * Retrieve blog.
     *
     * @param  int $blogId
     * @return \Windigo\Blog\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($blogId);


    /**
     * Retrieve blogs matching the specified criteria.
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Windigo\Blog\Api\Data\BlogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);


    /**
     * Delete blog.
     *
     * @param  \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Windigo\Blog\Api\Data\BlogInterface $blog);


    /**
     * Delete blog by ID.
     *
     * @param  int $blogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($blogId);


}

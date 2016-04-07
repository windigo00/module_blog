<?php
namespace Windigo\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Post CRUD interface.
 * @api
 */
interface PostRepositoryInterface
{
	/**
	 * Save post.
	 *
	 * @param \Windigo\Blog\Api\Data\PostInterface $post
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function save(\Windigo\Blog\Api\Data\PostInterface $post);

	/**
	 * Retrieve post.
	 *
	 * @param int $postId
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getById($postId);

	/**
	 * Retrieve posts matching the specified criteria.
	 *
	 * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	 * @return \Windigo\Blog\Api\Data\PostSearchResultsInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

	/**
	 * Delete post.
	 *
	 * @param \Windigo\Blog\Api\Data\PostInterface $post
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function delete(\Windigo\Blog\Api\Data\PostInterface $post);

	/**
	 * Delete post by ID.
	 *
	 * @param int $postId
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function deleteById($postId);
}

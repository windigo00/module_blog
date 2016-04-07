<?php
namespace Windigo\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for post search results.
 * @api
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
	/**
	 * Get posts list.
	 *
	 * @return \Windigo\Blog\Api\Data\PostInterface[]
	 */
	public function getItems();

	/**
	 * Set posts list.
	 *
	 * @param \Windigo\Blog\Api\Data\PostInterface[] $items
	 * @return $this
	 */
	public function setItems(array $items);
}

<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Interface
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for blog search results.
 *
 * @api
 */
interface BlogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blogs list.
     *
     * @return \Windigo\Blog\Api\Data\BlogInterface[]
     */
    public function getItems();


    /**
     * Set blogs list.
     *
     * @param  \Windigo\Blog\Api\Data\BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);


}

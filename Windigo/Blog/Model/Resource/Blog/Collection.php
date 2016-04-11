<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Model
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Model\Resource\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Description of Collection
 *
 * @author KuBik
 */
class Collection extends AbstractCollection
{

    /**
     * Define model & resource model
     */
    protected function _construct() 
    {
        $this->_init(
            'Windigo\Blog\Model\Blog', 'Windigo\Blog\Model\Resource\Blog'
        );
    }

}

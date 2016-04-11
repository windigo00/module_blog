<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Model
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Windigo\Blog\Model\Blog
     */
    protected $blog;

    /**
     * Constructor
     *
     * @param \Windigo\Blog\Model\Blog $blog
     */
    public function __construct(\Windigo\Blog\Model\Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->blog->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
             'label' => $value,
             'value' => $key,
            ];
        }
        return $options;
    }
}

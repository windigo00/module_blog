<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Adminhtml
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Block\Adminhtml\Post\Grid\Renderer;

class Action extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var Action\UrlBuilder
     */
    protected $actionUrlBuilder;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param Action\UrlBuilder              $actionUrlBuilder
     * @param array                          $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        Action\UrlBuilder $actionUrlBuilder,
        array $data = []
    ) {
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Render action
     *
     * @param  \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        //		$href = $this->actionUrlBuilder->getUrl(
        //			$row->getIdentifier(),
        //			$row->getData('_first_store_id'),
        //			$row->getStoreCode()
        //		);
        return '';// '<a href="' . $href . '" target="_blank">' . __('Preview') . '</a>';
    }
}

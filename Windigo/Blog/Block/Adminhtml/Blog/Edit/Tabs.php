<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Adminhtml
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Block\Adminhtml\Blog\Edit;

/**
 * Admin blog left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('blog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Blog Information'));
    }
    
}

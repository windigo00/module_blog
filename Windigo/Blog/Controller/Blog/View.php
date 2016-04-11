<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Front
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Controller\Blog;

use Windigo\Blog\Controller\AbstractBlog;

class View extends AbstractBlog
{

    /**
     * Blog Index, shows a list of blogs.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $blog_id = $this->getRequest()->getParam('blog_id', $this->getRequest()->getParam('blog_id', false));
        /**
         * @var \Windigo\Blog\Helper\Blog $blog_helper 
         */
        $blog_helper = $this->_objectManager->get('\Windigo\Blog\Helper\Blog');
        $result_page = $blog_helper->prepareResultBlog($this, $blog_id);
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}
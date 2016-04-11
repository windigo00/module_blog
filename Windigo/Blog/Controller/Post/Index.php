<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Front
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Controller\Post;

use \Magento\Framework\App\Action\Action;
/**
 * Description of Post index
 *
 * @author KuBik
 */
class Index extends Action
{
    /**
 * @var  \Magento\Framework\View\Result\PageFactory 
*/
    protected $pageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context               $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
    
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }
    
    /**
     * Post Index.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id', $this->getRequest()->getParam('post_id', false));
        /**
 * @var \Windigo\Blog\Helper\Post $post_helper 
*/
        $post_helper = $this->_objectManager->get('\Windigo\Blog\Helper\Post');
        $result_page = $post_helper->prepareResultPost($this, $post_id);
        if (!$result_page) {
            //			$resultForward = $this->pageFactory->create();
            return null;
        }
        return $result_page;
    }
}
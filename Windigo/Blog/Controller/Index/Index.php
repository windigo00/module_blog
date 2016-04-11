<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Front
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Controller\Index;

use Windigo\Blog\Controller\AbstractBlog,
    Windigo\Blog\Model\BlogFactory,
    Magento\Framework\View\Result\PageFactory,
    Magento\Framework\App\Action\Context
        ;

/**
 * Blog Index Controller
 *
 * @author windigo
 */
class Index extends AbstractBlog
{

    /**
     * @var \Windigo\Blog\Model\BlogFactory
     */
    protected $modelBlogFactory;

    /**
     * @param Context     $context
     * @param BlogFactory $modelBlogFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory, BlogFactory $modelBlogFactory) 
    {
        parent::__construct($context, $pageFactory);
        $this->modelBlogFactory = $modelBlogFactory;
    }

    public function execute()
    {
        
        $result = $this->resultPageFactory->create();
        
        return $result;
    }
    
}

<?php

namespace Windigo\Blog\Controller\Index;

use Windigo\Blog\Controller\AbstractBlog,
	Windigo\Blog\Model\BlogFactory,
	Magento\Framework\View\Result\PageFactory,
	Magento\Framework\App\Action\Context
		;

/**
 * Blog list Controller
 *
 * @author windigo
 */
class Sum extends AbstractBlog {

	/**
	 * @var \Windigo\Blog\Model\BlogFactory
	 */
	protected $modelBlogFactory;

	/**
	 * @param Context $context
	 * @param BlogFactory $modelBlogFactory
	 */
	public function __construct(Context $context, PageFactory $pageFactory, BlogFactory $modelBlogFactory) {
		parent::__construct($context, $pageFactory);
		$this->modelBlogFactory = $modelBlogFactory;
	}

	public function execute()
	{
		
		$result = $this->resultPageFactory->create();
		
		return $result;
	}
	
}

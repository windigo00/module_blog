<?php
namespace Windigo\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context,
	Magento\Framework\View\Result\PageFactory,
	Magento\Backend\App\Action
		;

class Index extends Action
{
	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}
	/**
	 * Check the permission to run it
	 *
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Windigo_Blog::post');
	}

	/**
	 * Index action
	 *
	 * @return \Magento\Backend\Model\View\Result\Page
	 */
	public function execute()
	{
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Windigo_Blog::post');
		$resultPage->addBreadcrumb(__('Post'), __('Post'));
		$resultPage->addBreadcrumb(__('Manage Posts'), __('Manage Posts'));
		$resultPage->getConfig()->getTitle()->prepend(__('Posts'));

		return $resultPage;
	}
}

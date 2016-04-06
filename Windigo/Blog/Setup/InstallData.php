<?php
namespace Windigo\Blog\Setup;

use Windigo\Blog\Model\Blog,
	Windigo\Blog\Model\BlogFactory,
	Windigo\Blog\Model\Post,
	Windigo\Blog\Model\PostFactory,
	Magento\Framework\Module\Setup\Migration,
	Magento\Framework\Setup\InstallDataInterface,
	Magento\Framework\Setup\ModuleContextInterface,
	Magento\Framework\Setup\ModuleDataSetupInterface
		;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
	/**
	 * Blog factory
	 *
	 * @var BlogFactory
	 */
	private $blogFactory;
	/**
	 * Post factory
	 *
	 * @var PostFactory
	 */
	private $postFactory;

	/**
	 * Init
	 *
	 * @param BlogFactory $blogFactory
	 * @param PostFactory $postFactory
	 */
	public function __construct(BlogFactory $blogFactory, PostFactory $postFactory)
	{
		$this->blogFactory = $blogFactory;
		$this->postFactory = $postFactory;
	}

	/**
	 * {@inheritdoc}
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 */
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$blogs = [
			[
				'title' => 'How to create a simple module',
				'identifier' => 'the_summary',
				'created_at' => date('Y-m-d H:i:s'),
				'is_active' => 1
			],
			[
				'title' => 'Create a module with custom database table',
				'identifier' => 'the_summary_2',
				'created_at' => date('Y-m-d H:i:s'),
				'is_active' => 1
			]
		];

		/**
		 * Insert default and system blogs
		 */
		foreach ($blogs as $data) {
			$this->createBlog()->setData($data)->save();
		}
		$posts = [
			[
				'title' => 'first test post',
				'content' => 'aaaaaaa',
			]
		];
		
	}

	/**
	 * Create blog
	 *
	 * @return Blog
	 */
	public function createBlog()
	{
		return $this->blogFactory->create();
	}
	
	/**
	 * Create post
	 *
	 * @return Post
	 */
	public function createPost()
	{
		return $this->postFactory->create();
	}
}

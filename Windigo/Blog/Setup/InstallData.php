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
     * @var \Psr\Log\LoggerInterface
     */
	private $log;

	/**
	 * Init
	 *
	 * @param BlogFactory $blogFactory
	 * @param PostFactory $postFactory
	 * @param \Psr\Log\LoggerInterface $logger
	 */
	public function __construct(BlogFactory $blogFactory, PostFactory $postFactory, \Psr\Log\LoggerInterface $logger)
	{
		$this->blogFactory = $blogFactory;
		$this->postFactory = $postFactory;
		$this->log = $logger;
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
				'creation_time' => date('Y-m-d H:i:s'),
				'is_active' => 1
			],
			[
				'title' => 'Create a module with custom database table',
				'identifier' => 'the_summary_2',
				'creation_time' => date('Y-m-d H:i:s'),
				'is_active' => 1
			]
		];
		
		/**
		 * Blog Posts
		 */
		$posts = [
			[
				[
					'title' => 'first test post',
					'content' => 'aaaaaaa',
					'identifier' => 'first_test',
					'creation_time' => date('Y-m-d H:i:s'),
					'is_active' => 1
				],
				[
					'title' => 'second test post',
					'content' => 'bbbbb',
					'identifier' => 'second_test',
					'creation_time' => date('Y-m-d H:i:s'),
					'is_active' => 1
				]
			],[
				[
					'title' => 'Phasellus faucibus molestie nisl',
					'content' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Fusce tellus odio, dapibus id fermentum quis, suscipit id erat. Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. Maecenas sollicitudin. Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. Suspendisse sagittis ultrices augue. Cras pede libero, dapibus nec, pretium sit amet, tempor quis. Cras elementum. Nullam faucibus mi quis velit. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
					'identifier' => 'phasellus_faucibus_molestie_nisl',
					'creation_time' => date('Y-m-d H:i:s'),
					'is_active' => 1
				],
				[
					'title' => 'Pellentesque habitant morbi',
					'content' => 'Nulla pulvinar eleifend sem. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Et harum quidem rerum facilis est et expedita distinctio. Suspendisse nisl. Phasellus faucibus molestie nisl. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Proin mattis lacinia justo. Donec ipsum massa, ullamcorper in, auctor et, scelerisque sed, est. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Pellentesque sapien. Curabitur vitae diam non enim vestibulum interdum. Nulla quis diam. Sed convallis magna eu sem. Praesent in mauris eu tortor porttitor accumsan. Nunc auctor.',
					'identifier' => 'pellentesque_habitant_morbi',
					'creation_time' => date('Y-m-d H:i:s'),
					'is_active' => 1
				]
			]
		];

		/**
		 * Insert default and system blogs
		 */
		foreach ($blogs as $idx => $data) {
			$blog = $this->createBlog()->setData($data)->save();
			foreach ($posts[$idx] as $post) {
				$post['blog'] = $blog->getId();
				$this->createPost()->setData($post)->save();
			}
		}
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

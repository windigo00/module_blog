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
				'title' => 'Lorem ipsum dolor sit amet',
				'identifier' => 'ipsum_dolor',
				'creation_time' => date('Y-m-d H:i:s'),
				'is_active' => 1
			],
			[
				'title' => 'Nemo enim ipsam voluptatem quia voluptas',
				'identifier' => 'voluptatem_quia',
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
					'title' => 'Ut enim ad minim veniam',
					'content' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Fusce aliquam vestibulum ipsum. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. In rutrum. Vivamus luctus egestas leo. Etiam ligula pede, sagittis quis, interdum ultricies, scelerisque eu. Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Pellentesque ipsum. Nullam sit amet magna in magna gravida vehicula. Maecenas aliquet accumsan leo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Aliquam in lorem sit amet leo accumsan lacinia. In laoreet, magna id viverra tincidunt, sem odio bibendum justo, vel imperdiet sapien wisi sed libero. Aliquam erat volutpat.</p>',
					'identifier' => 'consectetuer_adipiscing',
					'creation_time' => date('Y-m-d H:i:s'),
					'is_active' => 1
				],
				[
					'title' => 'Cras elementum',
					'content' => '<p>Etiam neque. Cras elementum. Fusce aliquam vestibulum ipsum. Nulla non arcu lacinia neque faucibus fringilla. Fusce wisi. Integer in sapien. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Integer malesuada. Donec vitae arcu. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p><p>Fusce aliquam vestibulum ipsum. Mauris elementum mauris vitae tortor. Nulla est. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Mauris metus. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. Mauris elementum mauris vitae tortor. Nullam at arcu a est sollicitudin euismod. Suspendisse nisl. Praesent vitae arcu tempor neque lacinia pretium. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante.</p>',
					'identifier' => 'aliquam_vestibulum',
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

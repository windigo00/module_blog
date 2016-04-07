<?php
namespace Windigo\Blog\Model;

use Windigo\Blog\Api\Data\PostInterface,
	Magento\Framework\DataObject\IdentityInterface,
	Magento\Framework\Model\AbstractModel
		;

/**
 * Description of Post
 *
 * @author KuBik
 * 
 * @method \Windigo\Blog\Model\Resource\Post _getResource()
 * @method \Windigo\Blog\Model\Resource\Post getResource()
 */
class Post extends AbstractModel implements PostInterface, IdentityInterface {
	/**#@+
	 * Post's Statuses
	 */
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;
	/**#@-*/ 
	
	/**
	 * @var \Windigo\Blog\Model\BlogFactory
	 */
	protected $modelBlogFactory;
	
	/**
	 * Define resource model
	 */
	protected function _construct()
	{
		$this->_init('Windigo\Blog\Model\Resource\Post');
	}
	
	/**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param \Windigo\Blog\Model\BlogFactory $modelBlogFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Windigo\Blog\Model\Resource\Post $resource = null,
        \Windigo\Blog\Model\Resource\Post\Collection $resourceCollection = null,
		\Windigo\Blog\Model\BlogFactory $modelBlogFactory,
        array $data = []
    ) {
		$this->modelBlogFactory = $modelBlogFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
	}
	
	/**
	 * Check if post identifier exist
	 * return post id if exists
	 *
	 * @param string $identifier
	 * @return int
	 */
	public function checkUrlKey($identifier)
	{
		return $this->_getResource()->checkIdentifier($identifier);
	}
	
	/**
	 * Load object data
	 *
	 * @param int|null $id
	 * @param string $field
	 * @return $this
	 */
	public function load($id, $field = null)
	{
		if ($id === null) {
			return $this->noRouteBlog();
		}
		return parent::load($id, $field);
	}
	
	public function getUrl() {
		$blog = $this->modelBlogFactory->create()->load($this->getBlogId());
		return $blog->getUrl() .'/'. $this->getIdentifier();
	}

	/**
	 * Load No-Route Blog
	 *
	 * @return \Windigo\Blog\Model\Blog
	 */
	public function noRouteBlog()
	{
		return $this->load(self::NOROUTE_BLOG_ID, $this->getIdFieldName());
	}

	/**
	 * Prepare post's statuses.
	 * Available event post_get_available_statuses to customize statuses.
	 *
	 * @return array
	 */
	public function getAvailableStatuses()
	{
		return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
	}
	
	/**
	 * Prepare list of blogs for post to relate to.
	 * Available event post_get_available_blogs to customize blogs.
	 *
	 * @return array
	 */
	public function getAvailableBlogs()
	{
		$blogs = $this->modelBlogFactory->create()->getCollection();
		$blogs->addFieldToFilter('is_active', 1)->addFieldToSelect('blog_id')->addFieldToSelect('title');
		$blogs = $blogs->load()->toArray();
		$ret = [];
		foreach ($blogs['items'] as $item) {
			$ret[$item['blog_id']] = $item['title'];
		}
		return $ret;
	}

	/**
	 * Get identities
	 *
	 * @return array
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * Get ID
	 *
	 * @return int
	 */
	public function getId()
	{
		return parent::getData(self::POST_ID);
	}

	/**
	 * Get identifier
	 *
	 * @return string
	 */
	public function getIdentifier()
	{
		return $this->getData(self::IDENTIFIER);
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getData(self::TITLE);
	}

	/**
	 * Get meta keywords
	 *
	 * @return string
	 */
	public function getMetaKeywords()
	{
		return $this->getData(self::META_KEYWORDS);
	}

	/**
	 * Get meta description
	 *
	 * @return string
	 */
	public function getMetaDescription()
	{
		return $this->getData(self::META_DESCRIPTION);
	}

	/**
	 * Get content
	 *
	 * @return string|null
	 */
	public function getContent()
	{
		return $this->getData(self::CONTENT);
	}
	
	/**
	 * Get creation time
	 *
	 * @return string
	 */
	public function getCreationTime()
	{
		return $this->getData(self::CREATION_TIME);
	}

	/**
	 * Get update time
	 *
	 * @return string
	 */
	public function getUpdateTime()
	{
		return $this->getData(self::UPDATE_TIME);
	}
	
	/**
	 * Get related post id
	 *
	 * @return int
	 */
	public function getBlogId()
	{
		return $this->getData(self::BLOG_ID);
	}

	/**
	 * Is active
	 *
	 * @return bool
	 */
	public function isActive()
	{
		return (bool)$this->getData(self::IS_ACTIVE);
	}

	/**
	 * Set ID
	 *
	 * @param int $id
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setId($id)
	{
		return $this->setData(self::BLOG_ID, $id);
	}

	/**
	 * Set identifier
	 *
	 * @param string $identifier
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setIdentifier($identifier)
	{
		return $this->setData(self::IDENTIFIER, $identifier);
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setTitle($title)
	{
		return $this->setData(self::TITLE, $title);
	}

	/**
	 * Set meta keywords
	 *
	 * @param string $metaKeywords
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setMetaKeywords($metaKeywords)
	{
		return $this->setData(self::META_KEYWORDS, $metaKeywords);
	}

	/**
	 * Set meta description
	 *
	 * @param string $metaDescription
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setMetaDescription($metaDescription)
	{
		return $this->setData(self::META_DESCRIPTION, $metaDescription);
	}
	
	/**
	 * Set content
	 *
	 * @param string $content
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setContent($content)
	{
		return $this->setData(self::CONTENT, $content);
	}

	/**
	 * Set creation time
	 *
	 * @param string $creationTime
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setCreationTime($creationTime)
	{
		return $this->setData(self::CREATION_TIME, $creationTime);
	}

	/**
	 * Set update time
	 *
	 * @param string $updateTime
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setUpdateTime($updateTime)
	{
		return $this->setData(self::UPDATE_TIME, $updateTime);
	}
	
	/**
	 * Set related post id
	 *
	 * @param int $postId
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setBlogId($postId)
	{
		return $this->setData(self::BLOG_ID, $postId);
	}

	/**
	 * Set is active
	 *
	 * @param int|bool $isActive
	 * @return \Windigo\Blog\Api\Data\BlogInterface
	 */
	public function setIsActive($isActive)
	{
		return $this->setData(self::IS_ACTIVE, $isActive);
	}
}

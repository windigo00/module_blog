<?php
namespace Windigo\Blog\Api\Data;

/**
 * Post interface.
 * @api
 */
interface PostInterface {
	/**#@+
	 * Constants for keys of data array. Identical to the name of the getter in snake case
	 */
	const POST_ID				= 'id';
	const TITLE					= 'title';
	const IDENTIFIER			= 'identifier';
	const META_KEYWORDS			= 'meta_keywords';
	const META_DESCRIPTION		= 'meta_description';
	const CONTENT				= 'content';
	const CREATION_TIME			= 'creation_time';
	const UPDATE_TIME			= 'update_time';
	const BLOG_ID				= 'blog_id';
	const IS_ACTIVE				= 'is_active';
	/**#@-*/

	/**
	 * Get ID
	 *
	 * @return int|null
	 */
	public function getId();

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getIdentifier();

	/**
	 * Get title
	 *
	 * @return string|null
	 */
	public function getTitle();

	/**
	 * Get meta keywords
	 *
	 * @return string|null
	 */
	public function getMetaKeywords();

	/**
	 * Get meta description
	 *
	 * @return string|null
	 */
	public function getMetaDescription();

	/**
	 * Get content
	 *
	 * @return string|null
	 */
	public function getContent();

	/**
	 * Get creation time
	 *
	 * @return string|null
	 */
	public function getCreationTime();

	/**
	 * Get update time
	 *
	 * @return string|null
	 */
	public function getUpdateTime();

	/**
	 * Get related blog id
	 *
	 * @return int
	 */
	public function getBlogId();
	
	/**
	 * Is active
	 *
	 * @return bool|null
	 */
	public function isActive();

	/**
	 * Set ID
	 *
	 * @param int $id
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setId($id);

	/**
	 * Set identifier
	 *
	 * @param string $identifier
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setIdentifier($identifier);

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setTitle($title);

	/**
	 * Set meta keywords
	 *
	 * @param string $metaKeywords
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setMetaKeywords($metaKeywords);

	/**
	 * Set meta description
	 *
	 * @param string $metaDescription
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setMetaDescription($metaDescription);

	/**
	 * Set content
	 *
	 * @param string $content
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setContent($content);

	/**
	 * Set creation time
	 *
	 * @param string $creationTime
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setCreationTime($creationTime);

	/**
	 * Set update time
	 *
	 * @param string $updateTime
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setUpdateTime($updateTime);
	
	/**
	 * Set related blog id
	 *
	 * @param int $blogId
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setBlogId($blogId);

	/**
	 * Set is active
	 *
	 * @param int|bool $isActive
	 * @return \Windigo\Blog\Api\Data\PostInterface
	 */
	public function setIsActive($isActive);
}
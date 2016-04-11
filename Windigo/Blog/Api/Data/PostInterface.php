<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Interface
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Api\Data;

/**
 * Post interface.

 * @api
 */
interface PostInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID          = 'post_id';
    const TITLE            = 'title';
    const IDENTIFIER       = 'identifier';
    const META_KEYWORDS    = 'meta_keywords';
    const META_DESCRIPTION = 'meta_description';
    const CONTENT          = 'content';
    const CREATION_TIME    = 'creation_time';
    const UPDATE_TIME      = 'update_time';
    const BLOG_ID          = 'blog';
    const IS_ACTIVE        = 'is_active';
    /**#@-*/


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();


    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();


    /**
     * Get URL Identifier
     *
     * @return string
     */
    public function getIdentifier();


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
     * @param  int $id New id of an object
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setId($id);


    /**
     * Set title
     *
     * @param  string $title New title of an object
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setTitle($title);


    /**
     * Set URL identifier
     *
     * @param  string $identifier New identifier of an object
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setIdentifier($identifier);


    /**
     * Set meta keywords
     *
     * @param  string $metaKeywords New keyword string
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setMetaKeywords($metaKeywords);


    /**
     * Set meta description
     *
     * @param  string $metaDescription New meta description
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setMetaDescription($metaDescription);


    /**
     * Set content
     *
     * @param  string $content New string content
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setContent($content);


    /**
     * Set creation time
     *
     * @param  string $creationTime New time of creation
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setCreationTime($creationTime);


    /**
     * Set update time
     *
     * @param  string $updateTime New time of update
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setUpdateTime($updateTime);


    /**
     * Set related blog id
     *
     * @param  int $blogId New id of related blog
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setBlogId($blogId);


    /**
     * Set is active
     *
     * @param  int|bool $isActive New active state of an object
     * @return \Windigo\Blog\Api\Data\PostInterface
     */
    public function setIsActive($isActive);

}

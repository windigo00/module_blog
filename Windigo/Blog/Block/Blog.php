<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Front
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Block;

use Magento\Framework\View\Element\Template,
    Magento\Framework\DataObject\IdentityInterface,
    Windigo\Blog\Api\Data\BlogInterface,
    Windigo\Blog\Model\Resource\Blog\Collection as BlogCollection,
    Windigo\Blog\Model\Blog as BlogModel;

/**
 * Description of Blog
 *
 * @author KuBik
 */
class Blog extends Template implements IdentityInterface
{
    
    /**
     * @var \Windigo\Blog\Model\Blog
     */
    protected $blog;
    /**
     * @var \Windigo\Blog\Model\Resource\BlogFactory
     */
    protected $blogFactory;
    /**
     * @var \Windigo\Blog\Model\Resource\Post\CollectionFactory
     */
    protected $postCollectionFactory;
    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface 
     */
    protected $storeManager;


    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context    $context
     * @param \Windigo\Blog\Model\Blog                            $blog
     * @param \Windigo\Blog\Model\Resource\BlogFactory            $blogFactory
     * @param \Windigo\Blog\Model\Resource\Post\CollectionFactory $postCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface          $storeManager
     * @param array                                               $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Windigo\Blog\Model\Blog $blog,
        \Windigo\Blog\Model\Resource\BlogFactory $blogFactory,
        \Windigo\Blog\Model\Resource\Post\CollectionFactory $postCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blog = $blog;
        $this->blogFactory = $blogFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
    }


    /**
     * @return string
     */
    public function getStoreUrl($url)
    {
        return $this->storeManager->getStore()->getBaseUrl().'wblog/'.$url;
    }


    /**
     * @return \Windigo\Blog\Model\Resource\Blog\Collection
     */
    public function getBlog()
    {
        if (!$this->hasData('blog')) {
            if ($this->getBlogId()) {
                /**
                 * @var \Windigo\Blog\Model\Blog $blog 
                 */
                $blog = $this->blogFactory->create();
                $blog->load($this->getBlogId(), 'identifier');
            } else {
                $blog = $this->blog;
            }
            //			$blog = $this->blogFactory->create();
            $this->setData('blog', $blog);
        }
        return $this->getData('blog');
    }


    /**
     * @return \Windigo\Blog\Model\Resource\Post\Collection
     */
    public function getPosts()
    {
        if (!$this->hasData('posts')) {
            $posts = $this->postCollectionFactory
                ->create()
                ->addFilter('is_active', 1)
                ->addFilter('blog', $this->blog->getId())
                ->addOrder(
                    BlogInterface::CREATION_TIME,
                    BlogCollection::SORT_ORDER_DESC
                );
            $this->setData('posts', $posts);
        }
        return $this->getData('posts');
    }


    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities() 
    {
        return [BlogModel::CACHE_TAG . '_' . $this->blog->getId() ];
    }
}

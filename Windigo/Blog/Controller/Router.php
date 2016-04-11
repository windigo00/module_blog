<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Front
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Controller;

use Magento\Framework\App\RouterInterface;

/**
 * Description of Router
 *
 * @author Windigo <jakub.kuris@gmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $_actionFactory;

    /**
     * Blog factory
     *
     * @var \Windigo\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * Post factory
     *
     * @var \Windigo\Blog\Model\PostFactory
     */
    protected $_postFactory;


    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Windigo\Blog\Model\BlogFactory      $blogFactory
     * @param \Windigo\Blog\Model\PostFactory      $postFactory
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Windigo\Blog\Model\BlogFactory $blogFactory,
        \Windigo\Blog\Model\PostFactory $postFactory
    ) {
        $this->_actionFactory = $actionFactory;
        $this->_blogFactory = $blogFactory;
        $this->_postFactory = $postFactory;
    }


    /**
     * Validate and Match Blog and/or Post and modify request
     *
     * @param  \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $url_key = str_replace('/wblog/', '', $request->getPathInfo());
        $url_key = rtrim($url_key, '/');
        // Check if the url has post identifier blogIdentifier/postIdentifier
        $key = explode('/', $url_key);
        $post_url = null;
        if (count($key) > 1) {
            $post_url = $key[1];
            $url_key = $key[0];
        }
        if (is_null($post_url)) {
            /**
             * @var \Windigo\Blog\Model\Blog $blog 
             */
            $blog = $this->_blogFactory->create();
            $blog_id = $blog->checkUrlKey($url_key);
            if (!$blog_id) {
                $request->setModuleName('wblog')->setControllerName('blog')->setActionName('index');
            } else {
                $request->setModuleName('wblog')->setControllerName('blog')->setActionName('view')->setParam('blog_id', $blog_id);
            }
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);

        } else {
            $post = $this->_postFactory->create();
            $post_id = $post->checkUrlKey($post_url);
            if (!$post_id) {
                return null;
            }
            
            $request->setModuleName('wblog')->setControllerName('post')->setActionName('index')->setParam('post_id', $post_id);
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);
        }

        return $this->_actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}

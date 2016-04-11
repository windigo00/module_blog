<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Adminhtml
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context,
    Windigo\Blog\Api\PostRepositoryInterface as PostRepository,
    Magento\Framework\Controller\Result\JsonFactory,
    Windigo\Blog\Api\Data\PostInterface;

/**
 * Post grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
 * @var PostDataProcessor 
*/
    protected $dataProcessor;

    /**
 * @var PostRepository  
*/
    protected $postRepository;

    /**
 * @var JsonFactory  
*/
    protected $jsonFactory;

    /**
     * @param Context           $context
     * @param PostDataProcessor $dataProcessor
     * @param PostRepository    $postRepository
     * @param JsonFactory       $jsonFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        PostRepository $postRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->postRepository = $postRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
 * @var \Magento\Framework\Controller\Result\Json $resultJson 
*/
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
                ]
            );
        }

        foreach (array_keys($postItems) as $postId) {
            /**
 * @var \Windigo\Blog\Model\Post $post 
*/
            $post = $this->postRepository->getById($postId);
            try {
                $postData = $this->filterPost($postItems[$postId]);
                $this->validatePost($postData, $post, $error, $messages);
                $extendedPostData = $post->getData();
                $this->setPostData($post, $extendedPostData, $postData);
                $this->postRepository->save($post);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPostId(
                    $post,
                    __('Something went wrong while saving the post.')
                );
                $error = true;
            }
        }

        return $resultJson->setData(
            [
            'messages' => $messages,
            'error' => $error
            ]
        );
    }

    /**
     * Filtering posted data.
     *
     * @param  array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $postData = $this->dataProcessor->filter($postData);
        $postData['custom_theme'] = /*isset($postData['custom_theme']) ? $postData['custom_theme'] : */null;
        $postData['custom_root_template'] = /*isset($postData['custom_root_template'])
         ? $postData['custom_root_template']
         : */null;
        return $postData;
    }

    /**
     * Validate post data
     *
     * @param  array                    $postData
     * @param  \Windigo\Blog\Model\Post $post
     * @param  bool                     $error
     * @param  array                    $messages
     * @return void
     */
    protected function validatePost(array $postData, \Windigo\Blog\Model\Post $post, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validate($postData) && $this->dataProcessor->validateRequireEntry($postData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPostId($post, $error->getText());
            }
        }
    }

    /**
     * Add post title to error message
     *
     * @param  PostInterface $post
     * @param  string        $errorText
     * @return string
     */
    protected function getErrorWithPostId(PostInterface $post, $errorText)
    {
        return '[Post ID: ' . $post->getId() . '] ' . $errorText;
    }

    /**
     * Set post data
     *
     * @param  \Windigo\Blog\Model\Post $post
     * @param  array                    $extendedPostData
     * @param  array                    $postData
     * @return $this
     */
    public function setPostData(\Windigo\Blog\Model\Post $post, array $extendedPostData, array $postData)
    {
        $post->setData(array_merge($post->getData(), $extendedPostData, $postData));
        return $this;
    }
}

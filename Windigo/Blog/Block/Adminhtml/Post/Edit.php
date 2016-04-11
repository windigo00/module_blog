<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Adminhtml
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Block\Adminhtml\Post;

/**
 * Admin Post
 *
 * @author Kubik
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize post edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'blog_id';
        $this->_blockGroup = 'Windigo_Blog';
        $this->_controller = 'adminhtml_post';

        parent::_construct();

        if ($this->_isAllowedAction('Windigo_Blog::post_save')) {
            $this->buttonList->update('save', 'label', __('Save Post'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                'mage-init' => [
                'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                ],
                ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Windigo_Blog::post_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Post'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('wblog_post')->getId()) {
            return __("Edit Post '%1'", $this->escapeHtml($this->_coreRegistry->registry('wblog_post')->getTitle()));
        } else {
            return __('New Post');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param  string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('post/*/save', ['_current' => true, 'back' => 'edit']);
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('post_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'post_content');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
				}
			};
		";
        return parent::_prepareLayout();
    }
}

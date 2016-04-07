<?php
namespace Windigo\Blog\Model\Post\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
	/**
	 * @var \Windigo\Blog\Model\Post
	 */
	protected $post;

	/**
	 * Constructor
	 *
	 * @param \Windigo\Blog\Model\Post $post
	 */
	public function __construct(\Windigo\Blog\Model\Post $post)
	{
		$this->post = $post;
	}

	/**
	 * Get options
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		$availableOptions = $this->post->getAvailableStatuses();
		$options = [];
		foreach ($availableOptions as $key => $value) {
			$options[] = [
				'label' => $value,
				'value' => $key,
			];
		}
		return $options;
	}
}

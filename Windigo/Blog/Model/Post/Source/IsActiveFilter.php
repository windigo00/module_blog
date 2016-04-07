<?php

namespace Windigo\Blog\Model\Post\Source;

/**
 * Is active filter source
 */
class IsActiveFilter extends IsActive
{
	/**
	 * {@inheritdoc}
	 */
	public function toOptionArray()
	{
		return array_merge([['label' => '', 'value' => '']], parent::toOptionArray());
	}
}

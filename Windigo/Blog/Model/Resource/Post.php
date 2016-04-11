<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Model
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
/**
 * Description of Post
 *
 * @author KuBik
 */
class Post extends AbstractDb
{
    
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;
    
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime                $dateTime
     * @param string                                            $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->dateTime = $dateTime;
    }
    
    /**
     * Define main table
     */
    protected function _construct() 
    {
        $this->_init('blog_post', 'post_id');
    }
    
    /**
     *  Check whether identifier is numeric
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return bool
     */
    protected function isNumericIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether identifier is valid
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return bool
     */
    protected function isValidIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }
    
    /**
     * Check if post identifier exist
     * return post id if exists
     *
     * @param  string $identifier
     * @return int
     */
    public function checkIdentifier($identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier, 1);
        $select->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('cp.post_id')->limit(1);
        return $this->getConnection()->fetchOne($select);
    }
    
    /**
     * Retrieves post title from DB by passed identifier.
     *
     * @param  string $identifier
     * @return string|false
     */
    public function getPostTitleByIdentifier($identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier);
        $select->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('cp.title')->limit(1);
        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieves post title from DB by passed id.
     *
     * @param  string $id
     * @return string|false
     */
    public function getPostTitleById($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable(), 'title')->where('post_id = :id');
        $binds = ['id' => (int)$id];

        return $connection->fetchOne($select, $binds);
    }

    /**
     * Retrieves post identifier from DB by passed id.
     *
     * @param  string $id
     * @return string|false
     */
    public function getPostIdentifierById($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable(), 'identifier')->where('post_id = :id');
        $binds = ['id' => (int)$id];

        return $connection->fetchOne($select, $binds);
    }
    
    /**
     * Process post data before deleting
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        return parent::_beforeDelete($object);
    }

    /**
     * Process post data before saving
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if (!$this->isValidIdentifier($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The URL key contains capital letters or disallowed symbols.')
            );
        }

        if ($this->isNumericIdentifier($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The URL key cannot be made of only numbers.')
            );
        }
        return parent::_beforeSave($object);
    }

    /**
     * Assign post to store views
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        return parent::_afterSave($object);
    }

    /**
     * Load an object using 'identifier' field if there's no field specified and value is not numeric
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @param  mixed                                  $value
     * @param  string                                 $field
     * @return $this
     */
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'identifier';
        }

        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations after object load
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param  string                   $field
     * @param  mixed                    $value
     * @param  \Windigo\Blog\Model\Post $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        return $select;
    }
    
    /**
     * Retrieve load select with filter by identifier and activity
     *
     * @param  string $identifier
     * @param  int    $isActive
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadByIdentifierSelect($identifier, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['cp' => $this->getMainTable()]
        )->where(
            'cp.identifier = ?',
            $identifier
        );

        if (!is_null($isActive)) {
            $select->where('cp.is_active = ?', $isActive);
        }

        return $select;
    }
}

<?php
/**
 * Copyright © 2016 Windigo. All rights reserved.
 * See COPYING.txt for license details.

 * @category Setup
 * @package  W-Blog
 * @author   Windigo <jakub.kuris@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Windigo\Blog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface,
    Magento\Framework\Setup\ModuleContextInterface,
    Magento\Framework\Setup\SchemaSetupInterface,
    Magento\Framework\DB\Adapter\AdapterInterface,
    Magento\Framework\DB\Ddl\Table
        ;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
  *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'blog'
         */
        $table = $installer->getConnection()->newTable($installer->getTable('blog'));
        $table->addColumn('blog_id',        Table::TYPE_SMALLINT,    null,    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Blog ID')
            ->addColumn('title',        Table::TYPE_TEXT,        255,    ['nullable' => false], 'Blog Title')
            ->addColumn('identifier',    Table::TYPE_TEXT,        255,    ['nullable' => false], 'Blog String Identifier (tag)')
            ->addColumn('creation_time', Table::TYPE_TIMESTAMP,    null,    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Blog Creation Time')
            ->addColumn('update_time', Table::TYPE_TIMESTAMP,    null,    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Blog Modification Time')
            ->addColumn('is_active',    Table::TYPE_SMALLINT,    null,    ['nullable' => false, 'default' => '1'], 'Is Blog Active')
            ->addIndex(
                $setup->getIdxName(
                    $installer->getTable('blog'),
                    ['title', 'identifier'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'identifier'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )
            ->setComment('Blog Table');
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'blog_store'
         */
        //		$table = $installer->getConnection()
        //			->newTable($installer->getTable('blog_store'))
        //			->addColumn( 'blog_id',	 Table::TYPE_SMALLINT, null, ['unsigned' => true, 'nullable' => false], 'Blog ID' )
        //			->addColumn( 'store_id', Table::TYPE_SMALLINT, null, ['unsigned' => true, 'nullable' => false], 'Store ID' )
        //			->addIndex( $installer->getIdxName('blog_store', ['store_id']), ['store_id'])
        //			->addForeignKey(
        //				$installer->getFkName('blog_store', 'blog_id', 'blog', 'blog_id'), 'blog_id',
        //				$installer->getTable('blog'), 'blog_id',
        //				Table::ACTION_CASCADE )
        //			->addForeignKey(
        //				$installer->getFkName('blog_store', 'store_id', 'store', 'store_id'), 'store_id',
        //				$installer->getTable('store'), 'store_id',
        //				Table::ACTION_CASCADE)
        //			->setComment('Blog To Store Linkage Table');
        //		$installer->getConnection()->createTable($table);

        /**
         * Create table 'blog_post'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('blog_post'))
            ->addColumn('post_id',            Table::TYPE_SMALLINT,    null,    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Post ID')
            ->addColumn('title',            Table::TYPE_TEXT,        255,    ['nullable' => true], 'Post Title')
            ->addColumn('meta_keywords',    Table::TYPE_TEXT,        '64k',    ['nullable' => true], 'Meta Keywords')
            ->addColumn('meta_description', Table::TYPE_TEXT,        '64k',    ['nullable' => true], 'Meta Description')
            ->addColumn('identifier',        Table::TYPE_TEXT,        '64k',    ['nullable' => false], 'Identifier')
            ->addColumn('content',            Table::TYPE_TEXT,        '2M',    ['nullable' => false], 'Content')
            ->addColumn('creation_time',    Table::TYPE_TIMESTAMP,    null,    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time')
            ->addColumn('update_time',        Table::TYPE_TIMESTAMP,    null,    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Modification Time')
            ->addColumn('blog',            Table::TYPE_SMALLINT,    null,    ['nullable' => false, 'unsigned' => true], 'Link to blog')
            ->addColumn('is_active',        Table::TYPE_SMALLINT,    null,    ['nullable' => false, 'default' => '1'], 'Is Active')
            ->addIndex(
                $setup->getIdxName(
                    $installer->getTable('blog_post'),
                    ['title', 'meta_keywords', 'meta_description', 'content'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'meta_keywords', 'meta_description', 'content'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )
            ->addForeignKey(
                $installer->getFkName('post_blog', 'blog', 'blog', 'blog_id'), 'blog',
                $installer->getTable('blog'), 'blog_id',
                Table::ACTION_CASCADE 
            )
            ->setComment('Blog Post Table');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}

<?php
use Migrations\AbstractMigration;

class CreateArticles extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('articles');
        $table->addIndex('author')
              ->addIndex('published')
              ->addIndex('published_at');
        $table->addColumn('article_category_id', 'integer', [
                'default' => null,
                'null' => true,
              ])
              ->addColumn('title', 'string', [
                'null' => false,
              ])
              ->addColumn('body', 'text', [
                'default' => null,
                'null' => true,
              ])
              ->addColumn('author', 'string', [
                'default' => null,
                'null' => true,
              ])
              ->addColumn('published_at', 'datetime', [
                'null' => false,
              ])
              ->addColumn('published', 'boolean', [
                'default' => false,
                'null' => false,
              ])
              ->addColumn('created', 'datetime', [
                'null' => false,
              ])
              ->addColumn('modified', 'datetime', [
                'null' => false,
              ])
              ->addForeignKey('article_category_id', 'article_categories', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
              ->create();
    }
}

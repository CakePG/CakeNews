<?php
use Migrations\AbstractMigration;

class CreateArticleCategories extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('article_categories');
        $table->addColumn('name', 'string', [
                'null' => false,
              ])
              ->addColumn('priority', 'integer', [
                'default' => 0,
                'null' => false,
              ])
              ->addColumn('created', 'datetime', [
                'null' => false,
              ])
              ->addColumn('modified', 'datetime', [
                'null' => false,
              ])
              ->create();
    }
}

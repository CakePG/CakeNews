<?php
use Migrations\AbstractMigration;

class CreateArticleFiles extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('article_files');
        $table->addColumn('article_id', 'integer', [
                'null' => false,
              ])
              ->addColumn('file', 'string', [
                  'default' => null,
                  'null' => false,
              ])
              ->addColumn('name', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('dir', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('size', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('type', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addForeignKey('article_id', 'articles', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
              ->create();
    }
}

<?php
namespace CakePG\CakeNews\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('ArticleCategories', [
              'className' => 'CakePG/CakeNews.ArticleCategories'
            ])
            ->setForeignKey('article_category_id');
        $this->hasMany('ArticleFiles', [
              'className' => 'CakePG/CakeNews.ArticleFiles'
            ])
            ->setForeignKey('article_id')
            ->setDependent(true);

        // search
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => [
                    'title', 'author'
                ]
            ])
            ->value('article_category_id')
            ->value('published');
    }
    public function validationDefault(Validator $validator)
    {
        if (Configure::read('CakePG/CakeNews.enables.category')) {
          $validator
            ->notEmpty('article_category_id')
            ->numeric('article_category_id')
            ->requirePresence('article_category_id', 'create');
        } else {
          $validator
            ->allowEmpty('article_category_id');
        }
        return $validator
            ->notEmpty('title')
            ->maxLength('title', 50, '50字以内で入力して下さい。')
            ->requirePresence('title', 'create')

            ->allowEmpty('body')

            ->maxLength('author', 20, '20字以内で入力して下さい。')
            ->allowEmpty('author')

            ->notEmpty('published_at')
            ->date('published_at', 'ymd', '日付は「yyyy-mm-dd」の形式で入力して下さい。')
            ->requirePresence('published_at', 'create')

            ->notEmpty('published')
            ->add('published', 'inList', [
                'rule' => ['inList', [0, 1]]
            ])
            ->requirePresence('published', 'create');
    }
}

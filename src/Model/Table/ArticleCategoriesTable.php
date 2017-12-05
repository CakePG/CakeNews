<?php
namespace CakePG\CakeNews\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class ArticleCategoriesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('CakeNews.SortPriority');
        $this->hasMany('Articles', [
              'className' => 'CakeNews.Articles'
            ])
            ->setForeignKey('article_category_id')
            ->setDependent(false);

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
                    'name'
                ]
            ]);
    }
    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('name')
            ->maxLength('name', 20, '20字以内で入力して下さい。')
            ->requirePresence('name', 'create');
    }
}

<?php
namespace CakePG\CakeNews\Controller\Component;

use Cake\Controller\Component;

class ArticleListComponent extends Component
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controler = $this->_registry->getController();
    }

    public function getArticles($limit = null)
    {
        $this->controler->loadModel('CakePG/CakeNews.Articles');
        return $this->controler->Articles->find('all' , [
            'conditions' => ['published' => true],
            'contain' => ['ArticleCategories', 'ArticleFiles'],
            'order' => ['published_at' => 'desc', 'Articles.id' => 'desc'],
            'limit' => $limit
        ]);
    }

    public function getPaginateArticles($limit = 10)
    {
        $this->controler->loadModel('CakePG/CakeNews.Articles');
        return $articles = $this->controler->paginate($this->controler->Articles, [
            'conditions' => ['published' => true],
            'contain' => ['ArticleCategories', 'ArticleFiles'],
            'order' => ['published_at' => 'desc', 'Articles.id' => 'desc'],
            'limit' => $limit
        ]);
    }

    public function getArticle($id = null)
    {
        $this->controler->loadModel('CakePG/CakeNews.Articles');
        return $this->controler->Articles->get($id, [
          'conditions' => ['published' => true],
          'contain' => ['ArticleCategories', 'ArticleFiles']
        ]);
    }
}

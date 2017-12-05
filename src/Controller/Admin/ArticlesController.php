<?php
namespace CakePG\CakeNews\Controller\Admin;

use Cake\Core\Configure;
use CakePG\CakeNews\Controller\AppController;

class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    public function index()
    {
        $articles = $this->paginate($this->Articles, [
            'contain' => ['ArticleCategories'],
            'order' => ['published_at' => 'desc'],
            'sortWhitelist' => ['title','published', 'published_at', 'ArticleCategories.priority'],
            'finder' => [
                'search' => ['search' => $this->request->query]
            ]
        ]);
        $this->set('articleCategories', $this->Articles->ArticleCategories->find('list', ['valueField' => 'name', 'order' => ['priority' => 'asc']]));
        $this->set('publishStatuses', Configure::read('CakeNews.publish_statuses'));
        $this->set(compact('articles'));
        $this->set('_serialize', ['articles']);
    }

    public function view($id = null)
    {
        $article = $this->Articles->get($id, ['contain' => ['ArticleCategories', 'ArticleFiles']]);
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data, ['associated' => ['ArticleFiles']]);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__d('CakeNews', 'News').'を登録しました');
                return $this->redirect(['action' => 'view', $article->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeNews', 'News').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set('articleCategories', $this->Articles->ArticleCategories->find('list', ['valueField' => 'name', 'order' => ['priority' => 'asc']]));
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    public function edit($id = null)
    {
        $article = $this->Articles->get($id, ['contain' => ['ArticleCategories', 'ArticleFiles']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data, ['associated' => ['ArticleFiles']]);
            if ($this->Articles->save($article)) {
                // deleteがonのファイルを削除する
                foreach($article->article_files as $file) {
                    if ($file->delete) $this->Articles->ArticleFiles->delete($file);
                }
                $this->Flash->success(__d('CakeNews', 'News').'を編集しました');
                return $this->redirect(['action' => 'view', $id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeNews', 'News').'の編集に失敗しました。もう一度お試しください');
        }
        $this->set('articleCategories', $this->Articles->ArticleCategories->find('list', ['valueField' => 'name', 'order' => ['priority' => 'asc']]));
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        try {
          if ($this->Articles->delete($article)) {
              $this->Flash->success(__d('CakeNews', 'News').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeNews', 'News').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          $this->Flash->error("不明なエラーが発生しました");
        }
        return $this->redirect(['action' => 'index']+$this->request->query());
    }
}

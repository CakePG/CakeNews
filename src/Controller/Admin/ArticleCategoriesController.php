<?php
namespace CakePG\CakeNews\Controller\Admin;

use CakePG\CakeNews\Controller\AppController;

class ArticleCategoriesController extends AppController
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
        $articleCategories = $this->paginate($this->ArticleCategories, [
            'order' => ['priority' => 'asc'],
            'finder' => [
                'search' => ['search' => $this->request->query]
            ]
        ]);
        $this->set(compact('articleCategories'));
        $this->set('_serialize', ['articleCategories']);
    }

    public function view($id = null)
    {
        $articleCategory = $this->ArticleCategories->get($id);
        $this->set(compact('articleCategory'));
        $this->set('_serialize', ['articleCategory']);
    }

    public function add()
    {
        $articleCategory = $this->ArticleCategories->newEntity();
        if ($this->request->is('post')) {
            $priority = $this->ArticleCategories->find('all')->count();
            $articleCategory = $this->ArticleCategories->patchEntity($articleCategory, $this->request->data + ['priority' => $priority]);
            if ($this->ArticleCategories->save($articleCategory)) {
                // ソート処理
                $orders = array_values($this->ArticleCategories->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
                $this->ArticleCategories->sortPriority($orders);
                $this->Flash->success(__d('CakeNews', 'News Category').'を登録しました');
                return $this->redirect(['action' => 'view', $articleCategory->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeNews', 'News Category').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set(compact('articleCategory'));
        $this->set('_serialize', ['articleCategory']);
    }

    public function edit($id = null)
    {
        $articleCategory = $this->ArticleCategories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articleCategory = $this->ArticleCategories->patchEntity($articleCategory, $this->request->data);
            if ($this->ArticleCategories->save($articleCategory)) {
                $this->Flash->success(__d('CakeNews', 'News Category').'を編集しました');
                return $this->redirect(['action' => 'view', $id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeNews', 'News Category').'の編集に失敗しました。もう一度お試しください');
        }
        $this->set(compact('articleCategory'));
        $this->set('_serialize', ['articleCategory']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articleCategory = $this->ArticleCategories->get($id);
        try {
          if ($this->ArticleCategories->delete($articleCategory)) {
              // ソート処理
              $orders = array_values($this->ArticleCategories->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
              $this->ArticleCategories->sortPriority($orders);
              $this->Flash->success(__d('CakeNews', 'News Category').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeNews', 'News Category').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          if (strpos($e->getMessage(), '1451 Cannot delete or update a parent row') !== false) {
            $this->Flash->error(__d('CakeNews', 'News Category').'に'.__d('CakeNews', 'News').'が存在するため削除できません');
          } else {
            $this->Flash->error("不明なエラーが発生しました");
          }
        }
        return $this->redirect(['action' => 'index']+$this->request->query());
    }

    // 並び替え
    public function sort()
    {
        $articleCategories = $this->ArticleCategories->find('all', ['order' => ['priority' => 'asc']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orders = explode(',',$this->request->data['orders']);
            if ($this->ArticleCategories->sortPriority($orders)) {
                $this->Flash->success(__d('CakeNews', 'News Category').'の順序を変更しました');
                return $this->redirect(['action' => 'index']+$this->request->query());
            } else {
                $this->Flash->error(__d('CakeNews', 'News Category').'の順序の変更に失敗しました。もう一度お試しください');
            }
        }
        $this->set(compact('articleCategories'));
        $this->set('_serialize', ['articleCategories']);
    }
}

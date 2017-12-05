<?php
namespace CakePG\CakeNews\Controller\Admin;

use CakePG\CakeNews\Controller\AppController;

class ArticleFilesController extends AppController
{
    public function initialize()
    {
        // ニュースのファイルは公開（画像やPDFなど）
        parent::initialize();
        $this->Auth->allow();
    }
    public function view($fileName = null)
    {
        $this->autoRender = false;
        $articleFile = $this->ArticleFiles->find('all')->where(['file'=>$fileName])->first();
        // rawurlencode(urlエンコードしない)
        $outputName = rawurlencode($articleFile->name);
        // ファイル設定
        $filePath = $articleFile->dir.$articleFile->file;
        $response = $this->response->withFile(
            $filePath,
            ['download' => false, 'name' => $outputName]
        );
        return $response;
    }
    public function download($fileName = null)
    {
        $this->autoRender = false;
        $articleFile = $this->ArticleFiles->find('all')->where(['file'=>$fileName])->first();
        // rawurlencode(urlエンコードしない)
        $outputName = rawurlencode($articleFile->name);
        // ファイル設定
        $filePath = $articleFile->dir.$articleFile->file;
        $response = $this->response->withFile(
            $filePath,
            ['download' => true, 'name' => $outputName]
        );
        return $response;
    }
}

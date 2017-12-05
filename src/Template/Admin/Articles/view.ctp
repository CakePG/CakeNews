<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeNews', 'News').'詳細 - '.__d('CakeNews', 'Website Admin Title').' | '.__d('CakeNews', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeNews', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeNews', 'News').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeNews', 'News') ?>詳細</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeNews', 'News') ?>詳細<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $article->id]+$this->request->query, ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $article->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$article->title.'』を本当に削除しますか？']) ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index']+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <dl>
        <dt>公開</dt>
        <dd><?= $article->published_msg ?></dd>

        <?php if ($enables['category']): ?>
        <dt>カテゴリ</dt>
        <dd><?= h($article->article_category->name) ?></dd>
        <?php endif; ?>

        <dt>公開日</dt>
        <dd><?= h($article->published_at->format('Y年m月d日')) ?></dd>

        <dt>タイトル</dt>
        <dd><?= h($article->title) ?></dd>

        <?php if ($enables['author']): ?>
        <dt>投稿者</dt>
        <dd><?= h($article->author) ?></dd>
        <?php endif; ?>

        <dt>内容</dt>
        <dd><?= nl2br(h($article->body)) ?></dd>

        <?php if ($enables['upload']): ?>
        <dt>添付ファイル</dt>
        <dd>
          <?php foreach ($article->article_files as $file): ?>
            <div class="mt-2 mb-2">
            <?php if (strpos($file->type,'image') !== false): ?>
              <img class="img-thumbnail" src="<?= $file->asset_url ?>" alt="<?= h($file->name) ?>">
            <?php else: ?>
              <?= $this->Html->link(h($file->name).'<i class="fa fa-download ml-2" aria-hidden="true"></i>', ['controller'=>'ArticleFiles','action' =>'download',$file->file],['class'=>'btn btn-dark', 'escape'=>false]) ?>
            <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </dd>
        <?php endif; ?>

        <dt>作成日</dt>
        <dd><?= h($article->created) ?></dd>

        <dt>更新日</dt>
        <dd><?= h($article->modified) ?></dd>
      </dl>
    </div>
  </div>
</div>

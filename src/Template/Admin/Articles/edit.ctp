<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeNews', 'News').'編集 - '.__d('CakeNews', 'Website Admin Title').' | '.__d('CakeNews', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeNews', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeNews', 'News').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeNews', 'News') ?>編集</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeNews', 'News') ?>編集<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $article->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$article->title.'』を本当に削除しますか？']) ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index']+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-angle-left" aria-hidden="true"></i>詳細へ', ['action' => 'view', $article->id]+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <?= $this->Form->create($article, ['type' => 'file', 'templates' => 'app_form_bootstrap', 'class' => 'form-img-preview']); ?>
      <?php
        echo $this->Form->control('published', ['type' => 'checkbox', 'default' => true, 'label' => '公開する']);
        if ($enables['category']) echo $this->Form->control('article_category_id',['label' => 'カテゴリ', 'class' => 'form-control']);
        if ($canReserve) echo '<p class="offset-md-3 col-md-9">公開日付に未来の時間を入れることで公開予約ができます。</p>';
        echo $this->Form->control('published_at',['label' => $canReserve ? '公開日付' : '日付', 'default' => date('Y-m-d H:i'), 'type' => 'text', 'class' => 'form-control flattimepickr']);
        echo $this->Form->control('title',['label' => 'タイトル', 'class' => 'form-control']);
        if ($enables['author']) echo $this->Form->control('author',['label' => '投稿者', 'default' => $auth->user('last_name'), 'class' => 'form-control']);
        echo $this->Form->control('body',['label' => '内容', 'class' => 'form-control', 'rows' => 10]);
        if ($enables['upload']) echo $this->element('Articles/upload');
      ?>
      <?= $this->Form->submit('保存', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeNews', 'News Category').'詳細 - '.__d('CakeNews', 'Website Admin Title').' | '.__d('CakeNews', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeNews', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeNews', 'News Category').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeNews', 'News Category') ?>詳細</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeNews', 'News Category') ?>詳細<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $articleCategory->id]+$this->request->query, ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $articleCategory->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$articleCategory->name.'』を本当に削除しますか？']) ?>
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
        <dt>名前</dt>
        <dd><?= h($articleCategory->name) ?></dd>

        <dt>作成日</dt>
        <dd><?= h($articleCategory->created) ?></dd>

        <dt>更新日</dt>
        <dd><?= h($articleCategory->modified) ?></dd>
      </dl>
    </div>
  </div>
</div>

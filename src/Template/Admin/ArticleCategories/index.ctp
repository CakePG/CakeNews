<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeNews', 'News Category').'一覧 - '.__d('CakeNews', 'Website Admin Title').' | '.__d('CakeNews', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeNews', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeNews', 'News Category') ?>一覧</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeNews', 'News Category') ?>一覧<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-th-list" aria-hidden="true"></i>'.__d('CakeNews', 'News').'一覧', ['controller' => 'articles', 'action' => 'index'], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>並び替え', ['action' => 'sort'], ['class' => 'btn btn-warning', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i>新規登録', ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
      </nav>
    </div>
  </div>

  <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
  <div class="row mb-2">
    <div class="col-md">
      <?= $this->Form->control('q', ['label'=>false, 'class'=>'form-control', 'placeholder'=>'名前']); ?>
    </div>
    <div class="col-md-2 mt-2 mt-md-0 text-right">
      <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i> 検索', ['type' => 'submit', 'class'=>'btn btn-dark', 'escapeTitle'=>false]); ?>
      <?= $this->Html->link('<i class="fa fa-refresh" aria-hidden="true"></i>', ['action' => 'index'], ['class'=>'btn btn-warning', 'escapeTitle'=>false]); ?>
    </div>
  </div>
  <?= $this->Form->end(); ?>

  <table class="table admin">
    <thead>
      <tr>
        <th class="ids"><?= $this->Paginator->sort('priority', '順番') ?></th>
        <th><?= $this->Paginator->sort('name', '名前') ?></th>
        <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('modified', '更新日') ?></th>
        <th class="actions">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($articleCategories as $articleCategory) : ?>
        <tr>
          <td class="ids"><?= h($articleCategory->priority) ?></td>
          <td><?= h($articleCategory->name) ?></td>
          <td class="d-none d-md-table-cell"><?= h($articleCategory->modified) ?></td>
          <td class="actions">
            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>詳細', ['action' => 'view', $articleCategory->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $articleCategory->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $articleCategory->id]+$this->request->query, ['escape' => false, 'confirm' => '『'.$articleCategory->name.'』を本当に削除しますか？']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?= $this->element('pagination') ?>
</div>

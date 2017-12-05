<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeNews', 'News').'一覧 - '.__d('CakeNews', 'Website Admin Title').' | '.__d('CakeNews', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeNews', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeNews', 'News') ?>一覧</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeNews', 'News') ?>一覧<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?php if ($enables['category']): ?>
          <?= $this->Html->link('<i class="fa fa-th-list" aria-hidden="true"></i>'.__d('CakeNews', 'News Category').'一覧', ['controller' => 'articleCategories', 'action' => 'index'], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
        <?php endif; ?>
        <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i>新規登録', ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
      </nav>
    </div>
  </div>

  <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
  <div class="row mb-2">
    <div class="col-md-4">
      <?= $this->Form->control('published', ['label'=>false, 'empty'=>'公開状況', 'options'=>$publishStatuses, 'type'=>'select', 'class'=>'form-control']); ?>
    </div>
    <?php if ($enables['category']): ?>
    <div class="col-md-3">
      <?= $this->Form->control('article_category_id', ['label'=>false, 'empty'=>'カテゴリ選択', 'class'=>'form-control']); ?>
    </div>
    <?php endif; ?>
    <div class="col-md">
      <?= $this->Form->control('q', ['label'=>false, 'class'=>'form-control', 'placeholder'=>'タイトル・投稿者']); ?>
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
        <th class="ids"><?= $this->Paginator->sort('published', '公開') ?></th>
        <?php if ($enables['category']): ?><th class="d-none d-md-table-cell"><?= $this->Paginator->sort('ArticleCategories.priority', 'カテゴリ') ?></th><?php endif; ?>
        <th><?= $this->Paginator->sort('title', 'タイトル') ?></th>
        <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('published_at', '日付') ?></th>
        <th class="actions">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($articles as $article) : ?>
        <tr>
          <td class="ids"><?= $article->published_msg ?></td>
          <?php if ($enables['category']): ?><td class="d-none d-md-table-cell"><?= h($article->article_category->name) ?></td><?php endif; ?>
          <td><?= h($article->title) ?></td>
          <td class="d-none d-md-table-cell"><?= h($article->published_at->format('Y年m月d日')) ?></td>
          <td class="actions">
            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>詳細', ['action' => 'view', $article->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $article->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $article->id]+$this->request->query, ['escape' => false, 'confirm' => '『'.$article->title.'』を本当に削除しますか？']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?= $this->element('pagination') ?>
</div>

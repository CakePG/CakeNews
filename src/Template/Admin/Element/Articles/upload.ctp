<?php
    $filesCn = 0;
    $articleUploadeds = [];
    $articleUploadArticles = [];
    if($article->article_files) {
        foreach ($article->article_files as $articleFile) {
            // すでに存在するファイル
            if (isset($articleFile->id)) {
                $tempInput[0] = $articleFile->name;
                $tempInput[1] = $this->Form->control('article_files.'.$filesCn.'.id', ['type'=>'hidden', 'value'=>$articleFile->id]);
                $tempInput[2] = $this->Form->control('article_files.'.$filesCn.'.delete', ['label'=>false, 'class'=>'form-control', 'type'=>'checkbox']);;

                $articleUploadeds[] = $tempInput;
            // 送信しようとしたファイル
            } else {
                $tempInput = $this->Form->control('article_files.'.$filesCn.'.file', ['label'=>false, 'class'=>'form-control', 'type'=>'file']);
                $articleUploadArticles[] = $tempInput;
            }
            $filesCn += 1;
        }
    }
    $articleUploadArticlesTotal = count($articleUploadArticles);
    for ($i = 0;$i < 3 - $articleUploadArticlesTotal;$i++) {
        // 新規ファイル
        $tempInput = $this->Form->control('article_files.'.$filesCn.'.file', ['label'=>false, 'class'=>'form-control', 'type'=>'file']);
        $articleUploadArticles[] = $tempInput;
        $filesCn += 1;
    }
?>
<hr>
<div class="form-group row mt-2 mb-2">
    <div class="col-md-3 col-form-label">
      <label for="title">添付ファイル</label>
    </div>
    <div class="col-md-8">
      <?php foreach ($articleUploadeds as $articleUploaded): ?>
        <div class="file-delete row">
          <div class="col"><?= $articleUploaded[0]; ?></div>
          <label class="col-md-auto">
            <i class="fa fa-trash" aria-hidden="true"></i>
            <?= $articleUploaded[1].$articleUploaded[2] ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
</div>
<?php foreach ($articleUploadArticles as $articleUploadNew): ?>
    <?= $articleUploadNew; ?>
<?php endforeach; ?>

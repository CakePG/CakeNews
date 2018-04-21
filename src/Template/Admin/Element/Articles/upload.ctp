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
                $tempInput[2] = $this->Form->control('article_files.'.$filesCn.'.delete', ['label'=>false, 'class'=>'form-control', 'type'=>'checkbox']);
                $tempInput[3] = '<img class="img-thumbnail" src="'.$articleFile->asset_url.'" alt="">';

                $articleUploadeds[] = $tempInput;
            // 送信しようとしたファイル
            } else {
                $tempInput[0] = $this->Form->control('article_files.'.$filesCn.'.file', ['id'=>'uploadid'.$filesCn, 'label'=>false, 'class'=>'form-control', 'type'=>'file']);
                $tempInput[1] = '<img class="img-thumbnail d-none" id="uploadid'.$filesCn.'img" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="">';
                $articleUploadArticles[] = $tempInput;
            }
            $filesCn += 1;
        }
    }
    $articleUploadArticlesTotal = count($articleUploadArticles);
    for ($i = 0;$i < 3 - $articleUploadArticlesTotal;$i++) {
        // 新規ファイル
        $tempInput[0] = $this->Form->control('article_files.'.$filesCn.'.file', ['id'=>'uploadid'.$filesCn, 'label'=>false, 'class'=>'form-control', 'type'=>'file']);
        $tempInput[1] = '<img class="img-thumbnail d-none" id="uploadid'.$filesCn.'img" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="">';
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
        <?= $articleUploaded[3]; ?>
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
    <div class="mb-1 row">
      <div class="offset-md-3 col-md-8"><?= $articleUploadNew[1]; ?></div>
    </div>
    <?= $articleUploadNew[0]; ?>
<?php endforeach; ?>

<?php
namespace CakePG\CakeNews\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Core\Configure;

class ArticleFilesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('CakeNews.ImageTransformer');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'file' => [
                'nameCallback' => function(array $data, array $opts) {
                    $ext = substr(strrchr($data['name'], '.'), 1);
                    return str_replace('-', '', Text::uuid()).'.'.$ext;
                },
                'fields' => [
                    'dir' => 'dir',
                    'size' => 'size',
                    'type' => 'type',
                ],
                'filesystem' => [
                    'root' => '/',
                ],
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $type = $entity->file['type'];

                    // 画像でなければスキップ
                    if (!($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp')) {
                      return [$data['tmp_name'] => $data['name']];
                    }

                    $setting = Configure::read('CakeNews.image');
                    // 画像加工
                    $tmp = $this->imageTransformer($data, $type, $setting, $tmp);
                    return [
                        $tmp => $data['name']
                    ];
                },
                'path' => STORAGE.'{model}{DS}{year}{DS}{month}{DS}{field-value:article_id}{DS}',
                'keepFilesOnDelete' => false,
            ],
        ]);
        $this->belongsTo('Articles', [
              'className' => 'CakeNews.Articles'
            ])
            ->setForeignKey('article_id')
            ->setJoinType('INNER');
    }

    public function beforeRules($event, $entity, $options)
    {
        // 空の場合保存しない
        if (!$entity->file) {
            $entity->isNew(false);
            $entity->clean();
        }
        return true;
    }
    public function beforeSave($event, $entity, $options)
    {
        // 新規の場合に名前をファイル名に設定
        if ($original = $entity->getOriginal('file')) {
            if (!empty($original['name'])) $entity->name = $original['name'];
        }
        // 画像でmaskを使ってる場合はpngに変換する
        if (($entity->type == 'image/jpeg' || $entity->type == 'image/png' || $entity->type == 'image/bmp') && Configure::read('CakeMenus.image.mask')) {
            $entity->type = 'image/png';
        }
        return true;
    }
    public function validationDefault(Validator $validator)
    {
        return $validator->provider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class)
            ->add('file', 'fileUnderPhpSizeLimit', [
                'rule' => 'isUnderPhpSizeLimit',
                'message' => 'サーバーで許可されていないファイルサイズです。',
                'provider' => 'upload'
            ])
            ->add('file', 'fileUnderFormSizeLimit', [
                'rule' => 'isUnderFormSizeLimit',
                'message' => 'フォームで許可されていないファイルサイズです。',
                'provider' => 'upload'
            ])
            ->add('file', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 20000000],
                'message' => 'ファイルサイズ制限の20MBを超えています。',
                'provider' => 'upload'
            ])
            ->add('file', 'file', [
                'rule' => ['mimeType', [
                    'image/jpeg', 'image/png', 'text/plain',
                    'text/csv', 'application/pdf', 'application/vnd.ms-excel',
                    'application/vnd.ms-powerpoint', 'application/msword',
                    'image/bmp', 'application/zip', 'application/x-lzh',
                    'image/gif', 'application/x-pdf', 'application/x-google-chrome-pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                ]],
                'message' => '許可されていないファイルタイプです。',
                'on' => function ($context) {
                    return !empty($context['data']['file']['type']);
                }
            ])
            ->allowEmpty('file');
    }
}

<?php
use Cake\Core\Configure;

return [
    Configure::write('CakeNews.publish_statuses', [
      '1' => '公開',
      '0' => '非公開'
    ])
];

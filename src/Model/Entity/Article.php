<?php
namespace CakePG\CakeNews\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\I18n\Time;

class Article extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getPublishedMsg()
    {
        $publishStatuses = Configure::read('CakeNews.publish_statuses');
        $canReserve = Configure::read('CakeNews.can_reserve');
        if ($canReserve && $this->published_at > Time::now()) {
          return '<span class="badge badge-danger">予約中</span>';
        }
        return $this->published ?
        '<span class="badge badge-success">'.$publishStatuses[$this->published].'</span>' :
        '<span class="badge badge-danger">'.$publishStatuses[$this->published].'</span>';
    }
}

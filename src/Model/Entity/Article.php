<?php
namespace CakePG\CakeNews\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class Article extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getPublishedMsg()
    {
        $publishStatuses = Configure::read('CakeNews.publish_statuses');
        return $this->published ?
        '<span class="badge badge-success">'.$publishStatuses[$this->published].'</span>' :
        '<span class="badge badge-danger">'.$publishStatuses[$this->published].'</span>';
    }
}

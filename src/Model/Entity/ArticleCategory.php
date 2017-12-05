<?php
namespace CakePG\CakeNews\Model\Entity;

use Cake\ORM\Entity;

class ArticleCategory extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}

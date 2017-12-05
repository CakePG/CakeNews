<?php
namespace CakePG\CakeNews\Model\Entity;

use Cake\ORM\Entity;

class ArticleFile extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getBase64()
    {
        $img = file_get_contents($this->dir.$this->file);
        return 'data:'.$this->type.';base64,'.base64_encode($img);
    }
    protected function _getAssetUrl()
    {
        return ASSETS.str_replace(STORAGE, '', $this->dir.$this->file);
    }
}

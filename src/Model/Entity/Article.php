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

    protected function _getHtmlA()
    {
        $html = h($this->body);
        $html = preg_replace_callback('{(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)}',
          function ($matches) {
              $domain = substr($_SERVER["HTTP_HOST"], 0, 4) == 'www.' ? ltrim($_SERVER["HTTP_HOST"], 'www.') : $_SERVER["HTTP_HOST"];
              if (strpos($matches[0], $domain) !== false) {
                return '<a href="'.$matches[0].'">'.$matches[0].'</a>';
              }
              else {
                return '<a href="'.$matches[0].'" target="_blank" rel="noopener noreferrer">'.$matches[0].'</a>';
              }
          }, $html);
        return nl2br($html);
    }
}

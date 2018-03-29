<?php
namespace CakePG\CakeNews\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->set('dashboardPath', Configure::read('CakeNews.dashboard_path'));
        $this->set('enables', Configure::read('CakeNews.enables'));
        $this->set('canReserve', Configure::read('CakeNews.can_reserve'));
    }
}

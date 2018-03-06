<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/13
 * Time: 10:00
 */

class user implements SplSubject

{
    public $lognum;
    public $hobby;

    protected $observers = null;

    public function __construct($hobby)
    {
        $this->lognum = rand(1,10);
        $this->hobby = $hobby;
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        // TODO: Implement attach() method.
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        // TODO: Implement detach() method.
        $this->observers->detach($observer);
    }
    public function notify()
    {
        // TODO: Implement notify() method.
        $this->observers->rewind();
        while ($this->observers->vaild){
            $observer = $this->observers->current();
            $observer->update($this);
            $this->observers->next();
        }
    }

    public function login(){

    }

    //    php  提供了观察者和被观察接口

}


class secrity implements SplObserver {
    public function update(SplSubject $splSubject){
        if ($splSubject->lognum>=3) {
            echo  "这是第".$splSubject->lognum.'次安全登入';


        } else {
            echo  "这是第".$splSubject->lognum.'次异常登入';
        }

    }

}
class ad implements SplObserver {
    public function update(SplSubject $splSubject){
        if ($splSubject->hobby= 'sports' ) {
            echo  "台球";
        } else {
            echo  "好好学习";
        }
    }
}

//实施观察
$user = new user('sports');
$user->attach(new secrity());
$user->attach(new ad());

$user->login();
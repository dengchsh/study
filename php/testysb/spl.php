<?php

//PHP实现观察者
class User implements SplSubject
{
    public $loginnum;
    public $hubboy;
    protected $observers = null;

    public function login()
    {
        echo "<pre>";
        print_r($this->hubboy);
        echo "</pre>";
        $this->notify();
    }

    public function __construct($hobby)
    {
        $this->loginnum = rand(1,10);
//        $hubboys = array('sport','study');
//        $this->hubboy = shuffle($hubboys);
        $this->hubboy = $hobby;
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
//        echo  666;
//        指针到头部
        $this->observers->rewind();
        while ($this->observers->valid()) {

            $observer = $this->observers->current();
            $observer->update($this);
            $this->observers->next();
        }


    }
}

class secrity implements SplObserver
{
    public function update(SplSubject $subject)
    {
        echo "<pre>";
            print_r($subject->loginnum);
        echo "</pre>";
        // TODO: Implement update() method.
        if ($subject->loginnum < 3) {
            echo "安全登入" . $subject->lognum;
        } else {
            echo '异常';
        }
    }
}

class ad implements SplObserver
{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        if ($this->hubboy == 'sports') {
            echo '运动';
        } else {
            echo '去学习';
        }
    }

}

$user = new User('sports');
$user->attach(new secrity());
$user->attach(new ad());
$user->login();
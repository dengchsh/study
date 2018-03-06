<?php
//    责任连模式
$lev = rand(1,3);
class board
{
    public $power = 1;
    protected $top = 'admin';

    public function process($lev)
    {
        if ($lev<=$this->power) {
            echo '版主删帖';
        } else {
            $top = new $this->top;
            $top ->process($lev);
        }

    }
}
class admin
{
    public $power = 2;
    protected $top = 'police';
    public function process($lev)
    {
        if ($lev<=$this->power) {
            echo "封锁账号";
        } else {
            $top = new $this->top;
            $top ->process($lev);
        }

    }
}
class police
{
    public $power;
    protected $top = 'null';
    public function process()
    {
        echo "抓";
    }
}
//if ($lev == 1){
//    $board = new board();
//    $board->process();
//} else if ($lev == 2){
//    $board = new admin();
//    $board->process();
//}else {
//    $board = new police();
//    $board->process();
//}
//不用全部new 出来
echo "<pre>";
    print_r($lev);
echo "</pre>";
$judge = new board();
$judge->process($lev);
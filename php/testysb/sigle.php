<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/13
 * Time: 9:25
 */
//
//class sigle
//{
//    protected static $Ins = null;
//
//    protected function __construct()
//    {
//        if (self::$Ins === null) {
//            self::$Ins = new self();
//        }
//    }
//    public static  function getIns()
//    {
//        return self::$Ins;
//    }
//
//}
//封锁new操作  new  会出发内部的__construct
//留个接口来new对象
//防止继承被修改权限   方法前加final  方法不能被覆盖    类加final  不能被继承
//防止克隆产生多个对象
//
//$s1 = sigle::getIns();
//$s2 = clone $s1;
//if ($s1 === $s2) {
//    echo '是同一个对象';
//} else {
//    echo '不是同一个对象';
//}

class son
{
    protected static $Ins = null;
    protected function __construct()
    {
    }

    public static function getIns()
    {
        self::$Ins = new self();
        return self::$Ins;
    }

}

$s1 = son::getIns();
$s2 = clone  $s1;
if ($s1 === $s2) {
    echo '是同一个对象';
} else {
    echo '不是同一个对象';
}
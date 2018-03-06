<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12
 * Time: 16:52
 */

abstract class Tiger
{
    public abstract function climb();
}

class XTiger extends Tiger
{
    public function climb()
    {
        // TODO: Implement climb() method.
        echo 'no,no';
    }
}
class MTiger extends Tiger
{
    public function climb()
    {
        // TODO: Implement climb() method.
        echo  'yes';
    }
}

class Client
{
    public static  function callb(Tiger $animal){
        $animal->climb();
    }

}
Client::callb(new XTiger());
Client::callb(new MTiger());
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12
 * Time: 17:20
 */


interface db{
    function conn();
}

interface Factory{
    function createDB();
}

class dbMysql implements db{
    public function conn(){
        echo '链接上来Mysql';
    }
}

class dbSqlit implements db {
    public function conn(){
        echo '链接上Sqlit';
    }
}
class oracle implements db {
    public function conn(){
        echo '链接上oracle';
    }
}

class mysqlFactory implements Factory{
    public function createDB(){
        return new dbMysql();
    }

}
class sqliteFactory implements Factory{
    public function createDB(){
        return new dbSqlit();
    }
}
class oracleFactory implements Factory{
    public function createDB(){
        return new dbSqlit();
    }
}

$fac = new mysqlFactory();
$db = $fac->createDB();
$db->conn();


//修改是封闭的   扩展是开放的
//客户端 看不到类的内部细节
//实现db接口

//$db = new dbMysql();
//$db ->conn();
//
//$db = new dbSqlit();
//$db ->conn();

//class Factory
//{
//
//    public static function createDB($type){
//        if ($type =='mysql') {
//            return new dbMysql();
//        } else if($type == 'sqlite') {
//            return new dbSqlit();
//        } else {
//            throw new Exception('Error db type',1);
//        }
//    }
//}
//
//$mysql = Factory::createDB('mysql');
//$mysql = Factory::createDB('sqlite');

//在factory 的内容修改  在java c++ 中 需要重新修改

//在面向对象设计法则中  重要的开闭原则


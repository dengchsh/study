<?php

/**
 * [$text 生成文字图片] 注意线上的代码是有字体库
 * @var string
 */
function makeWordPic($text = "白",$path = './Public/wordimg/',$pading = 20, $size = 20, $font ="./simsun.ttc") {
    $fullpath = $path.$text.'.gif';
    if (!file_exists($fullpath)){
//    if (1){
        //创建一个长为500高为80的空白图片
        $img = imagecreate($size+2*$pading, $size+2*$pading);
        //给图片分配颜色
        //036AE5
        imagecolorallocate($img, 28, 121, 244);
        //设置字体颜色
        $black = imagecolorallocate($img, 255, 255, 255);
        //将ttf文字写到图片中
        imagettftext($img, $size, 0, $pading-($size/4), $pading+$size, $black, $font, $text);
        //发送头信息
//        header('Content-Type: image/gif');
        //输出图片
        // imagegif($img);
        imagegif($img,$fullpath);
        imagedestroy($img);
        echo 666;
    }
    return $fullpath;
}

/**
 * 递归创建文件
 * @param  [type]  $dirs [description]
 * @param  integer $mode [description]
 * @return [type]        [description]
 */
function mkdirss($dirs,$mode=0777) {
    if(!is_dir($dirs)){
        mkdirss(dirname($dirs), $mode);
        return @mkdir($dirs, $mode);
    }
    return true;
}



/**
 * [dopict 裁剪图片]
 * @param  [type]  $src          [源图片路径]
 * @param  [type]  $x            [原图片坐标x]
 * @param  [type]  $y            [原图片坐标x]
 * @param  [type]  $w            [原图大小取w]
 * @param  [type]  $h            [原图大小取h]
 * @param  [type]  $targ_file    [目标图片路径]
 * @param  integer $targ_w       [目标图片大小w]
 * @param  integer $targ_h       [目标图片大小y]
 * @param  integer $jpeg_quality [图片质量]
 * @return [type]                [description]
 */
function dopict($src,$x,$y,$w,$h,$targ_file,$targ_w = 300,$targ_h = 250,$jpeg_quality=85){
    $info = getimagesize($src);                         //获取图片尺寸、类型等数据
    list($from_w,$from_h,$t) = $info;
    switch ($t) {
        case '1':
            $img_from = imagecreatefromgif($src);
            break;
        case '2':
            $img_from = imagecreatefromjpeg($src);
            break;
        case '3':
            $img_from = imagecreatefrompng($src);
            break;  
    }
    //创建目标图资源
    $img_targ = ImageCreateTrueColor( $targ_w, $targ_h );
    //生成切图
    imagecopyresampled($img_targ,$img_from,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
    // //删除原有图片
    // if (file_exists('./'. $targ_file)) {
    //  unlink('./'. $targ_file);
    // }
    //保存生成的图片
    $path = dirname($targ_file);
    is_dir($path) || mkdir($path,0777,true);
    $rs = imagejpeg($img_targ,$targ_file,$jpeg_quality);
    //销毁画布资源
    imagedestroy($img_from);
    imagedestroy($img_targ);
}
/**
 * [arr_sort 二维数组排序]
 * @param  [type] $array [description]
 * @param  [type] $key   [description]
 * @param  string $order [description]
 * @return [type]        [description]
 */
function arr_sort($array,$key,$order="asc"){//asc是升序 desc是降序
    $arr_nums=$arr=array();
    foreach($array as $k=>$v){
    $arr_nums[$k]=$v[$key];
    }
    if($order=='asc'){
    asort($arr_nums);
    }else{
    arsort($arr_nums);
    }
    foreach($arr_nums as $k=>$v){
    $arr[$k]=$array[$k];
    }
    $articleinfo = $arr;
    return $arr;
}
/**
*@name object2array   将对象转化成数组
*
*
*/
function object2array($object) {
    if (is_object($object)) {
      foreach ($object as $key => $value) {
            $array[$key] = $value;
        }  
    }  else {
        $array = $object;  
    }  return $array;
}
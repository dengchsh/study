<?php
$arr=Array(
    Array('cid' => 2,'cname' => '新闻','pid' => 0),
    Array('cid' => 4,'cname' =>'体育','pid' => 0),
    Array('cid' => 5,'cname' => '娱乐','pid' => 0),
    Array('cid' => 7,'cname' => '热点新闻','pid' =>2),
    Array('cid' => 8,'cname' => '小众新闻','pid' => 2),
    Array('cid' => 9,'cname' => '民谣新闻','pid' => 8),
 
);
function formatTree($array, $pid = 0,$level = 1,$field = array('pid'=>'pid','id'=>'id','children'=>'children')){
        $arr = array();
        foreach ($array as &$v) {
            if ($v[$field['pid']] == $pid) {
                $v['level'] = $level;
                $tem = formatTree($array, $v[$field['id']],$v['level']+1,$field);
                //判断是否存在子数组
                $tem && $v[$field['children']] = $tem;
                $arr[] = $v;
            }
        }
        return $arr;
    }
 
$tree = formatTree( $arr,0,1, $field = array('pid'=>'pid','id'=>'cid','children'=>'children') );
echo '<pre>';
print_r( $tree);
 
?>
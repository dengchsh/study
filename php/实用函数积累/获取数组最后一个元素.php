<?PHP
$array = array(1,2,4,6,8);
echo end($array);
?> 
 
<?PHP
$array = array(1,2,4,6,8);
echo array_pop($array);
?> 
 
<?PHP
$array = array(1,2,4,6,8);
$k = array_slice($array,-1,1);
print_r($k);　　//结果是一维数组
?>

这是三个函数的取值方法，直接有效，按需选择吧
第二种方法有一种弊端，Array_pop()函数会把原来的数据的最后一个数“取出来”，也就是相当于剪切的意思，原来的数据中将不不再有最后一个值了
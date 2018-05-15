###特性
主要性能
###  函数变量类型  
### try  catch
### zval使用栈内存
	以前  MAKE_STD_ZVAL  从堆上分配zval内存
	PHP7  直接使用栈内存
###  
	php7 为字符串单独创建了新的类型zend_string  除了指针 长度 还增加了一个hash字段   用于保存字符串的hash值  数组键值查找不要反复计算hash值     
	减少计算时间
### hashtable
### jit 特性  对密集计算大提升




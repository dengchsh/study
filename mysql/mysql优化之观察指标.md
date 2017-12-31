## awk入门 ##

### 内置变量 ###

	变量名    含义 
	ARGC   命令行变元个数 
	ARGV   命令行变元数组 
	FILENAME   当前输入文件名 
	FNR   当前文件中的记录号 
	FS   输入域分隔符，默认为一个空格 
	RS   输入记录分隔符 
	NF   当前记录里域个数 
	NR   到目前为止记录数 
	OFS   输出域分隔符 
	ORS   输出记录分隔符 
awk '/101/'    file      显示文件file中包含101的匹配行。 

awk '{print NR,NF,$1,$NF,}' file     显示文件file的当前记录号、域数和每一行的第一个和最后一个域。
 
详细使用：https://www.cnblogs.com/emanlee/p/3327576.html

### 使用awk 观察mysql的各项指标情况
	我们可以使用show status 来查看mysql的指标
**如果直接使用show status指令得到300多条记录，会让我们看得眼花缭乱，因此我们希望能够「按需查看」一部分状态信息。这个时候，我们可以在show status语句后加上对应的like子句。**

指标分别如下：

http://blog.sina.com.cn/s/blog_68baf43d0100vu2x.html
挑选重要指标

Queries  Both   服务器执行的请求个数，包含存储过程中的请求。  
Threads_connected  Global   当前打开的连接的数量。   
Threads_created   Global    创建用来处理连接的线程数。如果Threads_created较大，你可能要增加thread_cache_size值。缓存访问率的计算方法Threads_created/Connections。   
Threads_running   Global   激活的（非睡眠状态）线程数。    



## awk运用 ##
[root@localhost bin]# ./mysqladmin -uroot  ext|awk '/Queries/{printf("%d\n",$4)}'
查看queries 的指标

思路 用脚本每秒钟执行 观察数据

查看这个三个指标的动态情况
mysqladmin -uroot ext|awk  '/Queries/{q=$4}/Threads_connected/{c=$4}/Threads_running/{r=$4}END{printf("%d %d %d\n",q,c,r)}'


### apache ab测试 ###

键入命令： 
ab -n 800 -c 800  http://192.168.0.10/ 
（-n发出800个请求，-c模拟800并发，相当800人同时访问，后面是测试url）

ab -t 60 -c 100 http://192.168.0.10/ 
在60秒内发请求，一次100个请求。 
  
//如果需要在url中带参数，这样做 
ab -t 60 -c 100 -T "text/plain" -p p.txt http://192.168.0.10/hello.html 
p.txt 是和ab.exe在一个目录 
p.txt 中可以写参数，如  p=wdp&fq=78


## Show processlist
如果观察到以下状态,则需要注意

converting HEAP to MyISAM 查询结果太大时,把结果放在磁盘 (语句写的不好,取数据太多)  
create tmp table             创建临时表(如group时储存中间结果,说明索引建的不好)  
Copying to tmp table on disk   把内存临时表复制到磁盘 (索引不好,表字段选的不好)   
locked         被其他查询锁住 (一般在使用事务时易发生,互联网应用不常发生)    
logging slow query 记录慢查询  
Sending data  是否大部分在时间浪费在发送数据上

###指标解释
	什么情况下产生临时表?
	1: group by 的列和order by 的列不同时, 2表边查时,取A表的内容,group/order by另外表的列
	2: distinct 和 order by 一起使用时
	3: 开启了 SQL_SMALL_RESULT 选项
	
	什么情况下临时表写到磁盘上?
	答:
	1:取出的列含有text/blob类型时 ---内存表储存不了text/blob类型
	2:在group by 或distinct的列中存在>512字节的string列
	3:select 中含有>512字节的string列,同时又使用了union或union all语句
###  ###对策
如果服务器频繁出现converting HEAP to MyISAM
说明:
1: sql有问题,取出的结果或中间结果过大,内存临时表放不下

2: 服务器配置的临时表内存参数过小.
 tmp_table_size 
 max_heap_table_size  



## profile使用

查看是否打开
Show  variables like ‘profiling’

打开
set profiling=on;

查看问题语句
show profiles;

分析语句的执行时间
show profile for query 2;

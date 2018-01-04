## redis是什么 ##
可以用来存储字符串,哈希结构,链表,集合,因此,常用来提供数据结构服务.  

- redis和memcached相比,的独特之处:

	1: redis可以用来做存储(storge), 而memccached是用来做缓存(cache)
	  这个特点主要因为其有”持久化”的功能.

	2: 存储的数据有”结构”,对于memcached来说,存储的数据,只有1种类型--”字符串”,
	  而redis则可以存储字符串,链表,哈希结构,集合,有序集合.

## Redis下载安装

1:官方站点: redis.io 下载最新版或者最新stable版   
2:解压源码并进入目录   
3: 不用configure   
4: 直接make    

	注:易碰到的问题,时间错误.
	原因: 源码是官方configure过的,但官方configure时,生成的文件有时间戳信息,
	Make只能发生在configure之后,
	如果你的虚拟机的时间不对,比如说是2012年
	解决: date -s ‘yyyy-mm-dd hh:mm:ss’   重写时间
	    再 clock -w  写入cmos
5: 可选步骤: make test  测试编译情况    

6: 安装到指定的目录,比如 /usr/local/redis
make  PREFIX=/usr/local/redis install
注: PREFIX要大写

7: make install之后,得到如下几个文件    

	redis-benchmark  性能测试工具
	redis-check-aof  日志文件检测工(比如断电造成日志损坏,可以检测并修复)
	redis-check-dump  快照文件检测工具,效果类上
	redis-cli  客户端
	redis-server 服务端  

8: 复制配置文件
Cp /path/redis.conf /usr/local/redis


9: 启动与连接   

	/path/to/redis/bin/redis-server  ./path/to/conf-file

例:[root@localhost redis]# ./bin/redis-server ./redis.conf 

连接: 用redis-cli   

	/path/to/redis/bin/redis-cli [-h localhost -p 6379 ]

10: 让redis以后台进程的形式运行 
编辑conf配置文件,修改如下内容;

    daemonize yes   

### 操作见菜鸟 ###

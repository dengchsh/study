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

后台运行
根据说明，把daemonize设置为yes，

9: 启动与连接   

	/path/to/redis/bin/redis-server  ./path/to/conf-file

例:[root@localhost redis]# ./bin/redis-server ./redis.conf 

连接: 用redis-cli   

	/path/to/redis/bin/redis-cli [-h localhost -p 6379 ]

10: 让redis以后台进程的形式运行 
编辑conf配置文件,修改如下内容;

    daemonize yes   

### 操作见菜鸟 ###

##redis 的数据持久化
通俗地说就是断电后数据还存在

### 常见的持久化方式 ###
1. 主从 mongoDB
2. 日志 MYSQL  二进制日志持久化数据

快照持久化
工作原理   每隔N分钟N次写操作后从内存中dump数据中  放在备份目录中


	#   In the example below the behaviour will be to save:
	#   after 900 sec (15 min) if at least 1 key changed
	#   after 300 sec (5 min) if at least 10 keys changed
	#   after 60 sec if at least 10000 keys changed

	save 900 1
	save 300 10
	save 60 10000


**全部注释 不导出！禁用**

60秒内   1000 变化    保存    没有达到    
300秒内  10   变化    保存      没有达到     
900秒被  1    变化    保存      

通诺判断时间的长度   通过操作 的次数
重写的条件 从下往上看  

导出错误  停止写
stop-writes-on-bgsave-error yes


是否压缩
rdbcompression yes

是否检测快照
rdbchecksum yes

### aof的原理

	速度与持久化的平衡
	
	Aof 的配置
	appendonly no # 是否打开 aof日志功能
	
	appendfsync always   # 每1个命令,都立即同步到aof. 安全,速度慢
	appendfsync everysec # 折衷方案,每秒写1次
	appendfsync no      # 写入工作交给操作系统,由操作系统判断缓冲区大小,统一写入到aof. 同步频率低,速度快,
	
	
	
	no-appendfsync-on-rewrite  yes: # 正在导出rdb快照的过程中,要不要停止同步aof  节省io

	auto-aof-rewrite-percentage 100 #aof文件大小比起上次重写时的大小,增长率100%时,重写

	auto-aof-rewrite-min-size 64mb #aof文件,至少超过64M时,重写


注: 在dump rdb过程中,aof如果停止同步,会不会丢失?
答: 不会,所有的操作缓存在内存的队列里, dump完成后,统一操作.

注: aof重写是指什么?
答: aof重写是指把内存中的数据,逆化成命令,写入到.aof日志里.
以解决 aof日志过大的问题.

问: 如果rdb文件,和aof文件都存在,优先用谁来恢复数据?
答: aof

问: 2种是否可以同时用?
答: 可以,而且推荐这么做

问: 恢复时rdb和aof哪个恢复的快
答: rdb快,因为其是数据的内存映射,直接载入到内存,而aof是命令,需要逐条执行 


问题： 同一个key操作多次后
把结果当成新写入的值  把结果写到内存里 

问题：rdb  aof  同事存在的时候用那个回复
用的是aof


## redis 的主从配置
1. 主从备份
2. 读写分离
3. 任务分离  

注意坑点 
 在配置slave of的时候  用127.0.0.1  不要用localhost




把结果当成新写入的值  把结果写到内存里 


aof 重写！
   



 ## 运维命令
BGREWRITEAOF 后台进程重写AOF
BGSAVE       后台保存rdb快照
SAVE         保存rdb快照
LASTSAVE     上次保存时间

Slaveof master-Host port  , 把当前实例设为master的slave

Flushall  清空所有库所有键 
Flushdb  清空当前库所有键
Showdown [save/nosave]





## mongodb 入门 ##
redis  k-v 数据库
mongodb 是文档数据库

mongodb 文档数据库,存储的是文档(Bson->json的二进制化).

特点:内部执行引擎为JS解释器, 把文档存储成bson结构,在查询时,转换为JS对象,并可以通过熟悉的js语法来操作.

mongo和传统型数据库相比,最大的不同:
传统型数据库: 结构化数据, 定好了表结构后,每一行的内容,必是符合表结构的,就是说--列的个数,类型都一样.
mongo文档型数据库: 表下的每篇文档,都可以有自己独特的结构(json对象都可以有自己独特的属性和值)

- 使用的是js 语法

### 安装 ###
下载  解压  移动到  /user/local/mongodb

-rwxr-xr-x. 1 1046 1046  4307152 Aug 24  2015 bsondump  到处bson结构   
-rwxr-xr-x. 1 1046 1046 11686488 Aug 24  2015 mongo   客户端   
-rwxr-xr-x. 1 1046 1046 22418152 Aug 24  2015 mongod  服务端    
-rwxr-xr-x. 1 1046 1046  6209480 Aug 24  2015 mongodump  导出 二进制
-rwxr-xr-x. 1 1046 1046  6008056 Aug 24  2015 mongoexport   
-rwxr-xr-x. 1 1046 1046  5958672 Aug 24  2015 mongofiles
-rwxr-xr-x. 1 1046 1046  6218480 Aug 24  2015 mongoimport
-rwxr-xr-x. 1 1046 1046  5693344 Aug 24  2015 mongooplog
-rwxr-xr-x. 1 1046 1046 22182856 Aug 24  2015 mongoperf
-rwxr-xr-x. 1 1046 1046  6338984 Aug 24  2015 mongorestore  整体导入
-rwxr-xr-x. 1 1046 1046 10540056 Aug 24  2015 mongos     路由  分片使用 
-rwxr-xr-x. 1 1046 1046  5912320 Aug 24  2015 mongostat
-rwxr-xr-x. 1 1046 1046  5780528 Aug 24  2015 mongotop


核心:
mongod: 数据库核心进程
mongos: 查询路由器,集群时用
mongo:   交互终端(客户端)

二进制导出导入:
mongodump:导出bson数据
mongorestore: 导入bson
bsondump: bson转换为json
monoplog:


数据导出导入
mongoexport: 导出json,csv,tsv格式
mongoimport: 导入json,csv,tsv

诊断工具:
mongostats
mongotop
mongosniff  用来检查mongo运行状态

### 启动服务 ###

--dbpath     数据库目录   
--logpath    日志目录   
--fork     以后进程
--port     端口默认27017 

非常占磁盘空间  需要3-4g

**实验的空间要足够大  不然经常出现实验意向不到的错误  给自己挖坑**


./bin/mongod --dbpath /path/to/database --logpath /path/to/log --fork --port 27017
 

代配置的无法启动  没有配置正常启动  未解决
about to fork child process, waiting until server is ready for connections.
forked process: 3002
ERROR: child process failed, exited with error number 1

**找到  日志指定的时候是个文件  不是目录  大大的乌龙**




--logpath 日志文件路径
--master 指定为主机器
--slave 指定为从机器
--source 指定主机器的IP地址
--pologSize 指定日志文件大小不超过64M.因为resync是非常操作量大且耗时，最好通过设置一个足够大的oplogSize来避免resync(默认的 oplog大小是空闲磁盘大小的5%)。
--logappend 日志文件末尾添加
--port 启用端口号
--fork 在后台运行
--only 指定只复制哪一个数据库
--slavedelay 指从复制检测的时间间隔
--auth 是否需要验证权限登录(用户名和密码)
 
 
-h [ --help ]             show this usage information
--version                 show version information
-f [ --config ] arg       configuration file specifying additional options
--port arg                specify port number
--bind_ip arg             local ip address to bind listener - all local ips
                           bound by default
-v [ --verbose ]          be more verbose (include multiple times for more
                           verbosity e.g. -vvvvv)
--dbpath arg (=/data/db/) directory for datafiles    指定数据存放目录
--quiet                   quieter output   静默模式
--logpath arg             file to send all output to instead of stdout   指定日志存放目录
--logappend               appnd to logpath instead of over-writing 指定日志是以追加还是以覆盖的方式写入日志文件
--fork                    fork server process   以创建子进程的方式运行
--cpu                     periodically show cpu and iowait utilization 周期性的显示cpu和io的使用情况
--noauth                  run without security 无认证模式运行
--auth                    run with security 认证模式运行
--objcheck                inspect client data for validity on receipt 检查客户端输入数据的有效性检查
--quota                   enable db quota management   开始数据库配额的管理
--quotaFiles arg          number of files allower per db, requires --quota 规定每个数据库允许的文件数
--appsrvpath arg          root directory for the babble app server 
--nocursors               diagnostic/debugging option 调试诊断选项
--nohints                 ignore query hints 忽略查询命中率
--nohttpinterface         disable http interface 关闭http接口，默认是28017
--noscripting             disable scripting engine 关闭脚本引擎
--noprealloc              disable data file preallocation 关闭数据库文件大小预分配
--smallfiles              use a smaller default file size 使用较小的默认文件大小
--nssize arg (=16)        .ns file size (in MB) for new databases 新数据库ns文件的默认大小
--diaglog arg             0=off 1=W 2=R 3=both 7=W+some reads 提供的方式，是只读，只写，还是读写都行，还是主要写+部分的读模式
--sysinfo                 print some diagnostic system information 打印系统诊断信息
--upgrade                 upgrade db if needed 如果需要就更新数据库
--repair                  run repair on all dbs 修复所有的数据库
--notablescan             do not allow table scans 不运行表扫描
--syncdelay arg (=60)     seconds between disk syncs (0 for never) 系统同步刷新磁盘的时间，默认是60s
 
Replication options:
--master              master mode 主复制模式
--slave               slave mode 从复制模式
--source arg          when slave: specify master as <server:port> 当为从时，指定主的地址和端口
--only arg            when slave: specify a single database to replicate 当为从时，指定需要从主复制的单一库
--pairwith arg        address of server to pair with
--arbiter arg         address of arbiter server 仲裁服务器，在主主中和pair中用到
--autoresync          automatically resync if slave data is stale 自动同步从的数据
--oplogSize arg       size limit (in MB) for op log 指定操作日志的大小
--opIdMem arg         size limit (in bytes) for in memory storage of op ids指定存储操作日志的内存大小
 
Sharding options:
--configsvr           declare this is a config db of a cluster 指定shard中的配置服务器
--shardsvr            declare this is a shard db of a cluster 指定shard服务器

mongod --repair





复制集

1:启动3个实例,且声明实例属于某复制集
./bin/mongod --port 27017 --dbpath /data/r0 --smallfiles --replSet rsa --fork --logpath /var/log/mongo17.log
./bin/mongod --port 27018 --dbpath /data/r1 --smallfiles --replSet rsa --fork --logpath /var/log/mongo18.log
./bin/mongod --port 27019 --dbpath /data/r2 --smallfiles --replSet rsa --fork --logpath /var/log/mongo19.log

2:配置
rsconf = {
    _id:'rsa',
    members:
    [
        {_id:0,
        host:'192.168.1.201:27017'
        }
    ]
}


3: 根据配置做初始化
	rs.initiate(rsconf);


4: 添加节点
	rs.add('192.168.0.108:27018');
	rs.add('192.168.0.108:27019');


5:查看状态
rs.status();



6:删除节点
rs.remove('192.168.1.201:27019');

7:主节点插入数据
>use test
>db.user.insert({uid:1,name:'lily'});

8:连接secondary查询同步情况
./bin/mongo --port 27019
>use test
>show tables




mongodb3.4版本以后需要对config server创建副本集

	pidfilepath = /var/run/mongodb/configsrv.pid
	dbpath = /data/mongodb/config/data
	logpath = /data/mongodb/config/log/congigsrv.log
	logappend = true
	bind_ip = 0.0.0.0  # 绑定你的监听ip
	port = 21000
	fork = true
	configsvr = true #declare this is a config db of a cluster;
	replSet=configs #副本集名称
	maxConns=20000 #设置最大连接数

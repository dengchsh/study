### 编译安装 ###
1. yum install gcc make cmakmemcached 

依赖于 libevent 库,因此我们需要先安装 libevente autoconf libtool

> tar zxvf libevent-2.0.21-stable.tar.gz
> cd libevent-2.0.21-stable
> ./configure --prefix=/usr/local/libevent
> 如果出错,读报错信息,查看原因,一般是缺少库
> make && make install
> tar zxvf memcached-1.4.5.tag.gz
> cd memcached-1.4.5
> ./configure--prefix=/usr/local/memcached \
> -with-libevent=/usr/local/libevent
> make && make install


### 通过yum 安装

启动参数
> -p <numtcp port number to listen on (default: 11211) // 监听
> 的端口   
> -u <numudp port number to listen on (default: 0, off)    
> -s <fileunix socket path to listen on (disables network support)    
> -a <maskaccess mask for unix socket, in octal (default 0700)    
> -l <ip_addrinterface to listen on, default is indrr_any    
> -d start tell memcached to start    
> -d restart tell running memcached to do a graceful restart    
> -d stop|shutdown tell running memcached to shutdown   
> -d install install memcached service // 把 memcached 注册成服务   
> -d uninstall uninstall memcached service    
> -r maximize core file limit  
> -u <usernameassume identity of <username(only when run as root)    
> -m <nummax memory to use for items in megabytes, default is 64  
> mb //分配给 memcached 的最大内存    
> -m return error on memory exhausted (rather than removing  items)
> -c <num> max simultaneous connections, default is 1024 // 最大
的连接数
> -k lock down all paged memory. note that there is a
> limit on how much memory you may lock. trying to
> allocate more than that would fail, so be sure you
> set the limit correctly for the user you started
> the daemon with (not for -u <usernameuser;
> under sh this is done with 'ulimit -s -l num_kb').
> -v verbose (print errors/warnings while in event loop) // 输出错误信息  
> -vv very verbose (also print client commands/reponses) //输出所有信息   
> -h print this help and exit    
> -i print memcached and libevent license    
> -b run a managed instanced (mnemonic: buckets)  
> -p <filesave pid in <file>, only used with -d option    
> -f <factorchunk size growth factor, default 1.25 //增长因子    
> -n <bytesminimum space allocated for key+value+flags, default 48   
> 
## 命令
- 增
add key flag expire length 回车
	key 给值起一个独特的名字
	flag 标志,要求为一个正整数
	expire 有效期
	length 缓存的长度(字节为单位)

	1. 	flag 的意义:
		memcached 基本文本协议,传输的东西,理解成字符串来存储.
		想:让你存一个 php 对象,和一个 php 数组,怎么办?
		答:序列化成字符串,往出取的时候,自然还要反序列化成 对象/数组/json 格式等等.
		这时候, flag 的意义就体现出来了.
		比如, 1 就是字符串, 2 反转成数组 3,反序列化对象.....
	
	2. 	expire 的意义:
		设置缓存的有效期,有 3 种格式
		1:设置秒数, 从设定开始数,第 n 秒后失效.
		2:时间戳, 到指定的时间戳后失效.

		**注: 有种误会,设为 0,永久有效.错误的.**
- 删除   
delete key [time seconds]
- 替换   
replace key flag expire length
- 查询   
get key    
- set 是设置和修改值
set 想当于有 add replace 两者的功能.
- incr ,decr 命令:增加/减少值的大小
应用场景------秒杀功能
- 统计命令
	stats
	stat pid 2296 进程号  
	stat uptime 4237 持续运行时间   
	stat time 1370054990   
	stat version 1.2.6
	stat pointer_size 32
	stat curr_items 4 当前存储的键个数    
	stat total_items 13
	stat bytes 236
	stat curr_connections 3
	stat total_connections 4
	stat connection_structures 4
	stat cmd_get 20
	stat cmd_set 16
	stat get_hits 13
	stat get_misses 7 // 这 2 个参数 可以算出命中率    
	stat evictions 0
	stat bytes_read 764
	stat bytes_written 618
	stat limit_maxbytes 67108864
	stat threads 1
	end

- flush_all 清空所有的存储对象

## 内存管理 ##
#### 内存碎片化 ####
在不断的申请和释放过程中,形成了一些很小的内存片断,无法再利用.
这种空闲,但无法利用内存的现象,---称为内存的碎片化

#### slab allocator 缓解内存碎片化 ####

预告把内存划分成数个 slab class 仓库.(每个 slab class 大小 1M)
各仓库,切分成不同尺寸的小块(chunk). （图 3.2）
需要存内容时,判断内容的大小,为其选取合理的仓库.

**如果有 100byte 的内容要存,但 122 大小的仓库中的 chunk 满了
并不会寻找更大的,如 144 的仓库来存储,
而是把 122 仓库的旧数据踢掉!**

**内存浪费是不可避免的**

#### grow factor 调优 ####
memcached 在启动时可以通过­f 选项指定 Growth Factor 因子, 并在某种程度上控制 slab 之间的差异. 默认值为 1.25. 但是,在该选项出现之前,这个因子曾经固定为 2,称为”powers of 2”策略。

#### memcached 的过期数据惰性删除 ####
1: 当某个值过期后,并没有从内存删除, 因此,stats 统计时, curr_item 有其信息
2: 当某个新值去占用他的位置时,当成空 chunk 来占用.
3: 当 get 值时,判断是否过期,如果过期,返回空,并且清空, curr_item 就减少了
#### memcached 此处用的 lru 删除机制. ####
memcached 此处用的 lru 删除机制.

## 分布式算法 ##
分布式之取模算法
当 挂掉一台 下降  1/(N-1)   服务器越多, 则 down 机的后果越严重! 
一致性哈希算法原理

## 缓存问题 ##

缓存雪崩现象  
> 解决 缓存不同时过期

缓存的无底洞现象 multiget-hole 

该问题由 facebook 的工作人员提出的, facebook 在 2010 年左右,memcached 节点就已经达
3000 个.缓存数千 G 内容.
他们发现了一个问题---memcached 连接频率,效率下降了,于是加 memcached 节点,
添加了后,发现因为连接频率导致的问题,仍然存在,并没有好转,称之为”无底洞现象”.
- 解决
> 把某一组 key,按其共同前缀,来分布.
> 比如 user-133-age, user-133-name,user-133-height 这 3 个 key,
> 在用分布式算法求其节点时,应该以 ‘user-133’来计算,而不是以 user-133-age/name/height 来
> 计算
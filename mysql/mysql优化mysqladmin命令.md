#  #mysql优化——mysqladmin命令
### 参数 ###
	mysqladmin 命令格式：  mysqladmin [option] command [command option] command ......
	option 选项：
	-c number 自动运行次数统计，必须和 -i 一起使用
	-i number 间隔多长时间重复执行
### 命令 ###
create databasename             创建一个新数据库  
drop databasename               删除一个数据库及其所有表  
extended-status                 给出服务器的一个扩展状态消息  
flush-hosts                     洗掉所有缓存的主机  
flush-logs                      洗掉所有日志   
flush-tables                    洗掉所有表   
flush-privileges                再次装载授权表(同reload)   
kill id,id,...                  杀死mysql线程   
password                        新口令，将老口令改为新口令  
ping                            检查mysqld是否活着   
processlist                     显示服务其中活跃线程列表  
reload                          重载授权表   
refresh                         洗掉所有表并关闭和打开日志文件   
shutdown                        关掉服务器   
status                          给出服务器的简短状态消息  
variables                       打印出可用变量  
version                         得到服务器的版本信息  
所有命令可以被缩短为其唯一的前缀，例如：status命令可如下使用   

extended-status 命令可以使用 mysqladmin ext每个命令都可以缩减为唯一的前缀

	[root@localhost bin]# ./mysqladmin status -c3 -i3
	重复执行5次status，每3秒执行一次

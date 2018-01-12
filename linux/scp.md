scp mongodb-linux-x86_64-3.6.1.tgz  root@192.168.0.189:mongodb-linux-x86_64-3.6.1.tgz 

(1) 复制文件：  

命令格式：  

scp local_file remote_username@remote_ip:remote_folder  

或者  

scp local_file remote_username@remote_ip:remote_file  

或者  

scp local_file remote_ip:remote_folder  

或者  

scp local_file remote_ip:remote_file  

第1,2个指定了用户名，命令执行后需要输入用户密码，第1个仅指定了远程的目录，文件名字不变，第2个指定了文件名  

第3,4个没有指定用户名，命令执行后需要输入用户名和密码，第3个仅指定了远程的目录，文件名字不变，第4个指定了文件名   


(2) 复制目录：  

命令格式：  

scp -r local_folder remote_username@remote_ip:remote_folder  

或者  

scp -r local_folder remote_ip:remote_folder  

第1个指定了用户名，命令执行后需要输入用户密码；  

第2个没有指定用户名，命令执行后需要输入用户名和密码；





rsync服务端方式
首先检查rsync是否安装：
rpm –q rsync
rsync-2.6.8-3.1

另外，关闭防火墙和SElinux，因为是内网中传输，所以这些没必要
service iptables stop && chkconfig iptables off 
setenforce 0

/etc/rsyncd.conf

uid = nobody
gid = nobody
user chroot = no
max connections = 200
timeout = 600
pid file = /var/run/rsyncd.pid
lock file = /var/run/rsyncd.lock
log file = /var/log/rsyncd.log
[backup]
path=/backup/
ignore errors
read only = no
list = no
hosts allow = 192.168.0.0/255.255.255.0
auth users = test
secrets file = /etc/rsyncd.password
注释：
uid = nobody
进行备份的用户，nobody 为任何用户
gid = nobody 
进行备份的组，nobody为任意组
use chroot = no
如果"use chroot"指定为true，那么rsync在传输文件以前首先chroot到path参数所指定的目录下。这样做的原因是实现额外的安全防护，但是缺点是需要以root权限，并且不能备份指向外部的符号连接所指向的目录文件。默认情况下chroot值为true.但是这个一般不需要，我选择no或false
list = no
不允许列清单
max connections = 200 
最大连接数
timeout = 600 

覆盖客户指定的IP超时时间，也就是说rsync服务器不会永远等待一个崩溃的客户端。
pidfile = /var/run/rsyncd.pid  
pid文件的存放位置
lock file = /var/run/rsync.lock  
锁文件的存放位置
log file = /var/log/rsyncd.log   
日志文件的存放位置
[backup]  
这里是认证模块名，即跟samba语法一样，是对外公布的名字
path = /backup/
这里是参与同步的目录
ignore errors  
可以忽略一些无关的IO错误
read only = no
允许可读可写
list = no
不允许列清单
hosts allow = 192.168.1.0/255.255.255.0
这里跟samba的语法是一样的，只允许192.168.21.0/24的网段进行同步，拒绝其它一切
auth users = test 
认证的用户名
secrets file = /etc/rsyncd.password  
密码文件存放地址

path = /backup/ 参与同步的目录
这个需要稍后自己要在根目录下自己建
cd /
mkdir backup
chmod –R 777 /backup
echo “test:test” > /etc/rsync.password

vim /etc/xinetd.d/rsync 
将disable=yes改为no


[root@test home]# /etc/init.d/xinetd restart
Stopping xinetd:                                           [  OK  ]
Starting xinetd:                                           [  OK  ]

如果xinetd没有的话，需要安装一下
[root@test home]# yum -y install xinetd


  RSYNC服务端启动的两种方法:
启动rsync服务端（独立启动）
[root@test home]# /usr/bin/rsync --daemon    on



启动rsync服务端 （有xinetd超级进程启动）
[root@test home]# /etc/init.d/xinetd reload

配置rsync自动启动
[root@test etc]# chkconfig rsync on
[root@test etc]# chkconfig rsync --list




[root@test home]# /etc/init.d/xinetd restart
Stopping xinetd:                                           [  OK  ]
Starting xinetd:                                           [  OK  ]

如果xinetd没有的话，需要安装一下
[root@test home]# yum -y install xinetd


  RSYNC服务端启动的两种方法:
启动rsync服务端（独立启动）
[root@test home]# /usr/bin/rsync --daemon    on



启动rsync服务端 （有xinetd超级进程启动）
[root@test home]# /etc/init.d/xinetd reload

配置rsync自动启动
[root@test etc]# chkconfig rsync on
[root@test etc]# chkconfig rsync --list



rsync -vzrtop --delete /home/ce test@192.168.0.206::backup --password-file=/etc/rsync.password
从服务器上下载文件
rsync -avz --password-file=/etc/rsyncd.password test@192.168.0.206::backup /home/
从本地上传到服务器上去
rsync -avz --password-file=/etc/rsyncd.password /home test@192.168.0.206::backup





【3】rsync客户端方式
常用：rsync -av
下载：rsync [参数]  远程文件（远程路径）  本地目录  
上传：rsync [参数]  本地文件              远程目录
rsync常用参数
如果不需要交互式的操作，rsync平时也可以像scp那样工作，下列为常用rsync参数。

-a, --archive 归档模式，表示以递归方式传输文件，并保持所有文件属性，等于-rlptgoD 
-v --verbose：详细模式输出
-r --recursive：对子目录以返回模式处理。g
-p --perms：保持文件许可权
-o --owner：保持文件属主信息
-g --group：保持文件组信息
-t --times：保持文件时间信息
--delete：删除哪些DST中存在而SRC中不存在的文件或目录
--delete-excluded：同样删除接收端哪些该选项制定排出的文件
-z --compress：对备份的文件在传输时进行压缩处理
--exclude=PATTERN：制定排除不需要传输的文件
--include=PATTERN：制定不排除需要传输的文件
--exclude-from=FILE：排除FILE中制定模式的文件
--include-from=FILE：不排除FILE中制定模式匹配的文件

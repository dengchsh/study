
##Master的配置
vim 	/etc/my.conf

- 给服务器起一个唯一的id
server-id=1
- 开启二进制日志
log-bin=mysql-bin
- 指定日志格式
binlog_format=mixd

- 授权
赋予从库权限帐号，允许用户在主库上读取日志，赋予192.168.1.2也就是Slave机器有File权限，只赋予Slave机器有File权限还不行，还要给它REPLICATION SLAVE的权限才可以。

 >GRANT FILE ON *.* TO 'root'@'192.168.1.2' IDENTIFIED BY 'mysql password';

 >GRANT REPLICATION SLAVE ON *.* TO 'root'@'192.168.1.2' IDENTIFIED BY 'mysql password';
>FLUSH PRIVILEGES

## salve配置
- 给服务器起一个唯一的id
server-id=1001

- 中继日志
relay-log=msyql-relay
- 指定日志格式
read-only=1
## 查看master节点位置 ##
show master status；

## 配置salve账号 ##
change master to master_host='192.168.0.104',master_user='root',master_password='123456',master_log_file='mysql-bin.000010',master_log_pos=617;

### start slave

## 问题坑 ##
1. 如果是可虚拟克隆的存在 mysql service uuids相同问题；
	删除auto.cnf
	重启

##命令补充
- reset slave
- start slave
- stop slave
- show master status\G;
- show slave status\G;
- change master to；

## 日志格式
	有 statement,row, mixed3种,
	其中mixed是指前2种的混合.

- 日志格式使用情况：  

	以insert into xxtable values (x,y,z)为例, 
	影响: 1行,且为新增1行, 对于其他行没有影响.  
	这个情况,用row格式,直接复制磁盘上1行的新增变化.

	以update xxtable set age=21 where name=’sss’; 
	这个情况,一般也只是影响1行. 用row也比较合适.
	
	以过年发红包,全公司的人,都涨薪100元.
	update xxtable set salary=salary+100;
	这个语句带来的影响,是针对每一行的, 因此磁盘上很多row都发生了变化.
	此处,适合就statment格式的日志.

**msyq mixed可以根据语句的不同,而自动选择适合的日志格式.**

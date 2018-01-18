配置
change master to master_host='192.168.0.104',master_user='root',master_password='123456',master_log_file='mysql-bin.000018',master_log_pos=318;


change master to master_host='192.168.0.149',master_user='root',master_password='123456',master_log_file='mysql-bin.000019',master_log_pos=901;

### 问题 ###
主主复制下一定要注意避免的问题---------同步冲突
两台服务出现主键冲突
	
	改变主键的增长方式
	1号  1 3 5 7 9 11  。。。
	2号  2  4 6 8 10 。。。
一台服务器：
> 	set global auto_increment_increment = 2;
> 	set global auto_increment_offset = 1; 
> 	set session auto_increment_increment = 2;
> 	set session auto_increment_offset = 1; 

另一台服务器：   

> 	set global auto_increment_increment = 2;
> 	set global auto_increment_offset = 2; 
> 	set session auto_increment_increment=2;
> 	set session auto_increment_offset = 2; 

最好写到配置文件中

**后期加服务器这个方法出现限制**

每次PHP插入Mysql前,先 incr->global:userid, 得到一个不重复的userid.



##被动模式的主主复制

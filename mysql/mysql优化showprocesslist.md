# Show processlist

如果观察到以下状态,则需要注意

converting HEAP to MyISAM 查询结果太大时,把结果放在磁盘 (语句写的不好,取数据太多)  
create tmp table             创建临时表(如group时储存中间结果,说明索引建的不好)  
Copying to tmp table on disk   把内存临时表复制到磁盘 (索引不好,表字段选的不好)   
locked         被其他查询锁住 (一般在使用事务时易发生,互联网应用不常发生)    
logging slow query 记录慢查询 

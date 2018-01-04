partion分区

建表的时候  指定分区规则

**MYSQL的分区字段，必须包含在主键字段内。**

### 水平分区的几种模式：

* Range（范围） – 这种模式允许DBA将数据划分不同范围。例如DBA可以将一个表通过年份划分成三个分区，80年代（1980's）的数据，90年代（1990's）的数据以及任何在2000年（包括2000年）后的数据。 

* Hash（哈希） – 这中模式允许DBA通过对表的一个或多个列的Hash Key进行计算，最后通过这个Hash码不同数值对应的数据区域进行分区，。例如DBA可以建立一个对表主键进行分区的表。 

* Key（键值） – 上面Hash模式的一种延伸，这里的Hash Key是MySQL系统产生的。 

* List（预定义列表） – 这种模式允许系统通过DBA定义的列表的值所对应的行数据进行分割。例如：DBA建立了一个横跨三个分区的表，分别根据2004年2005年和2006年值所对应的数据。 

* Composite（复合模式） - 很神秘吧，哈哈，其实是以上模式的组合使用而已，就不解释了。举例：在初始化已经进行了Range范围分区的表上，我们可以对其中一个分区再进行hash哈希分区。



- 利用范围分区
>  create table goods (
>  id int,
>  uname char(10)
>  )engine myisam
>  partition by range(id) (
>  partition p1 values less than (10),
>  partition p2 values less than (20),
>  partition p3 values less than MAXVALUE


CREATE TABLE part_tab ( c1 int default NULL, c2 varchar(30) default NULL, c3 date default NULL) engine=myisam   
PARTITION BY RANGE (year(c3)) (PARTITION p0 VALUES LESS THAN (1995),  
PARTITION p1 VALUES LESS THAN (1996) , PARTITION p2 VALUES LESS THAN (1997) ,  
PARTITION p3 VALUES LESS THAN (1998) , PARTITION p4 VALUES LESS THAN (1999) ,  
PARTITION p5 VALUES LESS THAN (2000) , PARTITION p6 VALUES LESS THAN (2001) ,  
PARTITION p7 VALUES LESS THAN (2002) , PARTITION p8 VALUES LESS THAN (2003) ,  
PARTITION p9 VALUES LESS THAN (2004) , PARTITION p10 VALUES LESS THAN (2010),  
PARTITION p11 VALUES LESS THAN MAXVALUE );  


- 按散点值分区
> create table user (
> uid int,
> pid int,
> uname 
> )engine myisam
> partition by list(pid) (
> partition bj values in (1),
> partition ah values in (2),
> partition xb values in (4,5,6)

## 分区管理
= 分区管理 =

* 删除分区  
	当删除了一个分区，也同时删除了该分区中所有的数据。


> ALTER TABLE `goods` DROP PARTITION p1, p2, p3 ;    
 
* 新增分区   
>  ALTER TABLE sale_data ADD PARTITION (PARTITION p201010 VALUES LESS THAN (201011));


[sql] view plain copy
ALTER TABLE category ADD PARTITION (PARTITION p4 VALUES IN (16,17,18,19)  
           DATA DIRECTORY = '/data8/data'  
           INDEX DIRECTORY = '/data9/idx');  

### 注意点 ###
默认分区限制分区字段必须是主键（PRIMARY KEY)的一部分，为了去除此
报错
A PRIMARY KEY must include all columns in the table's partitioning function

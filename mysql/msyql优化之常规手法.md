##mysql字段选择
- 字段类型优先级
整型 > date,time > enum,char>varchar > blob  
	尽可能整形保存如  时间  strtotime  ip   ip2long 
	在枚举的字段使用最小整形 tiny 
	
列的特点分析:
整型: 定长,没有国家/地区之分,没有字符集的差异

time定长,运算快,节省空间. 考虑时区,写sql时不方便 where > ‘2005-10-12’;

enum: 能起来约束值的目的, 内部用整型来存储,但与char联查时,内部要经历串与值的转化

Char 定长, 考虑字符集和(排序)校对集

varchar, 不定长 要考虑字符集的转换与排序时的校对集,速度慢

**text/Blob 无法使用内存临时表**

- 够用就行
- 尽量避免null

## 索引
### 索引类型 ###
1. B-tree索引  
	排好序的，快速查找结构
2.  hash索引  
	所谓Hash索引，当我们要给某张表某列增加索引时，将这张表的这一列进行哈希算法计算，得到哈希值，排序在哈希数组上。所以Hash索引可以一次定位，其效率很高，而Btree索引需要经过多次的磁盘IO
缺点：
1、因为Hash索引比较的是经过Hash计算的值，所以只能进行等式比较，不能用于范围查询     
1、每次都要全表扫描   
2、由于哈希值是按照顺序排列的，但是哈希值映射的真正数据在哈希表中就不一定按照顺序排列，所以无法利用Hash索引来加速任何排序操作  
3、不能用部分索引键来搜索，因为组合索引在计算哈希值的时候是一起计算的。   
4、当哈希值大量重复且数据量非常大时，其检索效率并没有Btree索引高的。  

**不能范围， 全表，无排序  算得快，可是取得慢**

### 多列索引使用 ###
多列索引上,索引发挥作用,需要满足左前缀要求.

### 聚簇索引与非聚簇索引 ###
- innodb的主索引文件上 直接存放该行数据,称为聚簇索引,次索引指向对主键的引用
- 注意: innodb来说, 
1: 主键索引 既存储索引值,又在叶子中存储行的数据  
2: 如果没有主键, 则会Unique key做主键   
3: 如果没有unique,则系统生成一个内部的rowid做主键.   
4: 像innodb中,主键的索引结构中,既存储了主键值,又存储了行数据,这种结构称为”聚簇索引”   

- myisam中, 主索引和次索引,都指向物理行(磁盘位置).
优势: 根据主键查询条目比较少时,不用回行(数据就在主键节点下)
劣势: 如果碰到不规则数据插入时,造成频繁的页分裂.

###高性能索引策略

1. 对于innodb的主键,尽量用整型,而且是递增的整型.  
如果是无规律的数据,将会产生的页的分裂,影响速度.

2. 索引覆盖:
索引覆盖是指 如果查询的列恰好是索引的一部分,那么查询只需要在索引文件上进行,不需要回行到磁盘再找数据.  
这种查询速度非常快,称为”索引覆盖”

	理想的索引
**1:查询频繁 2:区分度高  3:长度小  4: 尽量能覆盖常用查询字段.**

3. 索引长度，区分度  是一个矛盾
	索引长度直接影响索引文件的大小,影响增删改的速度,并间接影响查询速度(占用内存多).
	
	惯用手法: 截取不同长度,并测试其区分度,
	
	mysql> select count(distinct left(word,6))/count(*) from dict; 
	对于一般的系统应用: 区别度能达到0.1,索引的性能就可以接受.
	
	ALTER TABLE `article`
	DROP INDEX `title`,
	ADD INDEX `title` (`title`(20)) USING BTREE ;

4. 对于左前缀不易区分的列 ,建立索引的技巧  
	如 url列
	http://www.baidu.com
	http://www.zixue.it
	列的前11个字符都是一样的,不易区分, 可以用如下2个办法来解决
	1: 把列内容倒过来存储,并建立索引 
	Moc.udiab.www//:ptth
	Ti.euxiz.www//://ptth
	这样左前缀区分度大,
	
	2: 伪hash索引效果  
	同时存 url_hash列   用crc32 函数的为哈希列；
	白字符串的列转成整形  提高查询效率  

5. 大量索引的分页
	连续的表   用id
	使用逻辑删除  不用物理删除
	延迟索引   先把id查询出来
	
	select a.* from it_area as a inner join (select id from it_area where name like '%东山%') as t on a.id=t.id;
6. 索引与排序
	取出来的数据本身就是有序的! 利用索引来排序.


7. 重复索引与冗余索引
	重复索引: 是指 在同1个列(如age), 或者 顺序相同的几个列(age,school), 建立了多个索引,
	称为重复索引, 重复索引没有任何帮助,只会增大索引文件,拖慢更新速度, 去掉.

8. 冗余索引:
	冗余索引是指2个索引所覆盖的列有重叠, 称为冗余索引
	比如 x,m,列   , 加索引  index x(x),  index xm(x,m)
	x,xm索引, 两者的x列重叠了,  这种情况,称为冗余索引.
	
	甚至可以把 index mx(m,x) 索引也建立, mx, xm 也不是重复的,因为列的顺序不一样.

##索引碎片与维护
	optimize table 表名 ,也可以修复.

##sql语句优化
### explain的列分析
- id 代表select 语句的编号, 如果是连接查询,表之间是平等关系, select 编号都是1,从1开始. 如果某select中有子查询,则编号递增.
- select_type: 查询类型
	simple  
	primary  含子查询或派生查询 
	subquery
	derived
	union
	union result
- table: 查询针对的表
	实际的表名  如select * from t1;
	表的别名    如 select * from t2 as tmp;
	derived      如from型子查询时
	null         直接计算得结果,不用走表
- possible_key: 可能用到的索引
	注意: 系统估计可能用的几个索引,但最终,只能用1个.
- key : 最终用的索引.
- key_len: 使用的索引的最大长度
- type列: 
	是指查询的方式, 非常重要,是分析”查数据过程”的重要依据
	可能的值：   
	all:  意味着从表的第1行,往后,逐行做全表扫描.,运气不好扫描到最后一行.  
	index_all：     
	range: 意思是查询时,能根据索引做范围的扫描    
	ref  意思是指 通过索引列,可以直接引用到某些数据行  
	eq_ref 是指,通过索引列,直接引用某1行数据  
	const, system, null  这3个分别指查询优化到常量级别, 甚至不需要查找时间.
- extra: 
	index: 是指用到了索引覆盖,效率非常高
	using where 是指光靠索引定位不了,还得where判断一下 
	using temporary 是指用上了临时表, group by 与order by 不同列时,或group by ,order by 别的表的列.
	using filesort : 文件排序(文件可能在磁盘,也可能在内存), (????? 
	
	select sum(shop_price) from  goods group by cat_id(????  这句话,用到了临时表和文件排序) 
	 
	in 型子查询引出的陷阱

## 技巧介绍
- min/max优化   在主键上效率非常高
- count() 优化   不带where 条件  才会快
- limit 及翻页优化
	效率较低,当offset越大时,效率越低





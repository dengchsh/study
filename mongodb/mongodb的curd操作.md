1: mongo入门命令

1.1: show dbs  查看当前的数据库
1.2 use databaseName 选库
1.2 show tables/collections 查看当前库下的collection

1.3 如何创建库?
Mongodb的库是隐式创建,你可以use 一个不存在的库
然后在该库下创建collection,即可创建库

1.4 db.createCollection(‘collectionName’)  
创建collection

1.5 collection允许隐式创建
Db.collectionName.insert(document);

1.6 db.collectionName.drop() ,
删除collection

1.7 db.dropDatabase();
删除database


- 插入
1:插入单条记录,不指定主键
db.collectionName.insert({name:'lisi',age:28});

2: 插入单条记录,指定主键
db.collctionName.insert({_id:3,name:'lisi',age:28});

3: 插入多条记录
db.collctionName.insert([
{_id:4,name:'wangwu',age:60}
]);





- 删:remove  
db.stu.remove({sn:’001’});

删除stu表中gender属性为m的文档,只删除1行.
例2: db.stu.remove({gender:’m’,true});
删除stu表中gender属性为m的文档,只删除1行.

- update操作
db.news.update({name:'QQ'},{name:'MSN'});  
**新文档直接退换了旧的文档**

- $set

如果是想修改文档的某列,可以用$set关键字
db.collectionName.update(query,{$set:{name:’QQ’}})

- $set  修改某列的值
- $unset 删除某个列
- $rename 重命名某个列
- $inc 增长某个列
- $setOnInsert 当upsert为true时,并且发生了insert操作时,可以补充的字段.
- multi: 是指修改多行(即使查询表达式命中多行,默认也只改1行,如果想改多行,可以用此选项)

## 查询表达式 ##


	{filed:value} ,是指查询field列的值为value的文档
	{field:{$ne:value}}

	db.goods.find(
	{$and:[{shop_price:{$gt:100}},{shop_price:{$lt:500}}]},{}
	)

	db.goods.find(
	{$nor:[{cat_id:3},{cat_id:3}]}
	)
	
	db.goods.find(
	{goods_id:{$mod:[5,0]}}
	)
	
	db.goods.find(
	{cat_id:{$exists:1}}
	)

	{$all:['a','b','c']}

- $where  $regex  不推荐使用效率不高

	db.goods.find(
	{$where:'this.shop_price>0 && this.shop_price<200'},{goods_id:1,shop_price:1}
	)

	db.goods.find(
	{goods_name:{$regex:/诺基亚N/}}
	)


## 排序 ##

>db.COLLECTION_NAME.find().sort({KEY:1})
## 聚合 ##  ？？？ 






##游标操作   cursor
	var cursor =  db.collectioName.find(query,projection);
	Cursor.hasNext() ,判断游标是否已经取到尽头
	Cursor. Next() , 取出游标的下1个单元

	myc = db.bar.find()
	myc.forEach(function(obj){
	    print(obj._id)})

- 分页的使用

	如 var mycursor = db.bar.find().skip(9995);
	则是查询结果中,跳过前9995行
	
	查询第901页,每页10条
	则是 var mytcursor = db.bar.find().skip(9000).limit(10);




	通过cursor一次性得到所有数据, 并返回数组.
	例:
	>var cursor = db.goods.find();
	> printjson(cursor.toArray());  //看到所有行
	> printjson(cursor.toArray()[2]);  //看到第2行
	
	注意: 不要随意使用toArray()
	原因: 会把所有的行立即以对象形式组织在内存里.
	可以在取出少数几行时,用此功能.


## 索引 ##

1:索引提高查询速度,降低写入速度,权衡常用的查询字段,不必在太多列上建索引
2. 在mongodb中,索引可以按字段升序/降序来创建,便于排序
3. 默认是用btree来组织索引文件,2.4版本以后,也允许建立hash索引.


查看查询计划
db.find(query).explain();

"cursor" : "BasicCursor", ----说明没有索引发挥作用
"nscannedObjects" : 1000 ---理论上要扫描多少行
cursor" : "BtreeCursor sn_1", 用到的btree索引


- 查看当前索引状态:       
    	db.collection.getIndexes();

-  创建普通的单列索引:    

	db.collection.ensureIndex({field:1/-1});  1是升续 -1是降续


- 删除单个索引

	db.collection.dropIndex({filed:1/-1});

- 删除所有索引

	db.collection.dropIndexes();

- 创建多列索引 

 	db.collection.ensureIndex({field1:1/-1, field2:1/-1});


子文档查询是用. 找到子属性

- 创建子文档索引    
	db.collection.ensureIndex({filed.subfield:1/-1});


## mongodb 导入导出 ##

2: mongoexport 导出json格式的文件
问: 导出哪个库,哪张表,哪几列,哪几行?

	-d  库名
	-c  表名
	-f  field1,field2...列名
	-q  查询条件
	-o  导出的文件名
	-- csv  导出csv格式(便于和传统数据库交换数据)
	./mongoexport -d shop -c goods -o goods.json


例2: 只导出goods_id,goods_name列
	./bin/mongoexport -d test -c goods -f goods_id,goods_name -o goods.json

例3: 只导出价格低于1000元的行
	./bin/mongoexport -d test -c goods -f goods_id,goods_name,shop_price -q ‘{shop_price:{$lt:200}}’ -o goods.json

注: _id列总是导出


Mongoimport 导入
	
	-d 待导入的数据库
	-c 待导入的表(不存在会自己创建)
	--type  csv/json(默认)
	--file 备份文件路径

例1: 导入json
	./bin/mongoimport -d test -c goods --file ./goodsall.json

例2: 导入csv
	./bin/mongoimport -d test -c goods --type csv -f goods_id,goods_name --file ./goodsall.csv 

	./bin/mongoimport -d test -c goods --type csv --headline -f goods_id,goods_name --file ./goodsall.csv 


mongodump 导出二进制bson结构的数据及其索引信息
	-d  库名
	-c  表名
	-f  field1,field2...列名

例: 
mongodum -d test  [-c 表名]  默认是导出到mongo下的dump目录


mongorestore 导入二进制文件
例:
	 ./bin/mongorestore -d test --directoryperdb dump/test/ (mongodump时的备份目录)

二进制备份,不仅可以备份数据,还可以备份索引, 
备份数据比较小.

## mongodb的用户管理 ##
- 牵涉到服务器配置层面的操作,需要先切换到admin    
- mongo的用户是以数据库为单位来建立的, 每个数据库有自己的管理员.
 db.addUser("java","java");

查看内置角色
	db 。runCommand （
	    { 
	      rolesInfo ： 1 ，
	      showBuiltinRoles ： true 
	    } 
	）
官方手册
https://docs.mongodb.com/manual/reference/command/rolesInfo/#dbcmd.rolesInfo

查看数据库的所有用户定义角色
db 。runCommand （
    { 
      rolesInfo ： 1 ，
      showPrivileges ： true 
    } 
）


 查看一下所有的用户 ， 查看当前Db的用户名
db.system.users.find();

	db.createUser({
	createUser:'shop',
	pwd:'123456',
	roles:[{role:'readWrite',db:'shop'}]
	})



https://docs.mongodb.com/manual/reference/command/nav-user-management/


createUser	创建一个新的用户。
dropAllUsersFromDatabase	删除与数据库关联的所有用户。
dropUser	删除一个用户。
grantRolesToUser	将角色及其权限授予用户。
revokeRolesFromUser	删除用户的角色。
updateUser	更新用户的数据。
usersInfo	返回有关指定用户的信息。

db.runCommand({usersInfo:{user:'shop',db:'shop'},showPrivileges: true})


replication set复制集


## 监控 ##
- mongostat


	inserts 每秒插入
	query 每秒查询
	update 每秒更新
	delete 每秒删除
	getmore 每秒查询游标
	command 每秒总命令
	flushes 每秒同步次数
	mapped mmap内存大小(M)
	size 虚拟内存(M)
	res 物理内存(M)
	faults 取内存页面失败次数(要去swap调)
	locked db 锁住某库的时间
	idx miss 索引未命中率
	qr 队列里读取命令
	qw 队列里写入命令

- mongotop





地理索引
2dsphere 索引只能支持球面几何，而 2d索引同时支持平面和球面几何。

$near（GeoJSON点，2dsphere索引）	球面	
$near（传统坐标，2d索引）	平面	
$nearSphere（GeoJSON点，2dsphere索引）	球面	
$nearSphere（传统坐标，2d索引）	球面	使用GeoJSON点替换
$geoWithin:{$geometry:...}	球面	
$geoWithin:{$box:...}	平面	
$geoWithin:{$polygon:...}	平面	
$geoWithin:{$center:...}	平面	
$geoWithin:{$centerSphere:...}	球面	
$geoIntersects	球面

## replication set复制集

多台服务器维护相同的副本，提高服务器的可用性

- 声明同一个复制集
	./bin/mongod --port 27017 --dbpath /data/r0 --smallfiles --replSet rsa --fork --logpath /var/log/mongo17.log
	./bin/mongod --port 27018 --dbpath /data/r1 --smallfiles --replSet rsa --fork --logpath /var/log/mongo18.log
	./bin/mongod --port 27019 --dbpath /data/r2 --smallfiles --replSet rsa --fork --logpath /var/log/mongo19.log
- 配置文件

var rsconf ={
_id:'rs2',
members:[
{_id:0,host:'192.168.0.108:27017'},
{_id:1,host:'192.168.0.108:27018'},
{_id:2,host:'192.168.0.108:27019'}
]
}
- 初始化
rs.initiate(rsconf);

形成一个复制集
在复制中查看出现
not master and slaveOk=false


rsa:SECONDARY> show tables;
Sat Aug 17 16:03:55.786 JavaScript execution failed: error: { "$err" : "not master and slaveOk=false", "code" : 13435 } 

8.1 出现上述错误,是因为slave默认不许读写 只是保持通讯
>rs.slaveOk();
>show tables

关
switched to db admin
db.shutdownServer()

主动把 27018变为PRIMARY



## 分片 shard ##


## 58军规 ##
### 基本军规 ###
1. 必须使用Indob
2. 使用utf8
3. 必须加注释
4. 禁止使用触发器 过程 视图
### 命名规范 ###
业务：XXX
线上：dj.XXX.db
开发:dj.XXX.rdb
ceshi :dj.XXX.tdb
### 字段设计 ###
1. 禁止使用TEXT  BLOB
2. 禁止使用小数存货币  使用分作为单位
3. 禁止使用enum  使用tinyint代替
### 查询 ###
4. 禁止负向查询   会导致全表搜
5. 禁止使用or
6. 禁止使用jion  子查询
6. 查询的使用与索引的类型一样
	select * from phone=13265986565
	select * from phone='13265986565'
### 账号权限划分 ###

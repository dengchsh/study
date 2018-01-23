###key设计
1. 把表明当成前置  如 tag： book:
2. 第二段放用于区分key的字段  对应主键的列明 如 user_id:
3. 第三段放主键的值
4. 第四段放要存储的列名称
user:user_id:9:user_name lisi
user:user_id:9:age  18
user:user_id:9:sex 1
user:user_id:9:password 111111

好处  避免无底洞效应
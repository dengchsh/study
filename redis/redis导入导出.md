redis-dump导出导入数据
安装redis-dump

[sudo] npm install redis-dump -g
导出数据

redis-dump -h 172.17.6.150 -d 0 > db.txt
导入数据

cat db.txt | redis-cli -n 0
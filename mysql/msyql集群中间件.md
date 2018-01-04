mysql_proxy
启动
./mysql-proxy -P 192.168.0.150:4040 --proxy-backend-addresses=192.168.1.149:3306 --proxy-backend-addresses=192.168.1.113:3306

链接
mysql -h192.168.0.159  -u root -p -P 4040

加个读写分离的分析
./bin/mysql-proxy  \
--proxy-backend-addresses=192.168.1.199:3306 \
--proxy-read-only-backend-addresses=192.168.1.200:3306 \
--proxy-lua-script=/usr/local/mysql-proxy/share/doc/mysql-proxy/rw-splitting.lua

简写:
./bin/mysql-proxy -b=192.168.0.199:3306 -r=192.168.0.200:3306 -s=/usr/local/mysql-proxy/share/doc/mysql-proxy/rw-splitting.lua  
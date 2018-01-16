linux下yum安装redis以及使用
1、yum install redis      --查看是否有redis   yum 源

2、yum install epel-release    --下载fedora的epel仓库

3、 yum install redis    -- 安装redis数据库

4、service redis start  Redirecting to /bin/systemctl start redis.service   --开启redis服务

　　redis-server /etc/redis.conf   --开启方式二

5、ps -ef | grep redis   -- 查看redis是否开启

6、redis-cli       -- 进入redis服务

7、redis-cli  shutdown      --关闭服务

8、开放端口6379、6380的防火墙

/sbin/iptables -I INPUT -p tcp --dport 6379  -j ACCEPT   开启6379

/sbin/iptables -I INPUT -p tcp --dport 6380 -j ACCEPT  开启6380

 /etc/rc.d/init.d/iptables save                           保存

9、使用redis  desktop manager连接redis
## 安装 ##
到官网下载最新的稳定版本
http://nginx.org/download/nginx-1.4.2.tar.gz



    yum -y install gcc gcc-c++ autoconf automake make
安装准备: nginx依赖于pcre库,要先安装pcre





    yum install pcre pcre-devel
     cd /usr/local/src/
     wget http://nginx.org/download/nginx-1.4.2.tar.gz
    tar zxvf nginx-1.4.2.tar.gz 
    cd nginx-1.4.2
    ./configure --prefix=/usr/local/nginx
    make && make install



the HTTP gzip module requires the zlib library
yum install -y zlib-deve
- 



cd /ulsr/local/nginx, 看到如下4个目录
./ 
 ....conf 配置文件     
 ... html 网页文件    
 ...logs  日志文件    
 ...sbin  主要二进制程序   



    

**如果80端口被站口  启动不了  把占用80端口的软件或服务关闭即可.**

### 认识信号量 ###

Kill -信号选项 nginx的主进程号
Kill -HUP 4873

Kill -信号控制 `cat /xxx/path/log/nginx.pid`

Kil; -USR1 `cat /xxx/path/log/nginx.pid`


**USR1   重读日志,在日志按月/日分割时有用**

### 配置 ###


Nginx配置段

// 全局区
worker_processes 1; // 有1个工作的子进程,可以自行修改,但太大无益,因为要争夺CPU,一般设置为 CPU数*核数

Event {
// 一般是配置nginx连接的特性
// 如1个word能同时允许多少连接
 worker_connections  1024; // 这是指 一个子进程最大允许连1024个连接
}

http { 
 //这是配置http服务器的主要段
     Server1 { // 这是虚拟主机段
       
            Location {  //定位,把特殊的路径或文件再次定位 ,如image目录单独处理
            }             /// 如.php单独处理

     }

     Server2 {
     }
}
### 日志管理 ###

	access_log  logs/host.access.log  main;
使用的格式”main”格式.
除了main格式,你可以自定义其他格式.

main格式是什么?

	log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
	    #                  '$status $body_bytes_sent "$http_referer" '
	    #                  '"$http_user_agent" "$http_x_forwarded_for"';
#### 虚拟机日志 ####

Nginx允许针对不同的server做不同的Log ,(有的web服务器不支持,如lighttp)

在server段中 

access_log logs/access_8080.log mylog;   
声明log   log位置          log格式;

	#!/bin/bash
	base_path='/usr/local/nginx/logs'
	log_path=$(date -d yesterday +"%Y%m")
	day=$(date -d yesterday +"%d")
	mkdir -p $base_path/$log_path
	mv $base_path/access.log $base_path/$log_path/access_$day.log
	#echo $base_path/$log_path/access_$day.log
	kill -USR1 `cat /usr/local/nginx/logs/nginx.pid`

### location语法 ###

location = patt {} [精准匹配]
location patt{}  [一般匹配]
location ~ patt{} [正则匹配]
优先级
精准   有 则停止匹配
一般和正则    正则发挥作用
正则表达式的成果将会使用.

###rewrite 重写
    if  (条件) {}  设定条件,再进行重写 
    set #设置变量
    return #返回状态码 
    break #跳出rewrite
    rewrite #重写

#### 条件的写法 ####
1: “=”来判断相等, 用于字符串比较   
2: “~” 用正则来匹配(此处的正则区分大小写)   
   ~* 不区分大小写的正则   
3: -f -d -e来判断是否为文件,为目录,是否存在.     

	if  ($remote_addr = 192.168.1.100) {
	                return 403;
	            }
	
	
	 if ($http_user_agent ~ MSIE) {
	                rewrite ^.*$ /ie.htm;
	                break; #(不break会循环重定向)
	 }
	
     if (!-e $document_root$fastcgi_script_name) {
        rewrite ^.*$ /404.html break;
    } 
提示: 服务器内部的rewrite和302跳转不一样. 
**跳转的话URL都变了,变成重新http请求404.html**, 而内部rewrite, 上下文没变,
就是说 fastcgi_script_name 仍然是 dsafsd.html,因此 会循环重定向.

set 是设置变量用的, 可以用来达到多条件判断时作标志用.

if ($http_user_agent ~* msie) {
                set $isie 1;
            }

            if ($fastcgi_script_name = ie.html) {
                set $isie 0;
            }

            if ($isie 1) {
                rewrite ^.*$ ie.html;
            }
#### Rewrite语法

Rewrite 正则表达式  定向后的位置 模式


	location /ecshop {
	index index.php;
	rewrite goods-([\d]+)\.html$ /ecshop/goods.php?id=$1;
	rewrite article-([\d]+)\.html$ /ecshop/article.php?id=$1;
	rewrite category-(\d+)-b(\d+)\.html /ecshop/category.php?id=$1&brand=$2;
	
	rewrite category-(\d+)-b(\d+)-min(\d+)-max(\d+)-attr([\d\.]+)\.html /ecshop/category.php?id=$1&brand=$2&price_min=$3&price_max=$4&filter_attr=$5;
	
	rewrite category-(\d+)-b(\d+)-min(\d+)-max(\d+)-attr([\d+\.])-(\d+)-([^-]+)-([^-]+)\.html /ecshop/category.php?id=$1&brand=$2&price_min=$3&price_max=$4&filter_attr=$5&page=$6&sort=$7&order=$8;
	}



nginx 加php
	
	location ~ \.php$ {
	            root html;
	            fastcgi_pass   127.0.0.1:9000;
	            fastcgi_index  index.php;
	            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
	            include        fastcgi_params;
	
	        }

1:碰到php文件,  
2: 把根目录定位到 html,  
3: 把请求上下文转交给9000端口PHP进程,   
4: 并告诉PHP进程,当前的脚本是 $document_root$fastcgi_scriptname    


注意

"Primary script unknown" while reading response header from upstream, client: 192.168.29.1, server: localhost, request: "GET /index.php HTTP/1.1"
解决：
fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

#fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;


### 压缩 ###


gzip配置的常用参数
gzip on|off;  #是否开启gzip
gzip_buffers 32 4K| 16 8K #缓冲(压缩在内存中缓冲几块? 每块多大?)
gzip_comp_level [1-9] #推荐6 压缩级别(级别越高,压的越小,越浪费CPU计算资源)
gzip_disable #正则匹配UA 什么样的Uri不进行gzip
gzip_min_length 200 # 开始压缩的最小长度(再小就不要压缩了,意义不在)
gzip_http_version 1.0|1.1 # 开始压缩的http协议版本(可以不设置,目前几乎全是1.1协议)
gzip_proxied          # 设置请求者代理服务器,该如何缓存内容
gzip_types text/plain  application/xml # 对哪些类型的文件用压缩 如txt,xml,html ,css
gzip_vary on|off  # 是否传输gzip压缩标志

#### 常规压缩配置 ####
gzip on|off
gzip_buffers 4K|8K 缓冲(和硬盘块相当)
gzip_comp_level [1-9] 推荐6
gzip_disable 正则匹配如User-Agent,针对古老浏览器不压缩
gzip_min_length 200
gzip_http_version 1.0|1.1
gzip_types text/plain , application/xml (各mime之间,一定要加空格,不是逗号)
gzip_vary on|off

MIME 类型
MIME (Multipurpose Internet Mail Extensions) 是描述消息内容类型的因特网标准。
MIME 消息能包含文本、图像、音频、视频以及其他应用程序专用的数据。




### nginx的缓存设置

在location或if段里,来写.
	格式  expires 30s;
	      expires 30m;
	      expires 2h;
	      expires 30d;
如静态html,js,css,比较适于用这个方式


### nginx反向代理服务器+负载均衡


#### Nginx反向代理设置
把图片重写到 8080端口(既然能写到8080端口,就意味着可以写到其他独立服务器上)
    location ~ \.(jpg|jpeg|png|gif)$ {
            proxy_pass http://192.168.1.204:8080;
            expires 1d;
    }


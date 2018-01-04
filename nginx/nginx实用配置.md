##目录显示文件
如果要显示/html/目录下所有的文件，需要打开目录文件列表显示；

在nginx.conf主配置文件中http或location代码段中，配置一段代码即可实现；
> 	http{
> 	autoindex on;
> 	
> 	autoindex_exact_size off;
> 	
> 	autoindex_localtime on;


autoindex on; 自动显示目录

autoindex_exact_size off;

默认为on，显示出文件的确切大小，单位是bytes。

改为off后，显示出文件的大概大小，单位是kB或者MB或者GB

autoindex_localtime on;

默认为off，显示的文件时间为GMT时间。

改为on后，显示的文件时间为文件的服务器时间

autoindex_exact_size on; 打开显示文件的实际大小，单位是bytes； 

## 域名绑定##

    server{
      listen 188;
      server_name 3w.dcs163.com;
      location / {
        autoindex on;
          root /data/163dcs;
          index index.html;
      }
  }
#代理服务#
    server{
      listen 188;
      server_name 3w.dcs163.com;
      location / {
    autoindex on;
      root /data/163dcs;
      index index.html;
      }
      }
    
图片服务器

        location ~ \.(jpg|jpeg|png|gif)$ {
                proxy_pass http://192.168.1.204:8080;
                expires 1d;
        }



#负载均衡#
	upstream a.com { 
	      server  192.168.5.126:80; 
	      server  192.168.5.27:80; 
	} 
	  
	server{ 
	    listen 80; 
	    server_name a.com; 
	    location / { 
	        proxy_pass        http://a.com; 
	        proxy_set_header  Host            $host; 
	        proxy_set_header  X-Real-IP        $remote_addr; 
	        proxy_set_header  X-Forwarded-For  $proxy_add_x_forwarded_for; 
	    } 
	}
    weight（权重）

    指定轮询几率，weight和访问比率成正比，用于后端服务器性能不均的情况。如下所示，10.0.0.88的访问比率要比10.0.0.77的访问比率高一倍。

upstream linuxidc{ 
      server 10.0.0.77 weight=5; 
      server 10.0.0.88 weight=10; 
}

### ip_hash（访问ip）

    每个请求按访问ip的hash结果分配，这样每个访客固定访问一个后端服务器，可以解决session的问题。

	upstream favresin{ 
	      ip_hash; 
	      server 10.0.0.10:8080; 
	      server 10.0.0.11:8080; 
	}
### fair（第三方）

    按后端服务器的响应时间来分配请求，响应时间短的优先分配。与weight分配策略类似。

	 upstream favresin{      
	      server 10.0.0.10:8080; 
	      server 10.0.0.11:8080; 
	      fair; 
	}

### url_hash（第三方）

按访问url的hash结果来分配请求，使每个url定向到同一个后端服务器，后端服务器为缓存时比较有效。

注意：在upstream中加入hash语句，server语句中不能写入weight等其他的参数，hash_method是使用的hash算法。

	 upstream resinserver{ 
	      server 10.0.0.10:7777; 
	      server 10.0.0.11:8888; 
	      hash $request_uri; 
	      hash_method crc32; 
	}

###ngingx+php

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


	location ~ \.php$ {
	        root          /home/cdai/test.com;
	        include         fastcgi_params;
	        fastcgi_connect_timeout   180;
	        fastcgi_read_timeout      600;
	        fastcgi_send_timeout      600;
	        fastcgi_pass      unix:/dev/shm/php-fcgi.sock;
	        fastcgi_index      index.php;
	        fastcgi_param     SCRIPT_FILENAME /home/cdai/test.com$fastcgi_script_name;
	   }
以Nginx超时时间为90秒，PHP-FPM超时时间为300秒为例，



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
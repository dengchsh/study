## 安装 ##
下载安装     
	http://www.ffmpeg.org/releases/ffmpeg-3.4.1.tar.bz2


yasm时，就会报上面错误。
解决：安装yasm编译器。安装方法如下：
在http://www.tortall.net/projects/yasm/releases下面找到适合自己平台的yasm版本。然后进行安装。举例如下：     
> 	1）下载：wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz
> 	2）解压：tar zxvf yasm-1.3.0.tar.gz
> 	3）切换路径： cd yasm-1.3.0
> 	4）执行配置： ./configure
> 	5）编译：make
> 	6）安装：make install

简单案例
http://blog.csdn.net/kingboyworld/article/details/52469765



## php调用

$com = "/usr/local/bin/ffmpeg -ss 00:00:10  -i /data/1.mp4  /data/dcs/sampledcs11122.jpg  -r 1 -vframes 1 -an -f mjpeg 2>&1";
// $com = "who";
$res = exec($com,$out);



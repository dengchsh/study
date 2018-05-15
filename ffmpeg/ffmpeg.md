## 安装 ##
- 下载安装     
	http://www.ffmpeg.org/releases/ffmpeg-3.4.1.tar.bz2
- 解压

- 



yasm时，就会报上面错误。
解决：安装yasm编译器。安装方法如下：
在http://www.tortall.net/projects/yasm/releases下面找到适合自己平台的yasm版本。然后进行安装。举例如下：     
> 	1）下载：wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz
> 	2）解压：tar zxvf yasm-1.3.0.tar.gz
> 	3）切换路径： cd yasm-1.3.0
> 	4）执行配置： ./configure
> 	5）编译：make
> 	6）安装：make install







**http://blog.sina.com.cn/s/blog_61bc01360102w815.html**




简单案例
http://blog.csdn.net/kingboyworld/article/details/52469765



## php调用

$com = "/usr/local/bin/ffmpeg -ss 00:00:10  -i /data/1.mp4  /data/dcs/sampledcs11122.jpg  -r 1 -vframes 1 -an -f mjpeg 2>&1";
// $com = "who";
$res = exec($com,$out);



$ff_frame = $movie->getFrame(1);
$gd_image = $ff_frame->toGDImage();


// $img="./test.jpg";
// imagejpeg($gd_image, $img);
// imagedestroy($gd_image);


yasm/nasm not found or too old. Use --disable-yasm for a crippledbuild错误
2017年07月21日 12:04:10
阅读数：2727
安装ffmpeg过程中，执行./configure时，报yasm/nasm not found or too old. Use --disable-yasm for a crippledbuild错误，分析、解决如下：

分析：yasm是汇编编译器，ffmpeg为了提高效率使用了汇编指令，如MMX和SSE等。所以系统中未安装yasm时，就会报上面错误。

解决：安装yasm编译器。安装方法如下：

在http://www.tortall.net/projects/yasm/releases下面找到适合自己平台的yasm版本。然后进行安装。举例如下：

1）下载：wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz

2）解压：tar zxvf yasm-1.3.0.tar.gz

3）切换路径： cd yasm-1.3.0

4）执行配置： ./configure

5）编译：make

6）安装：make install





Linux 编译升级 Ffmpeg 步骤
2013年08月01日 10:22:01
阅读数：11531
        如果服务器已经安装了一个 Ffmpeg 的话，比如已安装在 /usr/local/ffmpeg 目录。版本升级步骤如下：
        1.下载 ffmpeg-*.tar.gz
        到 Ffmpeg 官网 https://ffmpeg.org/download.html 挑选你要升级到的版本，然后下载，比如作者下载的是 ffmpeg-2.0.tar.gz。
        2.编译安装
        tar -zxvf ffmpeg-2.0.tar.gz
        cd ffmpeg-2.0
        ./configure --enable-shared --prefix=/usr/local/ffmpeg
        make
        make install
        3.动态链接库
        vi /etc/ld.so.conf
        加入：/usr/local/ffmpeg/lib
        执行
        ldconfig
        4.为 Ffmpeg 加入环境变量
        vi /etc/profile
        加入以下内容:
        FFMPEG=/usr/local/ffmpeg
        PATH加入:$FFMPEG/bin
        5.使修改立即生效
        source /etc/profile
        执行 
        ffmpeg -version
        打印结果
ffmpeg version 2.0
built on Jul 24 2013 09:59:06 with gcc 4.4.7 (GCC) 20120313 (Red Hat 4.4.7-3)
configuration: --enable-shared --prefix=/usr/local/ffmpeg
libavutil      52. 38.100 / 52. 38.100
libavcodec     55. 18.102 / 55. 18.102
libavformat    55. 12.100 / 55. 12.100
libavdevice    55.  3.100 / 55.  3.100
libavfilter     3. 79.101 /  3. 79.101
libswscale      2.  3.100 /  2.  3.100
libswresample   0. 17.102 /  0. 17.102
        证明已升级成功。如果遇到 ffmpeg: error while loading shared libraries: libavdevice.so.55: cannot open shared object file: No such file or directory 之类的错误，请检查第三步是否做好。
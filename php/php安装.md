http://www.huangxiaobai.com/archives/1050

php编译安装
 ###方法一、简单安装（通过yum）
1.安装epel-release
?
1
> rpm -ivh http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
2.安装PHP7的rpm源
?
1
> rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
3.安装PHP7
?
1
yum install php70w
###方法二、编译安装
1.下载php7
?
1
> wget -O php7.tar.gz http://cn2.php.net/get/php-7.1.1.tar.gz/from/this/mirror
2.解压php7
?
1
> tar -xvf php7.tar.gz
3.进入php目录
?
1
cd php-7.0.4
4.安装依赖包
?
1
2
> yum install libxml2 libxml2-devel openssl openssl-devel bzip2 bzip2-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel gmp gmp-devel libmcrypt libmcrypt-devel readline readline-devel libxslt libxslt-devel

常见的./configure
    ./configure --prefix=/usr/local/php  --enable-fpm --with-mcrypt \
    --enable-mbstring --disable-pdo --with-curl --disable-debug  --disable-rpath \
    --enable-inline-optimization --with-bz2  --with-zlib --enable-sockets \
    --enable-sysvsem --enable-sysvshm --enable-pcntl --enable-mbregex \
    --with-mhash --enable-zip --with-pcre-regex --with-mysql --with-mysqli \
    --with-gd --with-jpeg-dir


###燕十八  
    ./configure  --prefix=/usr/local/fastphp 
    --with-mysql=mysqlnd \
    --enable-mysqlnd \
    --with-gd \
    --enable-gd-native-ttf \
    --enable-gd-jis-conv
    --enable-fpm
    
###oneinstatke

    ./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc --with-config-file-scan-dir=/usr/local/php/etc/php.d --with-apxs2=/usr/local/apache/bin/apxs --enable-opcache --disable-fileinfo --enable-mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-iconv-dir=/usr/local --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath --enable-bcmath --enable-shmop --enable-exif --enable-sysvsem --enable-inline-optimization --with-curl=/usr/local --enable-mbregex --enable-mbstring --with-gd  --with-openssl=/usr/local/openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-ftp --enable-intl --with-xsl --with-gettext --enable-zip --enable-soap --disable-debug





###http://www.huangxiaobai.com/archives/1050
    ./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/ --with-config-file-scan-dir=/usr/local/php/etc --with-openssl=/ueidc/openssl110f --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --enable-mysqlnd --enable-sockets --enable-mbstring --enable-fpm --enable-soap --enable-gd-native-ttf --enable-opcache=no --with-gettext  --with-png-dir=/ueidc/libpng162 --with-jpeg-dir=/ueidc/jpeg9 --with-zlib-dir=/ueidc/zlib128 --with-libxml-dir=/ueidc/libxml228 --with-mhash=/ueidc/mhash099 --with-curl=/ueidc/curl7531 --with-gd=/ueidc/gd210 --with-mcrypt=/ueidc/libmcrypt257 --with-freetype-dir=/ueidc/freetype254 -with-iconv-dir=/ueidc/libiconv115


#### 7.2 废弃的
configure: WARNING: unrecognized options: --with-mcrypt, --enable-gd-native-ttf

####用
    ./configure --prefix=/usr/local/php7 -with-config-file-path=/usr/local/php7/etc  -with-mysqli=mysqlnd -with-pdo-mysql=mysqlnd -with-gd -with-iconv -with-zlib -enable-xml -enable-bcmath -enable-shmop -enable-sysvsem -enable-inline-optimization -enable-mbregex -enable-fpm -enable-mbstring -enable-ftp -with-openssl -enable-pcntl -enable-sockets -with-xmlrpc -enable-zip -enable-soap -without-pear -with-gettext -enable-session -with-curl -with-jpeg-dir -with-freetype-dir -enable-opcache --with-readline






 -  报错  undefined reference to `libiconv_open

解决方法：

    #wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.13.1.tar.gz
    #tar -zxvf libiconv-1.13.1.tar.gz
    #cd libiconv-1.13.1
    # ./configure --prefix=/usr/local/libiconv
    # make
    # make install



- 安装php时的报错
    
    checking libxml2 install dir... no
    checking for xml2-config path... 
    configure: error: xml2-config not found. Please check your libxml2 installation.

 

检查是否安装了libxm包

[root@XKWB3403 php-5.3.8]# rpm -qa |grep  libxml2
libxml2-2.6.26-2.1.12
libxml2-python-2.6.26-2.1.12
重新安装libxml2和libxml2-devel包
    yum install libxml2
    
    yum install libxml2-devel -y


- 解决 Cannot find OpenSSL's <evp.h>
    yum install openssl openssl-devel
    ln -s /usr/lib64/libssl.so /usr/lib/


- curl 版本不对

	    checking for cURL in default path... found in /usr/local
	    checking for cURL 7.10.5 or greater... configure: error: cURL version 7.10.5 or later is required to compile php with cURL support

解决

	-with-curl=/usr/lib64/  

    	yum -install curl-devel


- jpeglib.h not found.   
	
		yum -y install libjpeg-devel


- configure: error: png.h not found.错误的解决方法

	    yum install libpng
	    yum install libpng-devel

- 字体库 freetype-config not found.
安装

    	https://ftp.acc.umu.se/mirror/gnu.org/savannah/freetype/freetype-2.4.0.tar.gz
    	tar  
    	configure
    	make
    	 make install


- Please reinstall readline - I cannot find readline.
GNU readline是一个开源的跨平台程序库，提供了交互式的文本编辑功能


		yum install readline*

		

make
makeinstall
复制和修改配置文件名

cp /root/php-7.2.0/php.ini-development ./php.ini

cp php-fpm.conf.default php-fpm.conf
cp www.conf.default www.conf















###网友补充

1、PHP 出现 segmentation fault 错误
现象：安装完成后出现的这个问题让我一顿网上狂搜，但都无济于事。在运行任何有关 PHP 的命令时都会返回 segmentation fault 的错误，比如：php -v 或 php -m 等。经过不断试错和排查 php.ini，最终发现是在安装完 Zend Guard Loader 之后出现的。
原因： Zend Guard Loader 的配置错误。
解决办法：将 extension = ZendGuardLoader.so 改为 zend_extension = ZendGuardLoader.so即可。
最后，我将所有可选安装的配置都单独放到 /usr/local/php/php.d 下了，而不是一股脑放到 php.ini 中，这样便于出问题时排查。

2、ICU 相关错误
现象：Unable to detect ICU prefix or /usr//bin/icu-config failed. Please verify ICU install prefix and make sure icu-config works
解决办法：yum install -y icu libicu libicu-devel
关于 ICU 的编译参数：./configure –with-icu-dir=/usr

3、bzip2 相关错误
现象：checking for BZip2 support… yes checking for BZip2 in default path… not found configure: error: Please reinstall the BZip2 distribution
解决办法：yum install -y bzip2 bzip2-devel
关于 bzip2 的编译参数：./configure –with-bz2

4、gmp 相关错误
现象：checking for bind_textdomain_codeset in -lc… yes checking for GNU MP support… yes configure: error: Unable to locate gmp.h
解决办法：yum install -y gmp-devel
关于 gmp 的编译参数：./configure –with-gmp

5、readline 相关错误
现象：configure: error: Please reinstall libedit – I cannot find readline.h
解决办法：安装 Editline Library (libedit)，官网：http://thrysoee.dk/editline/
下载最新版 libedit 编译安装即可。
关于 readline 的编译参数：./configure –with-readline

6、xsl 相关错误
现象：configure: error: xslt-config not found. Please reinstall the libxslt >= 1.1.0 distribution
解决办法：yum install -y libxslt libxslt-devel libxml2 libxml2-devel
关于 xsl 的编译参数：./configure –with-xsl

7、pcre 相关错误
现象：checking for PCRE headers location… configure: error: Could not find pcre.h in /usr
解决办法：yum install -y pcre-devel
关于 pcre 的编译参数：./configure –with-pcre-dir
备注：在 CentOS 5.x 中，pcre 的最新版本为 6.6，版本过低会导致在编译 Apache 2.4.x 的时候出现错误。因此，建议编译安装 pcre 的最新版 8.35，替换低版本的 pcre。
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
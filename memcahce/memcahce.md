### 编译 ###
1. yum install gcc make cmakmemcached 

依赖于 libevent 库,因此我们需要先安装 libevente autoconf libtool

> tar zxvf libevent-2.0.21-stable.tar.gz
> cd libevent-2.0.21-stable
> ./configure --prefix=/usr/local/libevent
> 如果出错,读报错信息,查看原因,一般是缺少库
> make && make install
> tar zxvf memcached-1.4.5.tag.gz
> cd memcached-1.4.5
> ./configure--prefix=/usr/local/memcached \
> -with-libevent=/usr/local/libevent
> make && make install
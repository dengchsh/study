http://blog.163.com/wu_thousand/blog/static/11863596220162313445024/

1、获取gcc4.8.2源码包：
wget http://gcc.skazkaforyou.com/releases/gcc-4.8.2/gcc-4.8.2.tar.gz
百度云：链接: http://pan.baidu.com/s/1pL1ltVl 密码: 5yc7

2、解压并进入解压目录：
3、./contrib/download_prerequisites
4、  mkdir gcc-build-4.8.2
	cd gcc-build-4.8.2
5、../configure --enable-checking=release --enable-languages=c,c++ --disable-multilib
6、make 此步很漫长
7、make install
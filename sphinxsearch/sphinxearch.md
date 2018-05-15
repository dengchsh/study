
http://blog.csdn.net/zhaozzeng/article/details/54882240
一、安装前提必备先安装工具

yum -y install make gcc g++ gcc-c++ libtool autoconf automake imake mysql-devel libxml2-devel expat-devel


二、安装sphinx  

1、下载sphinx
cd /usr/local/src   (默认下载文件存放位置)
wget http://sphinxsearch.com/files/sphinx-2.1.1-beta.tar.gz 

2、解压安装包
tar zxvf sphinx-2.1.1-beta.tar.gz

3、检查当前系统是否满足安装sphinx 和指定安装目录
cd sphinx-2.1.1-beta
./configure --prefix=/usr/local/sphinx

4、编译和安装sphinx
make            
make install   

5、备份配置文件
cd /usr/local/sphinx/etc
cp sphinx.conf.dist sphinx.conf

6、修改配置文件

1）、导入sphinx准备的测试数据会导入test库和两张表(确保apache mysql服务已经打开)
mysql -uroot -p</usr/local/sphinx/etc/example.sql

2）、修改sphinx配置文件
vim /usr/local/sphinx/etc/sphinx.conf
在vim下搜索    /sql_host   （告诉sphinx mysql链接信息）
        sql_host                = localhost     //服务器名
        sql_user                = root          //数据库账户
        sql_pass                = qaz5788943    //数据库密码
        sql_db                  = test          //使用sphinx 库名
        sql_port                = 3306  # optional, default is 3306

在vim下搜索   /sql_query_pre

打开下面配置的注释
  sql_query_pre          = SET NAMES utf8 

在vim下搜索 /exceptions.txt 注释下面配置
#       exceptions              = /data/exceptions.txt


7、创建测试索引文件
cd /usr/local/sphinx/bin
./indexer --all    

8、测试sphinx全文索引 搜索‘this’单词
./search this 
     
此时要报以下错误
index 'test1': search error: query too complex, not enough stack (thread_stack=1201361K or higher required).
可修改配置文件
vim /usr/local/sphinx/etc/sphinx.conf

/_info   搜索_info找到

sql_query_info          = SELECT * FROM documents WHERE id=$id
把上面配置注释掉即可
#sql_query_info          = SELECT * FROM documents WHERE id=$id



关键步骤总结：
1、连接mysql         （修改配置文件）要确保字符集为utf-8
2、创建索引           /usr/local/sphinx/bin/indexer --all    
3、使用搜索this分词   /usr/local/sphinx/bin/search this

完成以上安装后只支持英文分词 不支持中文  中英文结合搜索 所以需要进行下面中文分词安装

三、安装coreseek中文分词 （其实就是一个sphinx+中文词库）

1、下载coreseek  
wget www.coreseek.cn/uploads/csft/3.2/coreseek-3.2.14.tar.gz
或在window下手动下载再传到linux的/usr/local/src 文件夹中

2、解压文件
tar -zxvf coreseek-3.2.14.tar.gz

cd coreseek-3.2.14

认识下coreseek文件目录
ls 
csft-3.2.14     (就是sphinx)   
mmseg-3.2.14   （就是中文词库）

3、安装

（1）安装mmseg分词词典
  
   1)cd /usr/local/src/coreseek-3.2.14/mmseg-3.2.14
 
   2)测试系统是否满足安装
     ./bootstrap
   3)执行配置检测
     ./configure --prefix=/usr/local/mmseg3
   4)编译安装
   make && make install
   
   5）测试分词
   cd /usr/local/mmseg3/bin
   /usr/local/mmseg3/bin/mmseg -d /usr/local/mmseg3/etc/ /usr/local/src/coreseek-3.2.14/mmseg-3.2.14/src/t1.txt
      

（2）安装csft
   
  1)执行内置shell脚本测试是否满足安装
   cd /usr/local/src/coreseek-3.2.14/csft-3.2.14
   sh buildconf.sh
  
  2)执行配置检测
  ./configure --prefix=/usr/local/coreseek --without-unixodbc --with--mmseg --with-mmseg-includes=/usr/local/mmseg3/include/mmseg/ --with-mmseg-libs=/usr/local/mmseg3/lib/ --with-mysql
  
  
  3）执行安装
  make && make install
  
  4)修改配置文件
    a、备份配置文件
    
    cd  /usr/local/coreseek/etc
    cp sphinx.conf.dist csft.conf
    
    
    b、准备测试数据
         //创建库
         create database mysphinx charset utf8; 
         //创建表
         create table sphinx_test(id int primary key auto_increment,title varchar(255),content text,catid smallint)charset utf8; 
         //准备数据
         insert into sphinx_test（title,content,catid）values('奥运会','广州获得2028年奥运举办资格',1);
         insert into sphinx_test（title,content,catid）values('奥运会','傅园慧获得里约奥运中国队代表',1);
        
    c、修改配置文件
    vim csft.conf
    
     在vim下搜索    /sql_host   （告诉sphinx mysql链接信息）
        sql_host                = localhost     //服务器名
        sql_user                = root          //数据库账户
        sql_pass                = qaz5788943    //数据库密码
        sql_db                  = test          //使用sphinx 库名
        sql_port                = 3306  # optional, default is 3306

     在vim下搜索   /sql_query_pre
     
     打开下面配置的注释
     sql_query_pre          = SET NAMES utf8 

     在vim下搜索 /sql_query   找到下面内容在每行前面加#注释掉
      
     sql_query                              = \
     SELECT id, group_id, UNIX_TIMESTAMP(date_added) AS date_added, title, content \
                FROM documents
     
     在上面内容下面添加个人测试数据表
     SELECT id,title,content FROM sphinx_test

     搜索/charset_type 修改成:
     charset_type            = zh_cn.utf-8
     在上面内容下面加上词典目录
     charset_dictpath        = /usr/local/mmseg3/etc/
    
     /_info   搜索_info找到
      sql_query_info          = SELECT * FROM documents WHERE id=$id
     修改成:
      sql_query_info          = SELECT * FROM sphinx_test WHERE id=$id
     



     d、创建索引
       cd /usr/local/coreseek/bin
       ./indexer --all
     
     e、测试分词
       ./search 奥运



四、安装php拓展
   
  1、下载sphinx拓展
  cd /usr/local/src 
  wget http://pecl.php.net/get/sphinx-1.2.1.tgz
  2、解压
  tar -zxvf sphinx-1.3.1.tgz
  
 

  3、安装libsphinxclient支持
  cd /var/install/coreseek-4.1-beta/csft-4.1/api/libsphinxclient/
  ./configure  --prefix=/usr/local/sphinx
  make && make install
  
 
  4、安装php拓展
  cd /usr/local/src/sphinx-1.2.0
   
  /usr/local/php/bin/phpize
  ./configure --with-php-config=/usr/local/php/bin/php-config --with-sphinx

  make && make install

  5、修改php.ini配置文件
     可以在phpinfo()函数 网页搜索Configuration找到php.ini文件存放位置
       vim php.ini

       添加配置项
       extension="sphinx.so";                                                                                                             //拓展名
       extension="/usr/local/php/lib/php/extensions/no-debug-zts-20131226/sphinx.so";    //拓展文件存放位置

  6、重启apache
     /usr/local/apache2/bin/apachectl restart 
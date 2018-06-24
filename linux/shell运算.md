##缺点


- declare 声明变量类型
declare[+/-]

-a  数组
-i  整形
-x  环境变量
-r  只读
-p  显示指定变量的被声明类型

###声明为数值型

[root@localhost dcs]# movie[0]=zp
[root@localhost dcs]# movie[1]=tp
[root@localhost dcs]# declare -a movie[2]=live

echo  ${movie[*]}

declare -x test=123
declare -r 只读属性

###数值运算
expr lex 运算工具

dd=$(expr$a+$b);
$((运算式)) $[运算式]

###变量测试
。。。。
##环境变量配置文件
source 配置文件  或 .配置文件
重新加载配置文件
###简介
####全局生效
/etc/profile       
/etc/profile.d/*.sj
/etc/bashrc

####用户家目录的  用户生效
~/.bash_profile
~/.bashrc


umask
查看默认权限
文件最高权限   666
目录权限  777

**umask 定义的权限 是系统默认的要丢弃的权限**  权限是减运算


运行过程的配置文件 不见了可以去复制过来！


其他的配置文件
###~/.bash_logout
注销事生效的环境变量配置文件

退出时清空历史命令
history -c

.bash_history  
当前的不会马上写入

警告信息
只对本地登入的信息
/etc/issus

\l 终端号

对远程的欢迎信息
/etc/issus.net
/etc/ssh/sshd_config

修改 Banner  /etc/issue.net

都生效
/etc/motd
登入后显示信息

建议写成警告信息





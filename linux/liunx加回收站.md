## 认识 .bashrc ##

主要保存个人的一些个性化设置，如命令别名、路径等
>  PATH="/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin"
>  LANG=zh_CN.GBK
>  export PATH LANG
> 
>  alias rm='rm -i'
>  alias ls='/bin/ls -F --color=tty --show-control-chars'

例子中定义了路径，语言，命令别名（使用rm删除命令时总是加上-i参数需要用户确认，使用ls命令列出文件列表时加上颜色显示）。
每次修改.bashrc后，使用source ~/.bashrc（或者 . ~/.bashrc）就可以立刻加载修改后的设置，使之生效。

一般会在.bash_profile文件中显式调用.bashrc。登陆linux启动bash时首先会去读取~/.bash_profile文件，这样~/.bashrc也就得到执行了，你的个性化设置也就生效了。

代码如下:

mkdir -p ~/.trash 
vi ~/.bashrc

然后把以下代码写入~/.bashrc后，保存一下。


代码如下:

> alias rm='trash'    
> alias rl='trashlist'    
> alias ur='undelfile'    
#替换rm指令移动文件到~/.trash/中 
> trash() 
> { 
> mv $@ ~/.trash/ 
> } 
#显示回收站中垃圾清单 
> trashlist() 
> { 
> echo -e "33[32m==== Garbage Lists in ~/.trash/ ====33[0m" 
> echo -e "\a33[33m----Usage------33[0m" 
> echo -e "\a33[33m-1- Use 'cleartrash' to clear all garbages in ~/.trash!!!33[0m" 
> echo -e "\a33[33m-2- Use 'ur' to mv the file in garbages to current dir!!!33[0m" 
> ls -al ~/.trash 
> } 
#找回回收站相应文件 
> undelfile() 
> { 
> mv -i ~/.trash/$@ ./ 
> } 
#清空回收站 
> cleartrash() 
> { 
> echo -ne "\a33[33m!!!Clear all garbages in ~/.trash, Sure?[y/n]33[0m" 
> read confirm 
> if [ $confirm == 'y' -o $confirm == 'Y' ] ;then 
> /bin/rm -rf ~/.trash/* 
> /bin/rm -rf ~/.trash/.* 2>/dev/null 
> fi 
> }
> 
在命令行下面刷新一下环境配置，即可生效：


代码如下:

> source ~/.bashrc
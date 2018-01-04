#回收站设置

> vfs object = recycle  
> 
> recycle:repository = /samba/deleted/public  
> 
> recycle:keeptree = Yes  
> recycle:versions = Yes  
> recycle:maxsixe = 0  
> recycle:exclude = *.tmp|*.mp3  
> recycle:noversions = *.doc  


** 
deleted文件夹中，%U是个变量，表示用户名，比如user1删除的文件会被放入 共享目录/deleted/user1中，samba中只能用相对路径来设置回收站路径。
注意".deleted/%U"，U是大写，deleted前面有个小数点“.”，有了这个点，回收站在共享的时候会被认为是隐藏文件，所以别漏掉哈。
需要注意的是，如果你直接干掉了deleted文件夹**

### 坑点 ###
注意看你的共享的文件   家目录下删除的文件是在回收站里的
 scp mongodb-linux-x86_64-3.6.1.tgz  root@192.168.0.189:mongodb-linux-x86_64-3.6.1.tgz 

(1) 复制文件：  

命令格式：  

scp local_file remote_username@remote_ip:remote_folder  

或者  

scp local_file remote_username@remote_ip:remote_file  

或者  

scp local_file remote_ip:remote_folder  

或者  

scp local_file remote_ip:remote_file  

第1,2个指定了用户名，命令执行后需要输入用户密码，第1个仅指定了远程的目录，文件名字不变，第2个指定了文件名  

第3,4个没有指定用户名，命令执行后需要输入用户名和密码，第3个仅指定了远程的目录，文件名字不变，第4个指定了文件名   


(2) 复制目录：  

命令格式：  

scp -r local_folder remote_username@remote_ip:remote_folder  

或者  

scp -r local_folder remote_ip:remote_folder  

第1个指定了用户名，命令执行后需要输入用户密码；  

第2个没有指定用户名，命令执行后需要输入用户名和密码；
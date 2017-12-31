#!/bin/bash
while true
do
/usr/local/mysql/bin/mysql -uroot -e 'show processlist\G'|grep State|uniq|sort  -rn >> proce.txt
usleep 10000
done

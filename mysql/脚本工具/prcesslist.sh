#!/bin/bash
while true
do
mysql -uroot -e 'show processlist\G'|grep State:|uniq -c|sort -rn
echo '---'
sleep 1
Done

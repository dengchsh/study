- 当只要一行数据时使用 LIMIT 1
- 千万不要 ORDER BY RAND()   

> 	// 千万不要这样做：
> 	$r = mysql_query("SELECT username FROM user ORDER BY RAND() LIMIT 1");
> 	 
> 	// 这要会更好：
> 	$r = mysql_query("SELECT count(*) FROM user");
> 	$d = mysql_fetch_row($r);
> 	$rand = mt_rand(0,$d[0] - 1);
> 	 
> 	$r = mysql_query("SELECT username FROM user LIMIT $rand, 1");

- 避免 SELECT *
- 定期 optimize table tbl_name;
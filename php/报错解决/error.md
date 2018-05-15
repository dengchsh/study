curl: (60) SSL certificate problem: unable to get local issuer certificate 错误
　　今天同事做微信管理的项目，请求接口返回如下错误SSL certificate problem: unable to get local issuer certificate。

　　此问题的出现是由于没有配置信任的服务器HTTPS验证。默认，cURL被设为不信任任何CAs，就是说，它不信任任何服务器验证。因此，这就是浏览器无法通过HTTPs访问你服务器的原因。

　　解决此报错有2种处理方法

　　1.如果你的内容不敏感，一个快捷的方法是使用curl_exec()之前跳过ssl检查项。

　　curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
　　2.下载一个ca-bundle.crt ，放到对应的目录，在php.ini文件中配置下路径

　　https://github.com/bagder/ca-bundle/blob/e9175fec5d0c4d42de24ed6d84a06d504d5e5a09/ca-bundle.crt

　　在php.ini加入 ，重启web服务器

curl.cainfo="真实路径/ca-bundle.crt"
 
### phpunit 安装

如果要全局安装 PHAR：  
> $ wget https://phar.phpunit.de/phpunit-6.2.phar  
> $ chmod +x phpunit-6.2.phar   
> $ sudo mv phpunit-6.2.phar /usr/local/bin/phpunit    
> $ phpunit --version    
> PHPUnit x.y.z by Sebastian Bergmann and contributors.
    
也可以直接使用下载的 PHAR 文件：  
> $ wget https://phar.phpunit.de/phpunit-6.2.phar  
> $ php phpunit-6.2.phar --version   
> PHPUnit x.y.z by Sebastian Bergmann and contributors 
### 编写测试 ###

#### 测试的依赖关系
- 生产者(producer)，是能生成被测单元并将其作为返回值的测试方法
- 消费者(consumer)，是依赖于一个或多个生产者及其返回值的测试方法
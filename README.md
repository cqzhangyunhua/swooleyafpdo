## yafbase 基本框架
### 说明：yafbase 是基于之前所搭建的文件目录编辑写，未做其他的规范处理，里面有一些不需要的文件根据自己的项目情况做增加与删除，可以做为例子的参考。
### 数据库操作类在library\Db\DAOPDO.php 
## 目录结构说明
```
conf/application.ini  #具体的配置文件
public/ #公共资源目录
public/index.php #php-fpm的入口文件
public/server.php #可用于swoole的入口文件
application/controllers/Index.php  #默认Index控制器
application/library #本地类库
application/models #数据模型文件
application/modules/V1/controllers #V1版本控制器目录
application/plugins  #插件目录
application/views  #视图目录
application/Bootstrap.php  #入口Bootstrap

```
## 一、项目创建说明
### 项目创建
``` 
 composer create-project yafbase  --repository=http://packagist.i.cacf.cn/ --no-secure-http

```
### Composer 常用帮助：
```
https://blog.csdn.net/oqzuser12345678999q/article/details/107227264

```
### 二、使用说明
### 命令模式下运行
``` 例.后台命运行令行 执行方式：php index.php "request_uri=/v1/Command/ ```
### 项目初始化
``` 
    更新 composer update 
    查看镜像源 composer config -g -l repo.packagist 
    更改镜像源 可参考 https://developer.aliyun.com/mirror/

```
### 项目nginx配置 注是php study 

```
server {
        listen        84;
        server_name  localhost;
        root   "E:/project/concern/php-yaf/public";
        location / {
	if (!-e $request_filename) {
   		 rewrite ^/(.*)$ /index.php/$1 last;
	}
            index index.php index.html;
            autoindex  off;
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
}

```
### PHP-FPM访问例：

```     http://127.0.0.1/v1/test/index?q=xx ```

### 镜像地址: http://packagist.i.cacf.cn/
### ~~composer.json的配置~~
```
{
        "repositories": [{
                "type": "composer",
                "url": "http://packagist.i.cacf.cn/"
        }],
        "config": {
                "secure-http": false
        },
        "require": {
                "ab/cd": "dev-master"
        }
}

``` 

aliyun-sms
The ThinkPHP 6 Aliyun SMS

## 安装
> composer require yinxu46/aliyun-sms

## 配置

### 生成配置

系统安装后会自动在 config 目录中生成 sms.php 的配置文件，
如果系统未生成可在命令行执行

```php
php think sms:config 
```

快速生成配置文件

### 公共配置
```php
'sms'=>[
    'Domain' => 'dysmsapi.aliyuncs.com',
    'RegionId' => 'cn-hangzhou',
    'Version' => '2017-05-25',
]
```
或者在\config目录中新建`addons.php`,内容为：
```php
<?php
return [
    'Domain' => 'dysmsapi.aliyuncs.com',
    'RegionId' => 'cn-hangzhou',
    'Version' => '2017-05-25',
];
```


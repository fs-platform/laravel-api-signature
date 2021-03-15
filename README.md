## signature

- 对接口请求进行签名验证
- 本拓展满足psr2,psr4 规范
- 已通过单元测试

## 基本使用
1. 安装
```bash
$ composer require aron/signagture-verification
```

2. 发布config 文件
```bash
$ php artisan vendor:publish
```

3. config/app.php providers 添加 providers

```php
Aron\Signature\Provider::class
```
> 使用门脸内

config/app.php aliases 添加
```php
'Signature' =>  Aron\signature\Facades::class
```

4. 开始使用
```php
Signature::verifySignature('时间戳',
'随机字符串','requestBody', '签名认证key','客户端签名');
```

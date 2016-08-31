# relsoul个人主页说明
博客引用了以下互联网资源,如有侵权请联系relsoul@outlook.com
- https://dash.readme.io/login 密码登陆框

为了练习MYSQL,本项目并没有采用最佳数据查询与设计.

[预览](https://github.com/Relsoul/relsoulHomePage)




# restful返回信息与错误代码
restfulAPI返回的格式为

```
{
    type:true||false,
    message:返回成功或者错误的提示信息
    result:成功后返回的数据
    code:返回错误的提示代码
}

```

# 安装

## 克隆项目

```
git clone https://github.com/Relsoul/relsoulHomePage
```

## 安装composer

```
curl -sS https://getcomposer.org/installer | php
```

## 安装依赖
```
php composer.phar install
```

## 设置.env文件
```
DB_HOST=你的地址域名
DB_DATABASE=你的数据库名称
DB_USERNAME=数据库账号
DB_PASSWORD=数据库密码

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mail.relsoul.com(你的邮箱地址)
MAIL_PORT=25
MAIL_USERNAME=postmaster@relsoul.com(你的邮箱发件人)
MAIL_PASSWORD=你的邮箱密码
MAIL_ENCRYPTION=null
```

## 导入数据

/sql/init.sql里面有默认的数据 在phpmyadmin选择你的数据库(DB_DATABASE)导入init.sql即可

## 更改config/app.php 

```
'url' => 'http://relsoul.com', (更改为你自己的域名)
"jwt"=>"test!"  (JWT TOKEN加盐方法 推荐更改为自定义字符串 比如 xxx!@#xxx)
```

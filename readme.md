# relsoul个人主页说明
博客引用了以下互联网资源,如有侵权请联系relsoul@outlook.com
- https://dash.readme.io/login 密码登陆框

为了练习MYSQL,本项目并没有采用最佳数据查询与设计.

[预览](https://github.com/Relsoul/relsoulHomePage)

![1](http://cdn.emufan.com/relsoul.com/Relsoul-admin-user-1.jpg)
![2](http://cdn.emufan.com/relsoul.com/RelsoulHome-admin-home-1.jpeg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-admin-home-2.jpeg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-admin-project.jpeg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-admin-projet-1.png)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-admin-user.jpeg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-home-2.jpeg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-login.jpg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-project-2.jpg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-project-list.jpg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome-register.jpg)
![1](http://cdn.emufan.com/relsoul.com/RelsoulHome.jpeg)


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

如在安装中发现错误请参考 laravel安装教程 或者 提交 issue

[laravel安装教程](http://www.golaravel.com/laravel/docs/5.0/)

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


# 日志

### v0.1 2016-05-20

- 初始化laravel框架
- 初始化前端自动化

### v0.2 2016-05-25

- 添加token验证系统

### v0.3 2016-06-05

- 添加登录注册功能
- 添加后台首页管理功能
- 添加后台用户管理功能
- 添加后台项目添加与管理功能
- 添加后台首页技能管理功能
- 添加后台项目列表功能
- 添加功能用户列表功能

### v0.4 2016-06-20

- 修复首页样式
- 添加项目列表样式


### v0.5 2016-09-01

- 大抵完善
- 添加readme说明文件
- 下一步修改细节问题 如去除某些文字 修改样式 修改手机端自适应样式 等






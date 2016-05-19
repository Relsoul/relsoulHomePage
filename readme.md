# relsoul个人主页说明


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

## 错误代码
|错误代码|说明|
|:---:|:---:|
|40001|用户token过期|
|40002|无效的token|
|40003|用户不存在或者账号密码错误|


## 注册与登录
| 说明 | URL | 附加参数 | 返回说明 |
| --- | ---: | :---: | :---:|
| 注册 | /register | name,password,email |result(object) |
| 登录 | /login | name(email or username ),password,loginType(1:userName登录,2:email登录)|



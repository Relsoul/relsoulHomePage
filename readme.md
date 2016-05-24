# relsoul个人主页说明
博客引用了以下互联网资源,如有侵权请联系relsoul@outlook.com
- https://dash.readme.io/login 密码登陆框


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
|40004|验证码不正确|
|40005|注册参数不正确|
|40006|注册插入数据库失败|


## 注册与登录
| 说明 | URL | 附加参数 | 成功返回说明 |
| --- | :---: | :---: | :---:|
| 注册 | /register | name,password,email |result(username) |
| 登录 | /login | name(email or username ),geetest_challenge(验证码参数一),geetest_validate(验证码参数二),geetest_seccode(验证码参数三),password,loginType(1:userName登录,2:email登录)|result:{token,userName}|




# 登陆与注册modal框
```
<login-modal :login-id="loginModalId" :register-id="registerModalId"></login-modal>
<register-modal :login-id="loginModalId" :register-id="registerModalId"></register-modal>
```
login与register可以传递两个值 register-id与login-id 类型为String 如果不传递默认的值为
login-id:"loginModal",register-id:"registerId"
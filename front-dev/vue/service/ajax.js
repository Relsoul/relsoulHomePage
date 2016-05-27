/**
 * Created by soul on 2016/5/24.
 */

"use strict";

function tokenAjax(url,method,data="") {
    return new Promise((resolve,reject)=>{
        let token=window.localStorage.getItem("token");
        if(!token){
            return reject({type:"false",code:"40002","message":"无效的token"});
        }
        $.ajax(
            {
                url,
                method,
                data,
                headers: {"authorization": token},
                success(data){
                    if(data.type=="true"){
                        return resolve(data);
                    }
                    let errorCode=data.code;
                    return reject(data);
                }
            }
        )
    })
};

export {tokenAjax};


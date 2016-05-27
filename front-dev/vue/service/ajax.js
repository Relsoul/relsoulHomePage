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
        let contentType=true;
        if(data instanceof FormData){
            //FormDta 为false
            contentType=false;
        }
        $.ajax(
            {
                url,
                method,
                data,
                contentType,
                processData: false,
                cache : false,
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

function promiseAjax(url,method,data="") {
    return new Promise((resolve,reject)=>{
        let contentType=true;
        if(data instanceof FormData){
            //FormDta 为false
            contentType=false;
        }
        $.ajax(
            {
                url,
                method,
                data,
                contentType,
                processData: false,
                cache : false,
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
}


export {tokenAjax,promiseAjax};


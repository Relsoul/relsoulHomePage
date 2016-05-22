/**
 * Created by soul on 2016/5/22.
 */

"use strict";
let showInfo=function(){
    let timer;
    return function (info,time,field) {
        if(!timer){
            timer=setTimeout(()=>{
                this[field]="";
                clearTimeout(timer);
                timer=null;
            },time);
        }else{
            return false;
        }
        this[field]=info;
    }
};

export {showInfo};
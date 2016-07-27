/**
 * Created by soul on 2016/5/30.
 */
"use strict";
function findNewValue(newV,oldV){
    return newV.filter((v,i)=>{
        let keys=Object.keys(v);
        for(let k of keys){
            let value=v[k];
            let oldObject=oldV[i];
            //如果是新添加的
            if(!oldObject){
                //给初始列表添加最新的
                oldV.push(v);
                return true
            }
            //console.log(86,oldObject);
            //如果旧值中不存在新添加的key
            if(! oldObject.hasOwnProperty(k) ){
                return true
            }
            let oldValue=oldObject[k];
            //如果旧值不等于新值
            if(oldValue!==value){
                return true
            }
        }
    });

}
export {findNewValue}
/**
 * Created by soul on 2016/6/5.
 */
"use strict";
function setHeaderWidth(){

    if($(document).width()>420){
        $(".header nav").height($(document).height());
    }
}
export {setHeaderWidth}
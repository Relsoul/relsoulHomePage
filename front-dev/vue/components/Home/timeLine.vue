<template>
   <div :class="cls" class="time-line">
       <div class="container">
           <h1 class="text_underline time-line-h1">{{title}}</h1>
           <ul class="">
               <li class="time-line-item" v-for="d in studyExpList">
                   <div class="time-line-circle">

                   </div>
                   <div class="time-line-border" v-if="$index!=studyExpList.length-1">

                   </div>
                   <div class="time-line-text " :class="{'time-line-left':$index%2==0?false:true,'time-line-right':$index%2==0?true:false}">
                       <h2>{{d.exp_name}}</h2>
                       <h3>{{d.exp_start_time}}至{{d.exp_end_time}}</h3>
                       <p>{{d.exp_content}}</p>
                   </div>
               </li>
<!--               <li class="time-line-item">
                   <div class="time-line-circle">

                   </div>
                   <div class="time-line-border">

                   </div>
                   <div class="time-line-text time-line-left " >
                       hello it is text2
                   </div>
               </li>-->
           </ul>
       </div>
   </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">

    export default{
        data(){
            return{
                msg:'hello vue',
                getUrl:"",
                studyExpList:[]
            }
        },
        props:["cls","title","getUrl"],
        ready(){
            if(this.getUrl){
                $.promiseAjax(this.getUrl,"get").then((data)=>{
                    this.studyExpList=data.result;
                    console.log("studtyExp",data)
                }).catch()
            }
        },
        components:{

        }
    }
</script>
<template>
   <div class="home-skills">
        <div class="container">
            <h1 class="text_underline">My Skills</h1>
            <div class="row">

                <!--
                for  生成
                -->
                <div class="col m6" v-for="skill in skills">
                    <div class="skills-content">
                        <h2>{{skill.name}}</h2>
                        <div class="col m10">
                            <div class="progress">
                                <div class="determinate" :style="{width:skill.startWidth+'%'}"></div>
                            </div>
                        </div>
                        <div class="col m2">
                            <span class="skills-value">
                                {{skill.startWidth+'%'}}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
   </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">

    export default{
        data(){
            return{
                skills:[{name:"test1",startWidth:0,endWidth:30},{name:"test2",startWidth:0,endWidth:60}]
            }
        },
        ready(){
            let runnSkill=function (i) {
                return new Promise((resolve,reject)=>{
                    let timer=setInterval(()=>{
                        if(i.startWidth>=i.endWidth){
                            resolve(timer);
                            return false
                        }
                        i.startWidth++;
                    },60)
                })
            }
          for(let i of this.skills){
             runnSkill(i).then((timer)=>{
                clearInterval(timer)
             })
          }
        },
        components:{

        }
    }
</script>
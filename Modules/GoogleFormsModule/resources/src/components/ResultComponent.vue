<template>
    <KeepAlive >
      <div  class="container justify-content-center align-items-center my-5 overflow-hidden">
        <div class="pt-5">
            <div class="alert alert-info text-center fs-2">Your Have Got  {{ resultDegree }}</div>
        </div>
    </div>
    </KeepAlive>
</template>

<script>
import {  mapState } from 'pinia';
import { formStore } from '../stores/formStore';

    export default {
        data(){
            return{
                resultDegree : null
            }
        },
        computed:{
            ...mapState(formStore,["degree"]),

        },
        mounted(){
            this.resultDegree = this.degree;
            if(this.degree == null){
                this.resultDegree =  localStorage.getItem("degree")
            }
        }

    }
</script>

<style  >

</style>





<template>
    <header class="form-title-header pb-4 shadow-sm">
        <div class="border-1 border-bottom position-relative">
            <input class=" tiptap title border-0   w-100 py-3"  placeholder="Form Title"  type="text" v-model="formList[0].formInfo.sectionTitle">
            <span v-if="this.formList[0].titleError" v-html="errorIcon"   style="cursor: pointer;" class="position-absolute end-0 mt-3 me-3" v-tippy="{ content: 'You must write a title.', placement: 'bottom' }" >

            </span>
        </div>
        <div class="border-1 border-bottom ">
            <input placeholder="Form Description" class=" tiptap description border-0  w-100 py-2" type="text" v-model="formList[0].formInfo.sectionDescription">
        </div>

    </header>
</template>

<script>
import { mapState } from 'pinia';
import { formStore } from '../stores/formStore';
import { svgIcons } from './icons/SvgIcons';



export default {

    computed:{
        ...mapState(formStore , ['formList'])
    },
    data(){
        return{
            errorIcon: svgIcons.errorIcon
        }
    },

    mounted(){
    }
}
</script>

<style>
    .form-title-header{
        border: 1px solid #d9d9d9;
        border-top: 10px solid #0d6efd ;
        border-radius: 10px;
        background-color: #fff;

    }
    .tiptap.description
{
  font-size: 16px;
    height: 40px;
    line-height: 40px;
    color: rgb(110, 113, 119);
    outline: none;
    padding: 0px 10px ;
    overflow: hidden; /* Hide content that overflows */
}
.tiptap.title{
  font-size: 36px;
    height: 60px;
    line-height: 60px;
    outline: none;
    padding: 0px 10px ;
    overflow: hidden;
}

</style>

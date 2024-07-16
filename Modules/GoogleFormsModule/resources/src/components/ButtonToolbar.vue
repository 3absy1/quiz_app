<template>
    <div>
        <div class="btn-comp bg-white rounded-2 shadow-sm " :class="{ 'btn-group-vertical': isVertical, 'btn-group': !isVertical }" role="group" aria-label="Button group">
            <!-- <button type="button" class="btn btn-light" @click="addComponent" v-tippy="{ content: 'Add Question', placement: 'right'  }" >
                <span v-html="plusIcon"></span>
            </button> -->
            <!-- <button  type="button" class="btn btn-light" @click="openModal('question','any data')"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" v-tippy="{ content: 'Import Question', placement: 'right' }">
                <span v-html="importQuestionsIcon"></span>
            </button>
                <button @click="prepareFormData" type="button" class="btn  btn-light" v-tippy="{ content: 'Add Section', placement: 'right' }" >
                    <span v-html="rectangleIcon"></span>
                </button> -->
        </div>
    </div>
</template>

<script>
import { svgIcons } from './icons/SvgIcons';
import { formStore } from '../stores/formStore';
import { mapActions,mapState } from 'pinia';



export default {
    data() {
        return {

            // icons
            plusIcon : svgIcons.plus,
            importQuestionsIcon : svgIcons.importQuestions,
            titleIcon : svgIcons.title,
            imageIcon: svgIcons.image,
            videoIcon: svgIcons.video,
            rectangleIcon: svgIcons.rectangle,
            isVertical: true,

        }
    },
    computed:{
        ...mapState(formStore,["getFormList"])
    },
    components:{
    }
    ,
    methods:{
        ...mapActions(formStore,['prepareFormData','addComponent','openModal']),

    // update Button Group (responsive)
    updateButtonGroupType() {
      this.isVertical = window.innerWidth >= 600;
    },

    },
    mounted() {
    this.updateButtonGroupType(); // Initial check
    window.addEventListener('resize', this.updateButtonGroupType);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.updateButtonGroupType);
  },

}
</script>

<style>

@media (max-width : 600px) {

  div.btn-comp.btn-group{
    position: fixed;
    bottom: 0px !important;
    right: 0px !important;
    left: 0px !important;
    width:100%;
  }
}

</style>

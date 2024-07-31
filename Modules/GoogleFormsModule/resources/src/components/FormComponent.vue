<template >

    <section :id="`comp${componentIndex}`"  @click="selectElement(componentIndex)"  @focusin="selectElement(componentIndex)"  class=" rounded-3 question-comp mt-2 shadow-sm px-3"
  :class="{ 'focused': getFormList[componentIndex].isSelected  }">
    <div class="border-0 bg-transparent text-secondary d-flex d-block w-100 justify-content-center">
        <span style="cursor: move;" class="handle mt-2">
      <span v-html="moveIcon"></span>
    </span>
    </div>
    <div  class="container py-3">

      <!-- start questions row  -->
      <div v-show="!getFormList[componentIndex].answerKeySelected"  class="form-wrapper row justify-content-between flex-wrap align-items-start">

        <!-- Start DropDown wrapper -->
            <div  class="col-12 mt-1">
            <div class="dropdown custom-dropdown">
                <button  class="btn  drop-down-btn fw-bold px-4   dropdown-toggle  d-flex align-items-center border-0 mb-3" style="background-color: #EEF5FF;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-block me-2" v-html="getFormList[componentIndex].selectedIcon"></span>
                <span class="d-block font-size-16 me-2  fs-5">{{ getFormList[componentIndex].selectedLabel }}</span>
                </button>
                <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton" >
                <li style="cursor:pointer" v-for="option in optionValues" :key="option.value">
                    <a class="dropdown-item d-flex align-items-center" @click="updateSelectedValue(option.value,option.icon,componentIndex, option.label)">
                    <span class="d-block  me-2" v-html="option.icon"></span>
                    <span class="d-block font-size-20">   {{ option.label }}</span>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        <!-- <select class="ms-4 mb-3 ps-3 pe-5 form-select custom-dropdown" v-model="formList[componentIndex].selectedValue" aria-label="Default select example">
        <option v-for="option in optionValues" :key="option.value" :value="option.value">{{option.label}}</option>
        </select> -->
        <!-- End DropDown wrapper -->

        <!-- start question wrapper -->
        <div  class="flex-grow d-flex align-items-center">
            <div class="flex-shrink-1 w-100 me-2">
                <!-- <div>
                    <p class="fs-3 text-muted">Enter A Question ?</p>
                    <span ></span>
                </div> -->
                <!-- <input class="tiptap question border-0   w-100" type="text" placeholder="Enter A Question ? " v-model="getFormList[componentIndex].questionValue" @blur="v$.getFormList.$each.questionValue.$touch"> -->
                <input class="tiptap question border-0   w-100" type="text" placeholder="Enter A Question ? " v-model="getFormList[componentIndex].questionValue" @blur="touchQuestField(componentIndex)">


            </div>
            <!-- Start Upload question wrapper -->
            <div class="d-flex flex-grow align-items-center">
                <div v-if="v$.getFormList.$error  || getFormList[componentIndex].questionError">
                   <span v-if="this.v$.getFormList.$each.$response.$data[componentIndex].questionValue.$error" style="cursor: pointer;"  v-tippy="{ content: 'You must write a question .', placement: 'bottom' }" v-html="errorIcon" class="me-3"></span>
                </div>
                <!-- <span style="cursor: pointer;"  v-tippy="{ content: 'You must write a question .', placement: 'bottom' }" v-html="errorIcon" class="me-3"></span> -->
                <label style="cursor: pointer; background-color: #EEF5FF; padding: 10px;" class="btn d-flex flex-nowrap" :for="`up-img${componentIndex}`">
                    <svg xmlns="http://www.w3.org/2000/svg" class="image-label"  width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H12C12.5523 2 13 2.44772 13 3C13 3.55228 12.5523 4 12 4H5Z" fill="#0065FE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15 5C15 4.44772 15.4477 4 16 4H22C22.5523 4 23 4.44772 23 5C23 5.55228 22.5523 6 22 6H16C15.4477 6 15 5.55228 15 5Z" fill="#0065FE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19 1C19.5523 1 20 1.44772 20 2V8C20 8.55228 19.5523 9 19 9C18.4477 9 18 8.55228 18 8V2C18 1.44772 18.4477 1 19 1Z" fill="#0065FE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9 8C8.44772 8 8 8.44772 8 9C8 9.55228 8.44772 10 9 10C9.55228 10 10 9.55228 10 9C10 8.44772 9.55228 8 9 8ZM6 9C6 7.34315 7.34315 6 9 6C10.6569 6 12 7.34315 12 9C12 10.6569 10.6569 12 9 12C7.34315 12 6 10.6569 6 9Z" fill="#0065FE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.379 11.207C14.9416 10.6446 15.7045 10.3286 16.5 10.3286C17.2955 10.3286 18.0584 10.6446 18.621 11.207L21.7071 14.2931C22.0976 14.6836 22.0976 15.3168 21.7071 15.7073C21.3166 16.0978 20.6834 16.0978 20.2929 15.7073L17.207 12.6214C17.207 12.6214 17.207 12.6214 17.207 12.6214C17.0195 12.434 16.7651 12.3286 16.5 12.3286C16.2349 12.3286 15.9806 12.4339 15.7931 12.6213C15.7931 12.6213 15.7931 12.6213 15.7931 12.6213L6.70711 21.7073C6.31658 22.0978 5.68342 22.0978 5.29289 21.7073C4.90237 21.3168 4.90237 20.6836 5.29289 20.2931L14.379 11.207Z" fill="#0065FE"/>
                    </svg><span style="white-space: nowrap; margin-left: 5px; ">Add image</span></label>
                <input style="display: none;" type="file" :id="`up-img${componentIndex}`"  @change="event => handleUploadImg(componentIndex, event ,'Question')">
            </div>
        <!-- End Upload question wrapper -->
        </div>
        <!-- End question wrapper -->



        <transition name="fade-img">
          <div v-if="getFormList[componentIndex].imageFileDataUrl" class="uploaded-image-wrapper col-4">
          <img   :src="getFormList[componentIndex].imageFileDataUrl" alt="Uploaded Image" class="uploaded-image">
          <button v-if="!getFormList[componentIndex].answerKeySelected"   @click="removeOptionImg(componentIndex,'Question')" class="border-0 bg-transparent fw-bolder fs-6 position-absolute"><i class="fa-solid fa-x fw-bolder  bg-secondary text-white p-2 rounded-3 "></i></button>
          </div>
        </transition>
      </div>
      <!-- End questions row  -->
      <!-- Start Choose correct answers   -->
      <div v-show="getFormList[componentIndex].answerKeySelected" class="fs-4 text-muted">
        <i class="fa-regular fa-square-check"></i> Choose correct answers:
        <hr>
        <div class="d-flex justify-content-between">
          <div>
            <p>{{ getFormList[componentIndex].questionValue.length ?  getFormList[componentIndex].questionValue : 'Please note that there is no question !' }}</p>
          </div>
          <div >
            <input class="question-marks" min="0" v-model="getFormList[componentIndex].questionMark" @change="handleMarksChange(componentIndex)" type="number"> <span class="fs-6">Points</span></div>
        </div>
        <transition name="fade-img">
          <div v-if="getFormList[componentIndex].imageFileDataUrl" class="uploaded-image-wrapper">
          <img   :src="getFormList[componentIndex].imageFileDataUrl" alt="Uploaded Image" class="uploaded-image">
          <button v-if="!getFormList[componentIndex].answerKeySelected"   @click="removeOptionImg(componentIndex,'Question')" class="border-0 bg-transparent fw-bolder fs-6 position-absolute"><i class="fa-solid fa-x fw-bolder  bg-secondary text-white p-2 rounded-3 "></i></button>


          </div>
        </transition>
      </div>
      <!-- End Choose correct answers   -->



      <!-- Start row of multi choice and multi Checkboxes -->
      <div class="row align-items-center" v-if="getFormList[componentIndex].selectedValue === 'Choose' || getFormList[componentIndex].selectedValue == 'Checkboxes'">
        <div  v-for="(option,i) in  data.data" :key="i" >
          <div  class="d-flex flex-wrap align-items-center justify-content-between mt-2">

        <!-- answer edit section -->
          <div v-if="!getFormList[componentIndex].answerKeySelected">
            <input  style="cursor: pointer;"  v-if="getFormList[componentIndex].selectedValue === 'Choose' && !getFormList[componentIndex].answerKeySelected" type='radio' @click="handleChooseAnswer(componentIndex,i)" :checked="option.isCorrect"   :name="'multiChoice'+componentIndex"  class="form-check-input custom-radio"  :disabled="!getFormList[componentIndex].answerKeySelected">
            <input v-if="getFormList[componentIndex].selectedValue === 'Checkboxes'" type="checkbox"  class="form-check-input custom-radio"  @click="handleMultiAnswer(componentIndex,i)" :checked="option.isCorrect"  :disabled="!getFormList[componentIndex].answerKeySelected">
          </div>

          <!-- choose correct answer section -->
          <div v-if="getFormList[componentIndex].answerKeySelected" class="w-100  rounded-3 border"  :class="{'answer-bg' : option.isCorrect && getFormList[componentIndex].answerKeySelected}">
            <div v-if="getFormList[componentIndex].selectedValue === 'Choose'">
                <input  style="cursor: pointer; background-color: #000 !important;"  v-if="getFormList[componentIndex].selectedValue === 'Choose' && !getFormList[componentIndex].answerKeySelected" type='radio' @click="handleChooseAnswer(componentIndex,i)" :checked="option.isCorrect"   :name="'multiChoice'+componentIndex"  class="form-check-input custom-radio"  :disabled="!getFormList[componentIndex].answerKeySelected">
                <label class="d-block w-100 d-flex align-items-center p-3" style="cursor: pointer;" v-if="getFormList[componentIndex].answerKeySelected" @click="validateCorrectAnswer" :for="'com'+componentIndex+'ans'+i">
                    <input :id="'com'+componentIndex+'ans'+i" style="cursor: pointer;"  v-if="getFormList[componentIndex].selectedValue === 'Choose' && getFormList[componentIndex].answerKeySelected" type='radio' @click="handleChooseAnswer(componentIndex,i)" :checked="option.isCorrect"   :name="'multiChoice'+componentIndex"  class="form-check-input custom-radio"  :disabled="!getFormList[componentIndex].answerKeySelected">
                    <p class="my-0 ms-2 mt-1 flex-grow fs-4"  :class="{ 'text-danger' : !option.value.length }" >{{  option.value.length ? option.value : "Please note that this field is empty" }}</p>
                    <span v-if="option.isCorrect"  class="ms-auto  fw-bold">Correct</span>
                </label>
            </div>
            <div v-if="getFormList[componentIndex].selectedValue === 'Checkboxes'">
            <input  style="cursor: pointer; background-color: #000 !important;"  v-if="getFormList[componentIndex].selectedValue === 'Checkboxes' && !getFormList[componentIndex].answerKeySelected" type='checkbox' @click="handleMultiAnswer(componentIndex,i)" :checked="option.isCorrect"     class="form-check-input custom-radio"  :disabled="!getFormList[componentIndex].answerKeySelected">
            <label class="d-block w-100 d-flex align-items-center p-3" style="cursor: pointer;" v-if="getFormList[componentIndex].answerKeySelected" @click="validateCorrectAnswer" :for="'com'+componentIndex+'ans'+i">
                <input :id="'com'+componentIndex+'ans'+i" style="cursor: pointer;"  v-if="getFormList[componentIndex].selectedValue === 'Checkboxes' && getFormList[componentIndex].answerKeySelected" type='checkbox' @click="handleMultiAnswer(componentIndex,i)" :checked="option.isCorrect"    class="form-check-input custom-radio"  :disabled="!getFormList[componentIndex].answerKeySelected">
                <p class="my-0 ms-2 mt-1 flex-grow fs-4"  :class="{ 'text-danger' : !option.value.length }" >{{  option.value.length ? option.value : "Please note that this field is empty" }}</p>
                <span v-if="option.isCorrect"  class="ms-auto  fw-bold">Correct</span>
            </label>
            </div>
            <!-- <input v-if="getFormList[componentIndex].selectedValue === 'Checkboxes'" type="checkbox"  class="form-check-input custom-radio"  @click="handleMultiAnswer(componentIndex,i)" :checked="option.isCorrect"  :disabled="!getFormList[componentIndex].answerKeySelected"> -->
          </div>

          <div  class=" flex-grow-1 py-2 position-relative">
            <input v-if="!getFormList[componentIndex].answerKeySelected" @focusin="option.showImgAltIcon = true"  @focusout="option.showImgAltIcon = false" type="text" v-model="option.value"  @blur="touchQuestField(componentIndex)" class="answer-title w-100 border-1 border-bottom"  :placeholder="(option.placeholder ==='Option') ? option.placeholder  + ' '+ option.label : option.placeholder" :disabled="getFormList[componentIndex].answerKeySelected">
            <span v-if="option.isCorrect &&  !getFormList[componentIndex].answerKeySelected" class="position-absolute top-0 end-0 mt-3" v-html="checkedIcon"></span>
          </div>
          <div v-if="!getFormList[componentIndex].answerKeySelected">
            <div v-if="v$.getFormList.$error ||  getFormList[componentIndex].data[i].answerError" class="ms-3">
                <span v-if="v$.getFormList.$each.$response.$data[componentIndex].data.$each.$data[i].value.$error " style="cursor: pointer;" v-tippy="{ content: 'You must write an answer or upload Image for this question.', placement: 'bottom' }" v-html="errorIcon"></span>
            </div>
        </div>
          <div    v-if="!getFormList[componentIndex].answerKeySelected" class=" ms-3">
            <label  :for="`answerImg${componentIndex}option${option.label}`">
                <span style="cursor: pointer;" v-html="uploadImageIcon"></span>
            </label>

            <input style="display: none;" type="file"  :id="`answerImg${componentIndex}option${option.label}`"   @change="event => handleUploadImg(componentIndex, event, 'Answer', i)" >
          </div>

          <div v-if="!getFormList[componentIndex].answerKeySelected" class="ms-3 d-flex">
            <button v-if="getFormList[componentIndex].regularOptions.length > 2 "  @click="removeOption(option.id,componentIndex)" class="border-0 bg-transparent fw-bolder fs-6"><i class="fa-solid fa-x fw-bolder text-secondary"></i></button>
          </div>
        </div>
         <transition name="fade-img">
        <div v-if="getFormList[componentIndex].data[i].image" class="uploaded-image-wrapper border-1 border ">
          <img   :src="getFormList[componentIndex].data[i].image" alt="Uploaded Image" class="uploaded-image position-relative">
          <button v-if="!getFormList[componentIndex].answerKeySelected"   @click="removeOptionImg(componentIndex,i)" class="border-0 bg-transparent fw-bolder fs-6 position-absolute"><i class="fa-solid fa-x fw-bolder  bg-secondary text-white p-2 rounded-3 "></i></button>

        </div>
        </transition>
        </div>

        <!-- add option  -->
        <div  v-if="!getFormList[componentIndex].answerKeySelected" class="col-12 pt-3">
          <button class=" btn btn-light text-muted py-2 fw-bolder w-100 shadow-sm fs-5 d-flex align-items-center justify-content-center" @click="addOption('Option',componentIndex)"><span class="px-3 mb-1" v-html="plusIcon"></span> <span>Add Option</span></button>
        </div>

      </div>

      <!-- true or false -->
      <div class="row mt-5 justify-content-evenly" v-if="getFormList[componentIndex].selectedValue === 'TrueOrFalse'" >
       <div  v-for="(option,i) in  data.data" :key="i" class="col-md-12 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center border w-100 mb-2 rounded-3" :class="{'answer-bg' : option.isCorrect}">

            <input @click="handleTrueFalseAnswer(componentIndex,i)" :checked="option.isCorrect"    class="form-check-input custom-radio mb-1 d-none" :id='"comp"+componentIndex+"answer"+i' type="radio" :name="'trueOrFalse'+componentIndex" :disabled="!getFormList[componentIndex].answerKeySelected">
            <label class=" fs-4 w-100 px-2 py-3 " :style="(getFormList[componentIndex].answerKeySelected) ? 'cursor: pointer;': ''" :for='"comp"+componentIndex+"answer"+i'>
                <span v-html="option.icon"></span>
                <span class="ms-2 mt-2">{{option.value}}</span>
            </label>
            <span v-if="option.isCorrect" class="me-2"  v-html="checkedIcon"></span>
            <div v-if="!getFormList[componentIndex].answerKeySelected" class=" ms-auto">
            <!-- <label class="me-2"  style="cursor: pointer;" :for='"trueAnswer"+i'><span v-html="uploadImageIcon"></span></label>
            <input style="display: none;" type="file"  :id='"trueAnswer"+i'   @change="event => handleUploadImg(componentIndex, event, 'Answer', i)" > -->
          </div>
        </div>
        <!-- upload img -->

          <transition name="fade-img">
        <div v-if="option.image" class="uploaded-image-wrapper border-1 border ">
          <img   :src="option.image" alt="Uploaded Image" class="uploaded-image position-relative">
          <button v-if="!getFormList[componentIndex].answerKeySelected"   @click="removeOptionImg(componentIndex,i)" class="border-0 bg-transparent fw-bolder fs-6 position-absolute"><i class="fa-solid fa-x fw-bolder  bg-secondary text-white p-2 rounded-3 "></i></button>
        </div>
        </transition>
       </div>
      </div>

    </div>
      <div>
      <!-- End row of multi choice and multi Checkboxes -->
      <hr class="my-2">
      <!--  -->
      <div v-if="!getFormList[componentIndex].answerKeySelected"  class="row pt-2 pb-3  px-3">
        <div  class="col-lg-6 d-flex justify-content-start align-items-center">
          <button style="background-color: rgb(238, 245, 255);" class="btn border-0 text-primary fs-6 me-3" @click.prevent="answerKey(componentIndex)"><i class="fa-regular fa-square-check"></i> Answer Key</button>
                <!-- error message -->
            <span style="cursor: pointer;" v-tippy="{ content: getFormList[componentIndex].answerError, placement: 'bottom' }" class="me-3"  v-if="getFormList[componentIndex].answerError && !correctAnswer" v-html="errorIcon"></span>
            <span  class="text-muted">( {{getFormList[componentIndex].questionMark}} Point )</span>
        </div>
        <div  class="col-lg-6 d-flex justify-content-end">
          <!-- <div class="me-3 btn-icon">
            <button class="border-0 bg-transparent" @click="duplicateComponent(componentIndex)"><i class="fa-regular fa-copy"></i></button>
          </div> -->
          <div class="me-3 btn-icon">
            <button  :disabled="getFormList.length === 1"   class="border-0 bg-transparent" @click="removeComponent(componentIndex)"><i class="text-danger fa-regular fa-trash-can "></i></button>
          </div>

        </div>
      </div>
      <div v-if="getFormList[componentIndex].answerKeySelected" class=" d-flex justify-content-end pt-2 pb-3">
          <button class="btn btn-outline-primary me-3" @click.prevent="toggleAnswerKey(componentIndex)">Done</button>
      </div>
    </div>
</section>
<div class="text-center my-3 position-relative">
    <button type="button" class="btn btn-light border add-question z-2" @click="addComponent(componentIndex)" >
        <span v-html="plusIcon"></span>
    </button>
</div>

</template>

<script>
import { formStore } from '../stores/formStore';
import { mapActions, mapState } from 'pinia';
import { svgIcons } from './icons/SvgIcons';
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'


export default {
    setup () {
    return { v$: useVuelidate() }
  },
  components:{

  },
  computed: {
    ...mapState(formStore, ['formList','isSelected','getFormList','count','fileTypes','optionValues',]),

  },

  data() {
    return {
      modalData: {
      title: 'Default Title',
    },
    correctAnswer :  false,

    moveIcon : svgIcons.moveIcon,
    plusIcon : svgIcons.plus,
    errorIcon : svgIcons.errorIcon,
    uploadImageIcon : svgIcons.uploadImage,
    checkedIcon : svgIcons.checked,
    };
  },
  validations () {
    return {
        getFormList : {
            $each: helpers.forEach({
                questionValue: { required },
                data  : {
                    $each: helpers.forEach({
                        value: { required }
                    }),
                },
            }),
        }
    }
},




  props: {
    componentIndex: {
      type: Number,
    },
    data: {
      type: Object,
    },
  },

  // watch the select box changes

  methods: {
    ...mapActions(formStore, ['handleTrueFalseAnswer','handleMultiAnswer','handleMarksChange','handleChooseAnswer','toggleAnswerKey','answerKey','removeOptionImg','handleUploadImg','deselectElement','selectElement','requiredSwitch','removeComponent','updateSelectedValue','addOption','removeOption','resetOptionIdsAndLabels','getSelectedPlaceholder','handleDropdowns','duplicateComponent','addComponent']),
    touchQuestField(componentIndex) {
    this.v$.getFormList.$touch()
    },

    validateCorrectAnswer(){
        if (!this.getFormList[this.componentIndex].answerError) {
            this.correctAnswer = false
        }else{
            this.correctAnswer = true
        }
    }


  },

mounted(){
    console.log(window.location.origin);
}


};
</script>

<style>
.answer-bg{
    background-color: #e9e9e9;
}
.custom-dropdown{
    width: fit-content;
    padding: 15px 30px;
}

.question-comp{
  background-color: #fff;
  border: 1px solid #d9d9d9;
}
.drop-down-btn{
  background-color: #fff;
  border: 1px solid #d9d9d9 !important;
  padding: 10px 0 !important;
  border-radius: 5px !important;
  color: #202124 !important;
}
  .image-label{
    /* padding: 10px; */
    /* border-radius: 50%;
    width: 60px;
    height: 50px; */
    /* text-align: center; */
    /* line-height: 30px; */
    cursor: pointer;
  }
  .btn-icon{
    width: fit-content;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    text-align: center;
    line-height: 50px;
    cursor: pointer;

  }
  .btn-icon button{
    width: 100%;
    display: block;
  }
  .btn-icon button i{
    font-size: 22px;

    color: #5f6368;
  }
  .btn-icon:hover{
    background-color: #f0f0f0 !important ;
    }
  /* .image-label:hover{
    background-color: #f0f0f0;
  } */

  .image-label i {
    font-size: 22px;
    line-height: 30px;
    color: #5f6368;
    cursor: pointer;
  }
  i.image-label{
    font-size: 22px;
    line-height: 30px;
  }
  .form-switch .form-check-input{
    width: 50px !important;
    height: 25px !important;
  }
  .answer-title{
    border: none;
    outline: none;
    margin-left: 10px;
    height: 40px;
    font-size: 20px;
  }

  .answer-title:focus{
    background-color: #f0f0f0;
    border-bottom: 1px solid #7e7e81;
    transition: 200ms all  ease-in-out;
  }
  .question-marks{
    border: none;
    outline: none;
    width: 60px;
    padding: 0 10px;
    font-size: 16px;
    background-color: #f0f0f0;
    border-bottom: 1px solid #7e7e81;
  }

  .custom-radio{
    width: 25px !important; /* Set the desired width */
    height: 25px !important; /* Set the desired height */
  }
  .add-field-btn:hover{
    text-decoration: underline;
  }
  .h-50px{
    height: 50px;
  }

  .focused {
  /* Add your styles for the focused class here */
  border-left: 10px solid #0d6efd;
  transition: .2s all ease-in-out;
}

.uploaded-image-wrapper {
  width: 100%;
  max-width: 100px;
  height: auto;
  max-height: 300px;
  overflow: hidden;
}

.uploaded-image-wrapper img {
  width: 100%;
  height: auto;
  object-fit: contain;
}

/* transition component */
.fade-enter-from{
  /* opacity: 0; */
}
.fade-enter-active{
  /* transition: all .25s linear; */
}
.fade-leave-to{
  /* transition: all .25s linear;
  opacity: 0; */
}
.tiptap.question{
    font-size: 25px;
    min-height: 50px;
    border-bottom: 1px solid black;
    line-height: 50px;
    outline: none;
    padding: 0px 10px ;
    overflow-y: visible; /* Hide content that overflows */
}

.question:focus{
    transition: .2s all ease-in-out;
    background-color: #f0f0f0;
}
.tiptap:focus{
    transition: .2s all ease-in-out;
    background-color: #f0f0f0;
}
.add-question{
    width: 50px;
}
.add-question::after{
    content: "";
    height: 1px;
    width: calc(50% - 25px);
    background-color: #e0e0e0;
    display: block;
    position: absolute;
    top: calc(50% - 1.5px);
    right: 0;
    z-index: 0;
    overflow: hidden;
    cursor: auto;

}
.add-question::before{
    content: "";
    height: 1px;
    width:calc(50% -  25px);
    background-color: #e0e0e0;
    display: block;
    position: absolute;
    top: calc(50% - 1.5px);
    left: 0;
    overflow: hidden;
    z-index: 0;
    cursor: auto;
}
</style>

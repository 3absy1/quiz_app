<template>
    <div style="height: 70vh;" v-if="loader" class=" w-100 d-flex justify-content-center align-items-center ">
        <div style="width: 100px; height: 100px;"  class="spinner-border text-primary  fs-1 "></div>
    </div>
    <!-- <NotFoundComponent v-else-if="generatedFormID === null || quizToken === null"/> -->
    <div v-else class="container" >
        <h2 class="text-center">{{quizList.name}}</h2>
        <div class="countdown-timer mt-5"  v-if="quizList.is_any_time || quizList.is_specific_time">
            <!-- <p class="fs-5 fw-bold">Time Remaining: {{ formatTime(minutes) }}:{{ formatTime(seconds) }}</p> -->
        </div>
        <section  v-for="(question,index)  in quizList?.questions" :key="question.id" >
             <!-- Countdown Timer -->
           <div class="rounded-3 question-comp mt-2 mb-3 shadow-sm px-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-center fw-bold text-primary fs-4">Q{{index+1}}</h2>
                <h5>{{ question.question_type == "TrueOrFalse" ? "True Or False" : question.question_type == "Checkboxes" ? "Multiple Answers": question.question_type}}</h5>
            </div>
            <hr>
            <!-- Question -->
            <div class="">
                <h4>1.{{question.question}}</h4>
            </div>
            <div class="col-12 col-lg-6  pt-3"  v-if="!!question.image">
                <img class="w-100" :src="question.image" alt="">
            </div>
                <!-- Options -->

             <!-- multiple -->
             <div v-if="question.question_type == 'Checkboxes'" class="option-wrapper mt-4" v-for="(answer,i) in question.options" :key="answer.id">
                <div  style="cursor: pointer;" class="bg-light border shadow-sm  rounded-3 d-flex align-items-center mb-3">
                    <input type="checkbox" class="btn-check" name="btnradio" :id="answer.id"  @change="updateSelectedOptions(answer.id,answer.question_id)" autocomplete="off">
                    <label class="btn btn-light text-muted fs-5 fw-bold w-100 h-100 p-3" :for="answer.id">{{answer.option}}</label>
                </div>
                <div v-if="answer.image" class="col-12 col-lg-6" :style="{ height: answer.image ? 'auto ' : '0 !important' }">
                    <img class="w-100" :src="answer.image" alt="">
                </div>
            </div>

            <div v-else class="option-wrapper mt-4" v-for="(answer,i) in question.options">
                <div  style="cursor: pointer;" class="bg-light border shadow-sm  rounded-3 d-flex  align-items-center mb-3">
                    <!-- <input type="checkbox" class="btn-check" name="btncheck"  @click="checked = answer.id" :checked="checked === answer.id" @change="updateSelectedOption(answer.id, answer.question_id)" :id="answer.id"  autocomplete="off"> -->
                    <input type="checkbox" class="btn-check" name="btncheck"  @click="updateSelected(answer.question_id, answer.id)" :checked="isSelected(answer.question_id, answer.id)"  :id="answer.id"  autocomplete="off">
                    <label class="btn btn-light text-muted fs-5 fw-bold w-100 h-100 p-3" :for="answer.id">{{answer.option}}</label>
                </div>
                <div class="col-12 col-lg-6 " v-if="!!answer.image" :style="{ height: answer.image ? 'auto ' : '0 !important' }">
                    <img class="w-100" :src="answer.image" alt="">
                </div>
            </div>

<!--  -->
          </div>
        </section>
        <div class=" text-center my-5">
            <button @click.prevent="submitAnswers" class="btn btn-danger btn-lg" ><span >Submit Answers</span></button>
        </div>
    </div>
</template>

<script>
import { mapState , mapActions } from 'pinia';
import { formStore } from '../stores/formStore';
import { useAuthStore } from '../stores/auth';
// import NotFoundComponent from './NotFoundComponent.vue'

export default {
    data() {
        return {
            minutes: 0,
            seconds: 0,
            checked:null,
            loader: true,
            selectedAnswers: {},
            selectedOneOption: [], // for single selection
            selectedOptions: [], // for multiple selection
            quizList: [],
            intervalId:""
        };
    },
    components:{
        // NotFoundComponent
    },
    computed:{
        ...mapState(formStore, ['baseUrl','quizToken','generatedFormID']),
    },

    methods: {
        ...mapActions(formStore, ['handleQuizAnswer']),

        submitAnswers(){
            const quizData = [...this.selectedOneOption, ...this.selectedOptions]
            localStorage.removeItem('countdownTime'); // Clear stored time after countdown ends
            this.handleQuizAnswer(quizData)
        },



        updateSelectedOptions(answerId, questionId) {
        const index = this.selectedOptions.findIndex(item => item.question_id === questionId);
        if (index !== -1) {
            // If the question_id already exists in the selectedOptions array
            const optionIndex = this.selectedOptions[index].option_id.indexOf(answerId);
            if (optionIndex !== -1) {
                // If the answerId exists in the option_id array, remove it
                this.selectedOptions[index].option_id.splice(optionIndex, 1);
            } else {
                // If the answerId doesn't exist in the option_id array, add it
                this.selectedOptions[index].option_id.push(answerId);
            }
        } else {
            // If the question_id doesn't exist in the selectedOptions array, add it
            this.selectedOptions.push({ "question_id": questionId, "option_id": [answerId] });
        }
    },




    updateSelected(questionId, answerId) {
        // Update selected answer for the current question
        if (this.selectedAnswers[questionId] !== answerId) {
            this.selectedAnswers[questionId] = answerId;
        }else{
            this.selectedAnswers[questionId]  = null;
        }
        let chooseFormat = []
        for (const question in this.selectedAnswers) {
            chooseFormat.push({ "question_id" : question, "option_id" : [this.selectedAnswers[question]] })
        }
        this.selectedOneOption =  chooseFormat;
    },

    isSelected(questionId, answerId) {
        // Check if the current answer is selected for the current question
        return this.selectedAnswers[questionId] === answerId;
    },

    startCountdown() {
    // Check if there's a stored time in localStorage
    let storedTime = localStorage.getItem('countdownTime');
    if (storedTime) {
        let { minutes, seconds } = JSON.parse(storedTime);
        this.minutes = minutes;
        this.seconds = seconds;
    }

    this.intervalId = setInterval(() => {
        if (this.minutes === 0 && this.seconds === 0) {
            this.submitAnswers();
            // this.$router.replace({ path: '/result' });
            clearInterval(this.intervalId);
            localStorage.removeItem('countdownTime'); // Clear stored time after countdown ends
        } else {
            if (this.seconds === 0) {
                this.minutes--;
                this.seconds = 59;
            } else {
                this.seconds--;
            }
            // Store the current time in localStorage
            localStorage.setItem('countdownTime', JSON.stringify({ minutes: this.minutes, seconds: this.seconds }));
        }
    }, 1000);
    },

formatTime(time) {
        return time < 10 ? `0${time}` : time;
    },

    async fetchQuizData() {
        const formData = {
            "token": this.quizToken
        };

        try {
            const response = await fetch(`${this.baseUrl}/api/googleformsmodules/showStdForm/${this.generatedFormID}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });

            const data = await response.json();
            if (res.status === 401) {
                useAuthStore().handleUnauthorized();
                }
            console.log(data);
            if (data.success) {
                this.quizList = data.data;
                this.loader = false;
                if (data.data.is_any_time) {
                    this.minutes = parseInt(this.quizList.time_out);
                    this.startCountdown();
                }else if (data.data.is_specific_time){
                    this.minutes = parseInt(this.quizList.duration);
                    this.startCountdown();
                }
                localStorage.setItem("quizData", JSON.stringify(this.quizList));
            }



            // Start countdown only if quizList is available
        } catch (error) {
            console.error('Error loading data:', error);
        }
    },
        },

    mounted() {
    // Load quiz data from local storage if available
    const storedQuizData = localStorage.getItem("quizData");
    const generatedId = localStorage.getItem("quizId");
    if (storedQuizData && generatedId == this.$route.params.id ) {
        this.quizList = JSON.parse(storedQuizData);
        this.loader = false;
        if (this.quizList.is_any_time) {
            this.minutes = parseInt(this.quizList.time_out);
            this.startCountdown();
        }else if (this.quizList.is_specific_time){
            this.minutes = parseInt(this.quizList.duration);
            this.startCountdown();
        }
    } else {
        this.fetchQuizData();
    }
        window.onbeforeunload = function() {
            return "Are you sure you want to leave this page?";
        };
    },

        beforeUnmount() {
            window.onbeforeunload = null;
            clearInterval(this.intervalId); // Clear the interval responsible for countdown
            localStorage.removeItem("countdownTime");
        }

    }
</script>

<style>
    .selected-option {
        color: green;
        border: 1px solid green !important;
        background: #000 !important;
}
</style>

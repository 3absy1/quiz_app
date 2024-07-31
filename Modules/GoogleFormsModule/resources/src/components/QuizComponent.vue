<template>
  <div
    style="height: 70vh"
    v-if="loader"
    class="w-100 d-flex justify-content-center align-items-center"
  >
    <div
      style="width: 100px; height: 100px"
      class="spinner-border text-primary fs-1"
    ></div>
  </div>
  <!-- <NotFoundComponent v-else-if="generatedFormID === null || quizToken === null"/> -->
  <div v-else class="container">
    <h2 class="text-center">{{ quizList.name }}</h2>
    <div
      class="countdown-timer mt-5"
      v-if="quizList.is_any_time || quizList.is_specific_time"
    >
      <p class="fs-5 fw-bold">
        Time Remaining: {{ formatTime(minutes) }}:{{ formatTime(seconds) }}
      </p>
      <!-- remove later -->
      <!-- {{ startDate }} -->
      <!-- reomve above later -->
    </div>
    <section v-for="(question, index) in quizList?.questions" :key="question.id">
      <!-- Countdown Timer -->
      <div class="rounded-3 question-comp mt-2 mb-3 shadow-sm px-3 p-3">
        <div class="d-flex justify-content-between align-items-center">
          <h2 class="text-center fw-bold text-primary fs-4">Q{{ index + 1 }}</h2>
          <h5>
            {{
              question.question_type == "TrueOrFalse"
                ? "True Or False"
                : question.question_type == "Checkboxes"
                ? "Multiple Answers"
                : question.question_type
            }}
          </h5>
        </div>
        <hr />

        <!-- Question -->
        <div class="">
          <h4>1.{{ question.question }}</h4>
        </div>
        <div class="col-12 col-lg-10 mx-auto pt-3 " v-if="!!question.image">
          <img class="w-100" :src="question.image" alt="" />
        </div>
        <!-- Options -->

        <!-- multiple -->
        <div v-if="question.question_type == 'Checkboxes'" class="row mt-5">
            <div
            :class="`option-wrapper ${doesQuestionOptionsContainsImage(question)?'col-12 col-sm-6 mt-4':''}`"
            v-for="(answer, i) in question.options"
            :key="answer.id"
            >
            <div
                v-if="doesQuestionOptionsContainsImage(question)"
                 :class="`${doesQuestionOptionsContainsImage(question)?'col-12':'col-12 col-lg-10 mx-auto'}`"
                :style="{ height: 'auto ' }"
            >
                <img class="w-100 mx-auto custom-image" :src="answer.image||noImageFound" alt="" />
            </div>
            <div
                style="cursor: pointer"
                class="bg-light border shadow-sm rounded-3 d-flex align-items-center mb-3"
            >
                <input
                type="checkbox"
                class="btn-check"
                name="btnradio"
                :id="answer.id"
                @change="updateSelectedOptions(answer.id, answer.question_id)"
                autocomplete="off"
                :checked="isOptionSelected(answer.question_id, answer.id)"
                />
                <label
                class="btn btn-light text-muted fs-5 fw-bold w-100 h-100 p-3"
                :for="answer.id"

                >{{ answer.option }}</label
                >
            </div>

            </div>
        </div>

        <!-- true & false and single choice -->
        <div v-else class="row" >
            <div  :class="`option-wrapper  ${doesQuestionOptionsContainsImage(question)?'col-12 col-sm-6 mt-4':''}`" v-for="(answer, i) in question.options">
                <div
                v-if="doesQuestionOptionsContainsImage(question)"
                :class="`${doesQuestionOptionsContainsImage(question)?'col-12':'col-12 col-lg-10 mx-auto'}`"
                :style="{ height:  'auto ' }"
            >
                <img class="w-100 custom-image" :src="answer.image||noImageFound" alt="" />
            </div>
            <div
                style="cursor: pointer"
                class="bg-light border shadow-sm rounded-3 d-flex align-items-center mb-3"
            >
                <!-- <input type="checkbox" class="btn-check" name="btncheck"  @click="checked = answer.id" :checked="checked === answer.id" @change="updateSelectedOption(answer.id, answer.question_id)" :id="answer.id"  autocomplete="off"> -->
                <input
                type="checkbox"
                class="btn-check"
                name="btncheck"
                @click="updateSelected(answer.question_id, answer.id)"
                :checked="isSelected(answer.question_id, answer.id)"
                :id="answer.id"
                autocomplete="off"
                />
                <label
                class="btn btn-light text-muted fs-5 fw-bold w-100 h-100 p-3"
                :for="answer.id"
                >{{ answer.option }}</label
                >
            </div>

            </div>
        </div>

        <!--  -->
      </div>
    </section>
    <div class="text-center my-5">
      <button @click.prevent="submitAnswers" class="btn btn-danger btn-lg">
        <span>Submit Answers</span>
      </button>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "pinia";
import { formStore } from "../stores/formStore";
import { useAuthStore } from "../stores/auth";
import { formatDistanceToNow, intervalToDuration,subHours  } from "date-fns";
import noImageFound from '../assets/noimagefound.jpg'

// import NotFoundComponent from './NotFoundComponent.vue'

export default {
  data() {
    return {
      noImageFound,
      minutes: 0,
      seconds: 0,
      checked: null,
      loader: true,
      selectedAnswers: {},
      selectedOneOption: [], // for single selection
      selectedOptions: [], // for multiple selection
      quizList: [],
      intervalId: "",
      //   startDate: "",
      remainingTime: "",
    };
  },
  components: {
    // NotFoundComponent
  },
  computed: {
    ...mapState(formStore, ["baseUrl", "quizToken", "generatedFormID"]),
  },

  methods: {
    ...mapActions(formStore, ["handleQuizAnswer"]),

    submitAnswers() {
      const quizData = [...this.selectedOneOption, ...this.selectedOptions];

      // clear user answers from local storage
      localStorage.removeItem("selectedOneOption");
      localStorage.removeItem("selectedOptions");
      localStorage.removeItem("selectedAnswers");

      this.handleQuizAnswer(quizData,this.$route.params.id);
    },
    doesQuestionOptionsContainsImage(question){
        return question.options.some((option)=>option.image)
    },
    updateSelectedOptions(answerId, questionId) {
        console.log(answerId,questionId)
      const index = this.selectedOptions.findIndex(
        (item) => item.question_id === questionId
      );
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
        this.selectedOptions.push({ question_id: questionId, option_id: [answerId] });
      }
      // storing user answers in the local storage
      // first part is the exam token ,second part is the key itself and third part is user token
      localStorage.setItem(`${this.$route.params.id}selectedOneOption${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedOneOption));
      localStorage.setItem(`${this.$route.params.id}selectedOptions${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedOptions));
      localStorage.setItem(`${this.$route.params.id}selectedAnswers${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedAnswers));
      console.log(this.selectedOptions)
    },

    updateSelected(questionId, answerId) {
      // Update selected answer for the current question
      if (this.selectedAnswers[questionId] !== answerId) {
        this.selectedAnswers[questionId] = answerId;
      } else {
        this.selectedAnswers[questionId] = null;
      }
      let chooseFormat = [];
      for (const question in this.selectedAnswers) {
        chooseFormat.push({
          question_id: question,
          option_id: [this.selectedAnswers[question]],
        });
      }
      this.selectedOneOption = chooseFormat;

      // storing user answers in the local storage
      localStorage.setItem(`${this.$route.params.id}selectedOneOption${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedOneOption));
      localStorage.setItem(`${this.$route.params.id}selectedOptions${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedOptions));
      localStorage.setItem(`${this.$route.params.id}selectedAnswers${localStorage.getItem("quizToken")}`, JSON.stringify(this.selectedAnswers));
    },

    isSelected(questionId, answerId) {
      // Check if the current answer is selected for the current question
      return this.selectedAnswers[questionId] === answerId;
    },

     isOptionSelected (questionId, answerId) {
//   Check if the current answer is selected for the current question
  const targetSelected = this.selectedOptions.filter(
    (el) => el.question_id === questionId
  )[0];

  return targetSelected?.option_id?.includes(answerId);
},

    startCountdown(initialStartTime) {
      //   console.log(initialStartTime);
      // Check if there's a stored time in localStorage

        this.minutes = initialStartTime.minutes;
        this.seconds = initialStartTime.seconds;

      this.intervalId = setInterval(() => {
        if (this.minutes === 0 && this.seconds === 0) {
          this.submitAnswers();
          // this.$router.replace({ path: '/result' });
          clearInterval(this.intervalId);
        } else {
          if (this.seconds === 0) {
            this.minutes--;
            this.seconds = 59;
          } else {
            this.seconds--;
          }
          // Store the current time in localStorage
        }
      }, 1000);
    },

    formatTime(time) {
      return time < 10 ? `0${time}` : time;
    },

    async fetchQuizData() {
      const formId = this.$route.params.id;
      const formData = {
        token: localStorage.getItem("quizToken"),
      };

      try {
        const response = await fetch(
          `${this.baseUrl}/api/googleformsmodules/showStdForm/${formId}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(formData),
          }
        );

        const data = await response.json();
        console.log('test?')
        if (response.status === 401 || !response.ok) {
          useAuthStore().blockQuizAccess(this.$route.params.id);
          throw new Error('failed')
        }
        console.log('test after response')
        if (data.success) {
          this.quizList = data.data;
          this.startDate = data.student;

          this.loader = false;

        //   if (data.data.is_any_time) {
        //     this.minutes = parseInt(this.quizList.time_out);
        //     this.startCountdown();
        //   } else if (data.data.is_specific_time) {
        //     this.minutes = parseInt(this.quizList.duration);
        //     this.startCountdown();
        //   }

        }
        const returnObject = {
            startDate: await data.student,
            examDuration: await data.data.time_out
        };
        return returnObject
        // Start countdown only if quizList is available
      } catch (error) {
        console.log('tststststst')
        // useAuthStore().blockQuizAccess(this.$route.params.id)
        console.error("Error loading data:", error);
      }
    },
  },

  async mounted() {

    // handling setting userAnswers on mount if they exist
    const cachedSelectedAnswers = localStorage.getItem(`${this.$route.params.id}selectedAnswers${localStorage.getItem("quizToken")}`) ? JSON.parse(localStorage.getItem(`${this.$route.params.id}selectedAnswers${localStorage.getItem("quizToken")}`)) : {};
    const cachedSelectedOneOption = localStorage.getItem(`${this.$route.params.id}selectedOneOption${localStorage.getItem("quizToken")}`) ? JSON.parse(localStorage.getItem(`${this.$route.params.id}selectedOneOption${localStorage.getItem("quizToken")}`)) : [];
    const cachedSelectedOptions = localStorage.getItem(`${this.$route.params.id}selectedOptions${localStorage.getItem("quizToken")}`) ? JSON.parse(localStorage.getItem(`${this.$route.params.id}selectedOptions${localStorage.getItem("quizToken")}`)) : [];
    console.log('cached data',cachedSelectedAnswers,cachedSelectedOneOption,cachedSelectedOptions)


    this.selectedAnswers = cachedSelectedAnswers
    this.selectedOneOption=cachedSelectedOneOption
    this.selectedOptions= cachedSelectedOptions


    // step 1) fetch exam data && getting the start date
    try{

        const data =await this.fetchQuizData();
        const startDate = data.startDate
        const examDuration = data.examDuration

        // step 2) get  initial time from back end response
        const startDateObject = new Date(startDate);
        const currentDateObject = subHours( new Date(),1); // we subtract one hour because the current date is one hour plus
        const timePassedSinceExamStarted = intervalToDuration({
            start: startDateObject,
            end: currentDateObject,
          })

          console.log(timePassedSinceExamStarted)
        const initialTimerValue = {
            minutes:examDuration-(timePassedSinceExamStarted.minutes||0)-1,
            seconds:59-(timePassedSinceExamStarted.seconds||0)
        }
        console.log(initialTimerValue)

        // step 3) start the timer
        this.startCountdown(initialTimerValue);
    }catch(err){
        // useAuthStore().blockQuizAccess(this.$route.params.id)
    }

    window.onbeforeunload = function () {
      return "Are you sure you want to leave this page?";
    };
  },

  beforeUnmount() {
    window.onbeforeunload = null;
    clearInterval(this.intervalId); // Clear the interval responsible for countdown
  },
};
</script>

<style>
.selected-option {
  color: green;
  border: 1px solid green !important;
  background: #000 !important;
}
.multiple-selected-option{
    background-color: #c6c7c8;
}
.custom-image{
    height: 400px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    min-width: 100%; /* Ensure the width fills the container */
    min-height: 100%;
}
</style>

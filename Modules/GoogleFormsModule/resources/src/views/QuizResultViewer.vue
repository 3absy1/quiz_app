<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useAuthStore } from "../stores/auth";
import { useRoute, useRouter } from "vue-router";
import NavComponent from "../components/NavComponent.vue";
import { toast } from "vue3-toastify";
import { svgIcons } from '../components/icons/SvgIcons';

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();
const id = parseInt(route.params.id);

const quizList = ref({});

const selectedAnswers = ref({});
const selectedOneOption = ref([]); // for single selection
const selectedOptions = ref([]); // for multiple selection

const loader = ref(false);

onMounted(async () => {
  loader.value = true;
  try {
    const res = await fetch(`${authStore.baseUrl}/api/student/${id}/view`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
    });
    if (res.status === 401) {
        authStore.handleUnauthorized();
    }
    const data = await res.json();

    if (!data.success) {
      router.go(-1);
      setTimeout(() => {
        toast.error(data.message, {
          autoClose: 2000,
          position: "top-left",
        });
      }, 50);
    }

    quizList.value = data.data[0];

    // setting the selected and selected options for the user

    data.data[0].questions.map((question) => {
      if (question.question_type === "Checkboxes") {
        // updating choosed answers in multiple choice question
        const userAnswers = question.options.filter((option) => option.is_answered);
        userAnswers.map((answer) => {
          if (answer.is_answered) {
            updateSelectedOptions(answer.id, question.id);
          }
        });
      } else {
        //updating choose answers in single choice question
        const userAnswer = question.options.filter((option) => option.is_answered);
        updateSelected(question.id, userAnswer[0].id);
      }
      loader.value = false;
    });
  } catch (error) {
    loader.value = false;
  }
});

// const updateSelectedOptions = (answerId, questionId) => {
//   const index = selectedOptions.value.findIndex(
//     (item) => item.question_id === questionId
//   );
//   if (index !== -1) {
//     // If the question_id already exists in the selectedOptions array
//     const optionIndex = selectedOptions.value[index].option_id.indexOf(answerId);
//     if (optionIndex !== -1) {
//       // If the answerId exists in the option_id array, remove it
//       selectedOptions.value[index].option_id.splice(optionIndex, 1);
//     } else {
//       // If the answerId doesn't exist in the option_id array, add it
//       selectedOptions.value[index].option_id.push(answerId);
//     }
//   } else {
//     // If the question_id doesn't exist in the selectedOptions array, add it
//     selectedOptions.value.push({
//       question_id: questionId,
//       option_id: [answerId],
//     });
//   }
// };

// const updateSelected = (questionId, answerId) => {
//   // Update selected answer for the current question
//   if (selectedAnswers.value[questionId] !== answerId) {
//     selectedAnswers.value[questionId] = answerId;
//   } else {
//     selectedAnswers.value[questionId] = null;
//   }
//   let chooseFormat = [];
//   for (const question in selectedAnswers.value) {
//     chooseFormat.push({
//       question_id: question,
//       option_id: [selectedAnswers.value[question]],
//     });
//   }
//   selectedOneOption.value = chooseFormat;
// };

// const isSelected = (questionId, answerId) => {
//   // Check if the current answer is selected for the current question
//   return selectedAnswers.value[questionId] === answerId;
// };

// const isOptionSelected = (questionId, answerId) => {
//   // Check if the current answer is selected for the current question
//   const targetSelected = selectedOptions.value.filter(
//     (el) => el.question_id === questionId
//   )[0];

//   return targetSelected.option_id.includes(answerId);
// };

// const submitAnswers = async () => {
//   const quizData = [...selectedOneOption.value, ...selectedOptions.value];
//   const reqBody = { form_id: quizList.value.id, answers: quizData };

//   try {
//     const res = await fetch(`${authStore.baseUrl}/api/studentForm/${id}/edit`, {
//       method: "PATCH",
//       headers: {
//         "Content-type": `application/json`,
//         Authorization: `Bearer ${authStore.token}`,
//       },
//       body: JSON.stringify(reqBody),
//     });
//     const data = await res.json();
//     if (!data.success) {
//       throw new Error(data.message);
//     }

//     router
//       .replace({ path: `/googleformsmodule/${quizList.value.id}/examTakers` })
//       .then(() => {
//         toast.success("results updated successfully", {
//           autoClose: 2000,
//           position: "top-left",
//         });
//       });
//   } catch (error) {
//     toast.error(error.message, {
//       autoClose: 2000,
//       position: "top-left",
//     });
//   }
// };

</script>

<template>
  <NavComponent />
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
    <h2 class="text-center mt-4">{{ quizList.name }}</h2>
    <p class="fs-5 fw-bold">
      previous degree :
      <span class="text-primary">{{ quizList.studentDegree }} </span> /
      {{ quizList.degree }}
    </p>

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
        <div class="col-12 col-lg-6 pt-3" v-if="!!question.image">
          <img class="w-100" :src="question.image" alt="" />
        </div>
        <!-- Options -->


        <!-- choose & true&false -->
        <div

          :class="`option-wrapper rounded  py-2 `"
          v-for="(answer, i) in question.options"
        >


          <div
            class="bg-light border shadow-sm rounded-3 d-flex align-items-center mb-1 position-relative"
          >
            <!-- <input type="checkbox" class="btn-check" name="btncheck"  @click="checked = answer.id" :checked="checked === answer.id" @change="updateSelectedOption(answer.id, answer.question_id)" :id="answer.id"  autocomplete="off"> -->
            <input
              type="checkbox"
              class="bg-success btn-check"
              name="btncheck"
              autocomplete="off"
            />

            <label
            style="cursor: default;"
              :class="`btn btn-light  fs-5 fw-bold w-100 h-100 p-3 `"
              :for="answer.id"
              >{{ answer.option }}</label
            >
         <span v-if="answer.is_answered && answer.is_true" class="position-absolute top-50 translate-middle-y"   style="right: 16px;" v-html="svgIcons.checked" ></span>
         <i v-if="answer.is_answered && !answer.is_true" class=" fa-solid position-absolute top-50  fa-x fw-bolder text-danger translate-middle-y"style="right: 20px;" ></i>
          </div>


          <div
            class="col-12 col-lg-6"
            v-if="!!answer.image"
            :style="{
              height: answer.image ? 'auto ' : '0 !important',
            }"
          >
            <img class="w-100" :src="answer.image" alt="" />
          </div>
        </div>

        <!--  -->
      </div>
    </section>
    <!-- <div class="text-center my-5">
      <button @click.prevent="submitAnswers" class="btn btn-danger btn-lg">
        <span>Update Answers</span>
      </button>
    </div> -->
  </div>
</template>

<style scoped></style>

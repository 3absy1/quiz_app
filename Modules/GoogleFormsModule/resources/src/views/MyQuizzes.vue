<script setup>
import NavComponent from "../components/NavComponent.vue";
import { onMounted, onUpdated, ref } from "vue";
import { useAuthStore } from "../stores/auth";
import QuizCard from "../components/QuizCard.vue";
import { toast } from "vue3-toastify";
const authStore = useAuthStore();
const formsArray = ref([]);

const loader = ref(false);
onMounted(async () => {
  loader.value = true;
  getAllExams();
});

const activeQuizData = ref();

const changeActiveQuiz = (value) => {
  activeQuizData.value = value;
};

const getAllExams = async () => {
  console.log(`${authStore.baseUrl}/api/teacher/form`);
  try {
    const res = await fetch(`${authStore.baseUrl}/api/teacher/form`, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        "Accept": "application/json",
      },
    });
    if (res.status === 401) {
        authStore.handleUnauthorized();
    }
    formsArray.value = await res.json();

    loader.value = false;
  } catch (error) {
    console.log(error);
    loader.value = false;
  }
};
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
  <div class="container">
    <div class="row">
      <template v-for="quizData in formsArray.data" :key="quizData.id">
        <QuizCard
          @refetchQuizzes="getAllExams()"
          :quizData="quizData"
          :activeQuizData="activeQuizData"
          :changeActiveQuiz="changeActiveQuiz"
        />
      </template>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>

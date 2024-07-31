<script setup>
import { computed, onMounted } from "vue";
import DeleteQuizConfirmationModal from "./DeleteQuizConfirmationModal.vue";
import { useAuthStore } from "../stores/auth";

//  const { quizData,activeUserData,changeActiveUser } = defineProps(["quizData","activeQuizData","changeActiveQuiz"]);
 const props = defineProps({
    quizData: Object,
    activeQuizData: Object,
    changeActiveQuiz: Function
});

const emit = defineEmits(["refetchQuizzes"]);

const authStore = useAuthStore();

</script>

<template>
  <div class="col-12 col-lg-6 col-xl-4 p-2">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="card-title fw-bold">{{ quizData.name }}</h5>
          <a
          class="btn btn-outline-secondary fw-bold ms-2 text-muted"
            :href="`${authStore.baseUrl}/enter/${quizData.generated_id}`"
            target="_blank"
            >Open link</a
          >
        </div>
        <h6 class="card-subtitle mb-2 text-muted fw-bold">{{ quizData.degree }} points</h6>
        <p class="card-text">
          {{ quizData.desc || "" }}
        </p>


        <router-link
          class=""
          :to="{ path: `/googleformsmodule/${quizData.id}/examTakers` }"
          ><button class="btn  fw-bold me-1 mb-1 text-muted">View Exam Takers</button></router-link
        >

        <router-link :to="{ path: `/googleformsmodule/editForm/${quizData.id}` }"
          ><button class="btn btn-primary fw-bold px-4 me-1 mb-1" >
            Edit
          </button></router-link
        >
        <!-- <button @click="handelPressDeleteBtn" type="button" class="btn btn-danger fw-bold px-4 me-1 mb-1">
          Delete
        </button> -->
        <button
            class="btn btn-danger me-1 mb-1 px-4 fw-bold "
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#deleteQuizModal"
            @click.stop="changeActiveQuiz(quizData)"
          >
            Delete
          </button>

      </div>
    </div>
  </div>

  <DeleteQuizConfirmationModal @refetchQuizzes="emit('refetchQuizzes')" :quizData="activeQuizData"/>
</template>

<style lang="scss" scoped></style>

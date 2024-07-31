<template>
    <div>
      <!-- total and send functionality -->
      <div class="d-flex align-items-center justify-content-between container me-end mt-3">
        <h6 class="mt-2">Total Points : {{ formState.totalPoints }}</h6>
        <button
          @click="handlePrepareFormData"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal123"
          class="btn btn-primary ms-3"
        >
          Send
        </button>
      </div>
      <SettingsComponent />
      <QuizHomeView />
    </div>
  </template>

  <script setup>
  import NavComponent from "../components/NavComponent.vue";
  import QuizHomeView from "../components/QuizHomeView.vue";
  import SettingsComponent from "../components/SettingsComponent.vue";
  import { formStore } from "../stores/formStore";
  import { useRoute } from 'vue-router'

  const route = useRoute()
  const id = parseInt(route.params.id)
  const formState = formStore();

  const handlePrepareFormData = () => {
    formState.prepareFormData(id);
    formState.timeoutTriggered = false;
    setTimeout(() => {
      if (formState.generatedFormID === null) {
        formState.timeoutTriggered = true;
      }
    }, 6000);
  };
  </script>

  <style scoped></style>

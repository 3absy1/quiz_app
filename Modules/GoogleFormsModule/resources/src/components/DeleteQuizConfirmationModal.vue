<script setup>
import { onMounted, ref, watch } from "vue";
import { useAuthStore } from "../stores/auth";
import { toast } from "vue3-toastify";
import { closeBootstrapModalProgrammatically } from "../utils/modalUtils";
const authStore = useAuthStore();

// all students data
const props = defineProps(["quizData"]);

const emit = defineEmits(["refetchQuizzes"]);

const handleDeleteExam = async () => {
  fetch(`${authStore.baseUrl}/api/teacher/form/delete/${props.quizData.id}`, {
    method: "DELETE",
    headers: {
      Authorization: `Bearer ${authStore.token}`,
    },
  })
    .then((res) => {
      // handle token expired
      if (res.status === 401) {
        authStore.handleUnauthorized();
      }
      // handle custom back end errors
      if (!res.ok) {
        throw new Error(data.message || "something went wrong try again");
      }
      emit("refetchQuizzes");
      toast.success(`exam with id (${props.quizData.id}) was deleted`, {
        autoClose: 2000,
        position: "top-left",
      });
    })
    .catch(() => {
      toast.error("failed to delete quiz", {
        autoClose: 2000,
        position: "top-left",
      });
    });
};

// const handleDeleteConfirmation = async () => {
//     try {
//         const res = await fetch(
//             `${authStore.baseUrl}/api/student/${props.studentData.id}/delete`,
//             {
//                 method: "DELETE",
//                 headers: {
//                     Authorization: `Bearer ${authStore.token}`,
//                 },
//             },
//         );
//         const data = await res.json();

//         if (!data.success) {
//             throw new Error(data.message || "something went wrong try again");
//         }
//         toast.success("record deleted successfully", {
//             autoClose: 2000,
//             position: "top-left",
//         });
//         emit("refetchExamTakers");
//         closeBootstrapModalProgrammatically("deleteStudentRecord");
//     } catch (error) {
//         toast.error(error.message, {
//             autoClose: 2000,
//             position: "top-left",
//         });
//     }
// };
</script>

<template>
  <!-- Button trigger modal -->

  <div class="modal fade" id="deleteQuizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteQuizModal">delete record</h5>
          <button
            class="btn btn-close p-1"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body text-center text-black">
          Are you sure you want to delete the exam

          <span class="text-primary">'{{ quizData?.name }}'</span>
          ?
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-danger"
            type="button"
            data-bs-dismiss="modal"
            @click="handleDeleteExam"
          >
            confirm</button
          ><button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style></style>

<script setup>
import { onMounted, ref } from "vue";
import { useAuthStore } from "../stores/auth";
import { toast } from "vue3-toastify";
import { closeBootstrapModalProgrammatically } from "../utils/modalUtils";
const authStore = useAuthStore();

// all students data
const props = defineProps(["studentData"]);

const emit = defineEmits(["refetchExamTakers"]);

const handleDeleteConfirmation = async () => {
  try {
    const res = await fetch(
      `${authStore.baseUrl}/api/student/${props.studentData.id}/delete`,
      {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );

    if (res.status === 401) {
      authStore.handleUnauthorized();
    }
    const data = await res.json();


    if (!data.success) {
      throw new Error(data.message || "something went wrong try again");
    }
    toast.success("record deleted successfully", {
      autoClose: 2000,
      position: "top-left",
    });
    emit("refetchExamTakers");
    closeBootstrapModalProgrammatically("deleteStudentRecord");
  } catch (error) {
    toast.error(error.message, {
      autoClose: 2000,
      position: "top-left",
    });
  }
};
</script>

<template>
  <!-- Button trigger modal -->

  <div class="modal fade" id="deleteStudentRecord" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">delete record</h5>
          <button
            class="btn btn-close p-1"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body text-center text-black">
          Are you sure you want to delete the exam record for the student with email
          <span class="text-primary">'{{ studentData.user_email }}'</span>
          ?
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-danger"
            type="button"
            data-bs-dismiss="modal"
            @click.prevent="handleDeleteConfirmation"
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

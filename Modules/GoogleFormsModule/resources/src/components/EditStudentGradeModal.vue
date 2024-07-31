<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useAuthStore } from "../stores/auth";
import { toast } from "vue3-toastify";
import { closeBootstrapModalProgrammatically } from "../utils/modalUtils";
import { useRoute } from "vue-router";
import { useVuelidate } from "@vuelidate/core";
import { email, numeric } from "@vuelidate/validators";

const authStore = useAuthStore();

const route = useRoute();
const id = parseInt(route.params.id);

// to easily reset the errors later
const initialBackEndErrors = {
    user_email: "",
    degree: "",
    right_answers_count: "",
};

const backEndErrors = ref({
    ...initialBackEndErrors,
});

// all students data
const props = defineProps(["studentData"]);
const studentState = ref({ ...props.studentData });

const rules = {
    name: {},
    user_email: { email },
    degree: { numeric },
    right_answers_count: { numeric },
};

const emit = defineEmits(["refetchExamTakers"]);

const v$ = useVuelidate(rules, studentState);

// we refetch the form data when the passed id changes
watch(props, async () => {
    // clearing the back end errors

    // refetching
    const res = await fetch(
        `${authStore.baseUrl}/api/student/${props.studentData.id}`,
        {
            headers: {
                Authorization: `Bearer ${authStore.token}`,
                "Accept": "application/json",
            },
        },
    );
    if (res.status === 401) {
      authStore.handleUnauthorized();
    }
    const { data } = await res.json();
    studentState.value = { ...data[0] };
    backEndErrors.value = { ...initialBackEndErrors };
});

const handleSave = async () => {
    try {
        const res = await fetch(
            `${authStore.baseUrl}/api/student/${props.studentData.id}/edit`,
            {
                //requires an id to patch
                method: `PATCH`,
                body: JSON.stringify({
                    ...studentState.value,
                    user_name: studentState.value.name,
                    form_id: id,
                }),
                headers: {
                    "Content-type": `application/json`,
                    Authorization: `Bearer ${authStore.token}`,
                },
            },
        );
        if (res.status === 401) {
            authStore.handleUnauthorized();
         }
        const data = await res.json();
        if (!data.success) {
            if (data.messages) {
                backEndErrors.value = { ...data.messages };
            }
            throw new Error(data.message || "something went wrong try again");
        }
        emit("refetchExamTakers");
        toast.success("record updated successfully", {
            autoClose: 2000,
            position: "top-left",
        });
        // closing the modal programmatically if the req was successful
        closeBootstrapModalProgrammatically("exampleModal");
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button
                        class="btn btn-close p-1"
                        type="button"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body text-start">
                    <!-- name -->
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput"
                            >name
                        </label>
                        <input
                            class="form-control"
                            id="exampleFormControlInput"
                            type="text"
                            placeholder="name"
                            v-model="studentState.name"
                        />
                        <!-- front end errors -->
                        <ul
                            class="mt-2 mb-1"
                            v-for="error of v$.name.$silentErrors"
                            :key="error.$uid"
                        >
                            <li class="text-warning">{{ error.$message }}</li>
                        </ul>
                    </div>

                    <!-- email address -->
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput"
                            >Email address
                        </label>
                        <input
                            class="form-control"
                            id="exampleFormControlInput"
                            type="email"
                            placeholder="name@example.com"
                            v-model="studentState.user_email"
                        />
                        <!-- front end errors -->
                        <ul
                            class="mt-2 mb-1"
                            v-for="error of v$.user_email.$silentErrors"
                            :key="error.$uid"
                        >
                            <li class="text-warning">{{ error.$message }}</li>
                        </ul>
                        <!--back end errors -->
                        <ul v-if="backEndErrors.user_email">
                            <li
                                class="text-danger"
                                v-for="(
                                    error, index
                                ) in backEndErrors.user_email"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <!-- degree -->
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput"
                            >degree
                        </label>
                        <input
                            class="form-control"
                            id="exampleFormControlInput"
                            type="number"
                            min="0"
                            placeholder="student grade"
                            v-model="studentState.degree"
                        />
                        <!-- front end errors -->
                        <ul
                            class="mt-2 mb-1"
                            v-for="error of v$.degree.$silentErrors"
                            :key="error.$uid"
                        >
                            <li class="text-warning">{{ error.$message }}</li>
                        </ul>

                        <!-- list of errors -->
                        <ul v-if="backEndErrors.degree">
                            <li
                                class="text-danger"
                                v-for="(error, index) in backEndErrors.degree"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <!-- right_answers_count -->
                    <div class="mb-2">
                        <label class="form-label" for="exampleFormControlInput"
                            >right answers count
                        </label>
                        <input
                            class="form-control"
                            id="exampleFormControlInput"
                            type="number"
                            min="0"
                            placeholder="number of right answers"
                            v-model="studentState.right_answers_count"
                        />
                        <!-- front end errors -->
                        <ul
                            class="mt-2 mb-1"
                            v-for="error of v$.right_answers_count
                                .$silentErrors"
                            :key="error.$uid"
                        >
                            <li class="text-warning">{{ error.$message }}</li>
                        </ul>
                        <!-- back end errors -->
                        <ul v-if="backEndErrors.right_answers_count">
                            <li
                                class="text-danger"
                                v-for="(
                                    error, index
                                ) in backEndErrors.right_answers_count"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        class="btn btn-primary"
                        type="button"
                        @click="handleSave"
                        :disabled="v$.$invalid"
                    >
                        Save</button
                    ><button
                        class="btn btn-outline-primary"
                        type="button"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>

<template>
    <div>
        <div
            style="height: 70vh"
            v-if="isLoading"
            class="w-100 d-flex justify-content-center align-items-center"
        >
            <div
                style="width: 100px; height: 100px"
                class="spinner-border text-primary fs-1"
            ></div>
        </div>

        <div
            v-else
            class="row justify-content-start justify-content-md-between align-items-center align-items-center align-content-center"
            style="height: 100vh"
        >
            <div class="col-lg-5 col-md-6">
                <div>
                    <img
                        src="../assets/test-pic.png"
                        alt="test-pic"
                        width="100%"
                    />
                </div>
            </div>
            <div class="col-md-6 offset-lg-1">
                <!-- <div class="alert alert-danger py-1 text-center mt-4 col-lg-10 mx-lg-auto" v-if="userInfoError !== null ">{{ userInfoError }}</div> -->
                <form>
                    <div
                        v-if="generateFormObj?.require_email"
                        class="mb-3 col-lg-10 mx-lg-auto"
                    >
                        <label class="mb-1" for="name">Email:</label>
                        <input
                            id="name"
                            class="form-control"
                            type="text"
                            v-model="userName"
                            @blur="ErrorsFunc"
                        />
                        <p
                            v-for="error of v$.userName.$errors"
                            :key="error.$uid"
                        >
                            <span class="text-danger">{{
                                error.$message
                            }}</span>
                        </p>
                    </div>
                    <div
                        v-if="generateFormObj?.require_password"
                        class="mb-3 col-lg-10 mx-lg-auto"
                    >
                        <label class="mb-1" for="Password">Password:</label>
                        <input
                            id="Password"
                            class="form-control"
                            type="password"
                            v-model="password"
                            @blur="v$.password.$touch()"
                        />
                        <p
                            v-for="error of v$.password.$errors"
                            :key="error.$uid"
                        >
                            <span class="text-danger">{{
                                error.$message
                            }}</span>
                        </p>
                    </div>
                    
                    <div
                        v-if="generateFormObj?.require_phone"
                        class="mb-3 col-lg-10 mx-lg-auto"
                    >
                        <label class="mb-1" for="Password">Phone:</label>
                        <input
                            id="phone"
                            class="form-control"
                            type="number"
                            v-model="phone"
                            @blur="v$.phone.$touch()"
                        />
                        <p
                            v-for="error of v$.phone.$errors"
                            :key="error.$uid"
                        >
                            <span class="text-danger">{{
                                error.$message
                            }}</span>
                        </p>
                    </div>

                    <div class="my-3 mx-lg-auto col-lg-10">
                        <button
                            @click.prevent="submitForm"
                            class="btn btn-primary text-center"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from "pinia";
import { formStore } from "../stores/formStore";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email ,numeric} from "@vuelidate/validators";
import { toast } from "vue3-toastify";

export default {
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            isLoading: true,
            generateFormObj: {},
            userName: "",
            password: "",
            phone: "",
            userInfoError: null,
        };
    },
    validations() {
        return {
            userName: { required, email },
            password: { required },
            phone:{required,numeric}
        };
    },
    computed: {
        ...mapState(formStore, ["generatedFormID", "baseUrl"]),
    },
    methods: {
        ...mapActions(formStore, ["handleSendUserInfo"]),
        ErrorsFunc() {
            this.v$.userName.$touch();
        },

        async submitForm() {
            const formData = {
                generated_id: this.generateFormObj.generated_id,
                user_email: this.userName,
                password: this.password,
                phone: this.phone,
            };

            await fetch(
                `${this.baseUrl}/api/googleformsmodules/submitUserInfo`,
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(formData),
                },
            )
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    this.handleSendUserInfo(data.token, data.generated_id);
                    if (data.success == true) {
                        this.$router.push({
                            path: `/quiz/${data.generated_id}`,
                        });
                         localStorage.setItem("quizToken", data.token)
                        // localStorage.setItem("quizId", data.generated_id);
                    } else {
                        this.userInfoError = data.message.toString();
                        toast.error(data.message.toString(), {
                            autoClose: 2000,
                            position: "top-left",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error loading data:", error);
                });
        },
        loadData() {
            if (this.$route.params.id !== null) {
                fetch(
                    `${this.baseUrl}/api/googleformsmodules/showReq/${this.$route.params.id}`,
                    {
                        method: "GET",
                        "Accept": "application/json",
                    },
                )
                    .then((response) => response.json())
                    .then((data) => {
                        this.generateFormObj = data.data;

                        if (
                            !this.generateFormObj.require_email &&
                            !this.generateFormObj?.require_password
                        ) {
                            this.isLoading = true;
                            this.submitForm();
                        } else {
                            this.isLoading = false;
                        }
                    })
                    .catch((error) => {
                        console.error("Error loading data:", error);
                    })
                    .finally((aa) => {});
            }
        },
    },
    mounted() {
        this.loadData();
    },
};
</script>

<style></style>

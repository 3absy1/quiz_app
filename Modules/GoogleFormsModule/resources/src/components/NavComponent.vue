<template>
    <nav
        class="bg-white w-100 top-0 start-0 end-0 border-bottom border-1 z-3 shadow-sm"
    >
        <div class="container">
            <div
                class="d-flex justify-content-between align-items-center pt-4 pb-2"
            >
                <div class="d-flex align-items-center">
                    <router-link class="px-2" to="/googleformsmodule/"
                        >HOME</router-link
                    >
                    <!-- <router-link class="px-2" to="/quiz">Quiz</router-link> -->

                    <router-link class="px-2" to="/googleformsmodule/generateQuiz"
                        >Generate quiz</router-link
                    >


                    <!-- <router-link class="px-2" :to="'enter/'+generatedFormID">form</router-link> -->
                </div>
                <p class="btn btn-danger mb-0" @click="logoutHandler">Logout
                </p>
            </div>
        </div>
    </nav>

    <div
        class="modal fade popup-link"
        id="exampleModal123"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Quiz Link
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div
                        v-if="generatedFormID === null && !timeoutTriggered"
                        class="spinner-border text-primary"
                    ></div>
                    <div
                        v-else-if="generatedFormID === null && timeoutTriggered"
                    >
                        The quiz link is not available at the moment.
                    </div>
                    <div v-else class="d-flex flex-wrap align-items-center">
                        <input
                            class="w-75 ps-2"
                            v-on:focus="$event.target.select()"
                            ref="myinput"
                            readonly
                            :value="baseUrl + '/enter/' + generatedFormID"
                            disabled
                        />
                        <button
                            @click="copy"
                            class="border-0 bg-transparent"
                            v-tippy="{ content: 'Copy', placement: 'top' }"
                        >
                            <i class="fa-solid fa-copy fs-3 text-muted"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from "../stores/auth";
import { formStore } from "../stores/formStore";
import { mapState, mapActions } from "pinia";
import { RouterLink } from "vue-router";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            timeoutTriggered: false,
        };
    },
    components: {
        RouterLink,
    },
    computed: {
        ...mapState(formStore, [
            "generatedFormID",
            "baseUrl",
            "currentRouteName",
        ]),
    },
    methods: {
        ...mapActions(useAuthStore, ["logout"]),

        logoutHandler() {
            this.logout()
        },
        async copy() {
            this.$refs.myinput.select();
            try {
                await navigator.clipboard.writeText(this.$refs.myinput.value);
                toast.success("Link Copied", {
                    autoClose: 2000,
                    position: "top-left",
                });
            } catch (err) {
                console.error("Failed to copy: ", err);
            }
        },
    },
    mounted() {
        console.log(this.baseUrl);
    },
};
</script>

<style scoped>
@media (min-width: 768px) {
    .modal-dialog {
        width: 100px;
        margin: 30px auto;
    }
}
@media (min-width: 992px) {
    .modal-lg {
        width: 900px;
    }
}
@media (min-width: 768px) {
    .modal-xl {
        width: 90%;
        max-width: 1200px;
    }
}
</style>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";
import { useRouter } from "vue-router";
import { useVuelidate } from "@vuelidate/core";
import { email, required } from "@vuelidate/validators";

const authStore = useAuthStore();

const userCredentials = ref({ email: "yyy@gmail.com", password: "01224888722" });

const rules = {
  email: { email, required },
  password: { required },
};

const v$ = useVuelidate(rules, userCredentials);

const handleSubmit = () => {
  console.log(authStore.baseUrl);
  try {
    authStore.authenticate(
      userCredentials.value,
      `${authStore.baseUrl}/api/teacher/login`
    );
  } catch (error) {
    console.log(error);
  }
};
</script>

<template>
  <h1 class="mt-5 text-center">welcome to quiz app!</h1>
  <div class="row justify-content-center">
    <div class="card mt-5 p-5 col-10 col-md-8 col-lg-6">
      <form>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input
            type="email"
            v-model="userCredentials.email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
          />
          <ul class="mt-2 mb-1" v-for="error of v$.email.$silentErrors" :key="error.$uid">
            <li class="text-danger">{{ error.$message }}</li>
          </ul>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input
            v-model="userCredentials.password"
            type="password"
            class="form-control"
            id="exampleInputPassword1"
          />
        </div>
        <ul
          class="mt-2 mb-1"
          v-for="error of v$.password.$silentErrors"
          :key="error.$uid"
        >
          <li class="text-danger">{{ error.$message }}</li>
        </ul>

        <button
          type="submit"
          class="btn btn-primary"
          :disabled="v$.$invalid"
          @click.prevent="handleSubmit"
        >
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>

<template>
  <div class="container py-3">
    <div class="rounded-3 question-comp shadow-sm py-5 px-3">
      <h4 class="text-muted">Setting</h4>
      <hr />
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2" for="usernameSetting"> Username</label>
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('username')"
              role="switch"
              :checked="formSetting.username"
              id="usernameSetting"
            />
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2" for="phoneSetting"> Phone</label>
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('phone')"
              role="switch"
              :checked="formSetting.phone"
              id="phoneSetting"
            />
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2" for="PasswordSetting">Password</label>
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('password')"
              role="switch"
              :checked="formSetting.password"
              id="PasswordSetting"
            />
          </div>
        </div>
        <input
          v-if="formSetting.password"
          placeholder="Password"
          class="form-control my-1"
          v-model="formSetting.passwordValue"
          @input="touchPassField"
          type="text"
          required
        />
        <div
          v-if="v$.formSetting.passwordValue.$errors && formSetting.password"
          v-for="err in v$.formSetting.passwordValue.$errors"
          :key="err.$uid"
          class="mt-1"
        >
          <span class="text-sm text-danger">
            {{ err.$message }}
          </span>
        </div>
        <!-- <span v-if="formSetting.password" class="text-sm text-danger">{{ formSetting.passwordError }}</span> -->
        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2" for="PasswordSetting"
            >Count Of Visible Question's:</label
          >
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('userQuestionCountSwitch')"
              role="switch"
              :checked="formSetting.userQuestionCountSwitch"
              id="PasswordSetting"
            />
          </div>
        </div>
        <input
          v-if="formSetting.userQuestionCountSwitch"
          placeholder="Enter Number Of Question"
          class="form-control"
          value="0"
          v-model="formSetting.userQuestionCount"
          type="number"
          required
        />
        <!-- <span v-if="formSetting.password" class="text-sm text-danger">{{ formSetting.passwordError }}</span> -->
        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2" for="isOnceSetting">
            Take the exam only once</label
          >
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('isOnce')"
              role="switch"
              :checked="formSetting.isOnce"
              id="isOnceSetting"
            />
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2 d-block" for="timeOutSetting"
            >Take The Exam Any Time</label
          >

          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('anyTime')"
              role="switch"
              :checked="formSetting.anyTime"
              id="timeOut"
            />
          </div>
        </div>

        <div v-if="formSetting.anyTime">
          <label for="">Exam Duration (Minutes)</label>
          <input class="form-control" type="Number" v-model="formSetting.duration" />
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <label class="form-check-label me-2 d-block" for="timeOutSetting"
            >Take The Exam At A Specific Time</label
          >

          <div class="form-check form-switch">
            <input
              class="form-check-input custom-switch"
              type="checkbox"
              @click="handleSetting('specificTime')"
              :checked="formSetting.specificTime"
              role="switch"
              id="timeOutSetting"
            />
          </div>
        </div>
        <div v-if="formSetting.specificTime" class="row align-items-center">
          <div class="col-md-4 mt-3 mt-md-1">
            <label for="">Date</label>
            <input class="form-control" type="date" v-model="formSetting.examTime.date" />
          </div>
          <div class="col-md-4 mt-3 mt-md-1">
            <label for="">From</label>
            <input class="form-control" type="time" v-model="formSetting.examTime.from" />
          </div>
          <div class="col-md-4 mt-3 mt-md-1">
            <label for="">To</label>
            <input class="form-control" type="time" v-model="formSetting.examTime.to" />
          </div>
          <!-- duration switch -->
          <div class="d-flex align-items-center justify-content-between mt-2">
            <label class="form-check-label me-2 d-block" for="timeOutSetting"
              >Exam Duration</label
            >
            <div class="form-check form-switch">
              <input
                class="form-check-input custom-switch"
                type="checkbox"
                @click="handleSetting('durationSwitch')"
                :checked="formSetting.examTime.durationSwitch"
                role="switch"
                id="specificTimeDuration"
              />
            </div>
          </div>
          <!-- aaaa -->
          <div v-if="formSetting.examTime.durationSwitch" class="col-md-6 mt-1">
            <input
              class="form-control"
              placeholder="Duration"
              type="text"
              v-model="formSetting.examTime.duration"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { formStore } from "../stores/formStore";
import { mapState, mapActions } from "pinia";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
import NavComponent from "../components/NavComponent.vue";

export default {
  setup() {
    return { v$: useVuelidate() };
  },

  validations() {
    return {
      formSetting: {
        passwordValue: { required },
      },
    };
  },
  computed: {
    ...mapState(formStore, ["formSetting"]),
  },
  methods: {
    ...mapActions(formStore, ["handleSetting"]),
    touchPassField() {
      this.v$.formSetting.passwordValue.$touch();
    },
  },
  mounted() {},
};
</script>

<style></style>

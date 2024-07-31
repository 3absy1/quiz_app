<script setup>
import NavComponent from "../components/NavComponent.vue";
import { toast } from "vue3-toastify";
import { useAuthStore } from "../stores/auth";
import { formStore } from "../stores/formStore";
import { useRoute, useRouter } from "vue-router";
import { onMounted, onUnmounted, ref } from "vue";
import { svgIcons } from "../components/icons/SvgIcons";
import SettingsComponent from "../components/SettingsComponent.vue";
import QuizHomeView from "../components/QuizHomeView.vue";

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();
const formState = formStore();
const id = parseInt(route.params.id);

const isFormVisible = ref(false);

const resData = ref({});

const loader = ref(false);

const mapResDataToStore = (data) => {
  // setting form settings
  formState.formSetting.username = data.form.require_email;
  formState.formSetting.password = data.form.require_password;
  formState.formSetting.passwordValue = data.form.password || "";
  formState.formSetting.userQuestionCountSwitch = data.form.user_question_count;
  formState.formSetting.userQuestionCount = data.form.question_count;
  formState.formSetting.isOnce = data.form.using_count;
  formState.formSetting.anyTime = data.form.is_any_time;
  formState.formSetting.duration = data.form.time_out;
  formState.formSetting.specificTime = data.form.is_specific_time;

  //setting exam time settings
  formState.formSetting.examTime.date = data.form.date;
  formState.formSetting.examTime.from = data.form.start_time || "";
  formState.formSetting.examTime.to = data.form.end_time || "";
  formState.formSetting.examTime.duration = data.form.duration || "";
  formState.formSetting.examTime.durationSwitch = data.form.is_duration;

  //setting questions store
  // converting api questions into store format
  const questionsFormattedForStore = data.question.map((question) => {
    const answersFormattedForStore = question.options.map((answer, idx) => {
      return {
        id: answer.id,
        placeholder: `Option`,
        image: answer.image,
        img: null,
        label: idx + 1,
        value: answer.option,
        showImgIcon: false,
        showImgAltIcon: false,
        isCorrect: answer.is_true,
      };
    });

    return {
      formInfo: {
        section: 1,
        sectionTitle: data.form.name,
        sectionDescription: data.form.desc,
      },

      // options
      data: [...answersFormattedForStore],
      //question data
      addOtherBtn: true,
      selectedValue: question.question_type,
      selectedLabel:
        question.question_type === "TrueOrFalse"
          ? "True Or False"
          : question.question_type === "Checkboxes"
          ? "Multiple Answers"
          : question.question_type,
      selectedIcon: svgIcons.multipleChoice, // set based on type
      questionValue: question.question,
      //handling images
      questionImg: null,
      imageFileDataUrl: question.image,
      selectedInput:
        question.question_type === "Choose"
          ? "radio"
          : question.question_type === "TrueOrFalse"
          ? "text"
          : "checkbox",
      required: false,
      isSelected: false,
      regularOptions: [...answersFormattedForStore], // fill with options data later
      answerKeySelected: false,
      questionMark: question.degree,
      previousSelectedValue: undefined,
    };
  });

  formState.formList = [...questionsFormattedForStore];
};

const resetStore = () => {
  formState.formList = [
    {
      formInfo: {
        section: 1,
        sectionTitle: "Quiz 1",
        sectionDescription: null,
      },
      data: [
        {
          id: 1, // id answer
          placeholder: `Option`, // push as it is
          image: null, // push as it is for now
          img: null, // push as it is for now
          label: 1, // push with index +1
          value: "Option 1", //option
          showImgIcon: false, // as it is for now
          showImgAltIcon: false, // as it is for now
          isCorrect: true, // answer key
        },
        {
          id: 1,
          placeholder: `Option`,
          image: null,
          img: null,
          label: 2,
          value: "Option 2",
          showImgIcon: false,
          showImgAltIcon: false,
          isCorrect: false,
        },
      ],
      // flag to display other button
      addOtherBtn: true, //push as it is
      selectedValue: "Choose", //question_type
      selectedLabel: "Choose", //question_type
      selectedIcon: svgIcons.multipleChoice, //based on type
      questionValue: "Chose the correct Option ?", //question
      questionImg: null, // push as it is for now
      imageFileDataUrl: "", // push as it is for now
      selectedInput: "radio", // choose ->radio, multi -> checkbox,
      required: false, // push as it is for now
      isSelected: false, // push as it is
      regularOptions: [""], // fill it with question options
      answerKeySelected: false, // set with always true
      questionMark: 1, // question mark
      previousSelectedValue: null, // push as it is
    },
  ];

  formState.formSetting = {
    username: true,
    password: false,
    passwordValue: "",
    userQuestionCountSwitch: false,
    userQuestionCount: 0,
    isOnce: false, //test
    anyTime: true,
    duration: 30,
    specificTime: false,
    examTime: {
      date: "",
      from: "",
      to: "",
      duration: 0,
      durationSwitch: false,
    },
  };
};

const handleUpdate = async () => {
  const body = formState.prepareFormDataWithReturn();

  // adding questions id and answers id
  resData.value.question.map((question, questionidx) => {
    //appending replace image flag for question

    //getting store question object from store to check its url and image values

    body.append(`formData[${questionidx}][replaceImage]`, true);

    // appending question id
    body.append(`formData[${questionidx}][questionID]`, question.id);

    // appending answer id
    question.options.map((answer, answeridx) => {
      body.append(`formData[${questionidx}][answers][${answeridx}][optionID]`, answer.id);

      //appending replace image flag for option
    });
  });

  //formatting password as needed
  if (!body.get("formSettingData[password]")) {
    body.delete("formSettingData[passwordValue]");
  }

  console.log(body.get("formSettingData"));

  try {
    const res = await fetch(`${authStore.baseUrl}/api/form/${id}/edit`, {
      method: `POST`,
      body: body,
      headers: {
        Authorization: "Bearer " + authStore.token,
      },
    });
    if (res.status === 401) {
      useAuthStore().handleUnauthorized();
    }
    const data = await res.json();

    if (!data.success) {
      throw new Error(data.message);
    }
    router.push("/googleformsmodule/").then(() => {
      toast.success("Form has been updated successfully", {
        autoClose: 2000,
        position: "top-left",
      });
    });
  } catch (error) {
    console.log(error);

    toast.error(error.message, {
      autoClose: 2000,
      position: "top-left",
    });
  }
};

onMounted(async () => {
  loader.value = true;
  try {
    const res = await fetch(`${authStore.baseUrl}/api/teacher/form/${id}`, {
      headers: { Authorization: `Bearer ${authStore.token}` },
      "Accept": "application/json",
    });
    const data = await res.json();
    if (res.status === 401) {
      useAuthStore().handleUnauthorized();
    }
    if (!data.success) {
      throw new Error(data.message);
    }
    loader.value = false;
    mapResDataToStore(data);
    resData.value = data;

    // controlling the viability of edit form based on is_answered flag
    isFormVisible.value = !data.form.is_answered;
  } catch (error) {
    loader.value = false;
    router.push("/googleformsmodule/").then(() => {
      toast.error(error.message, {
        autoClose: 2000,
        position: "top-left",
      });
    });
  }
});

onUnmounted(() => {
  resetStore();
});
</script>

<template>
  <NavComponent />
  <!-- loader -->
  <div
    style="height: 100vh"
    v-if="loader"
    class="w-100 d-flex justify-content-center align-items-center"
  >
    <div
      style="width: 100px; height: 100px"
      class="spinner-border text-primary fs-1"
    ></div>
  </div>
  <div class="container"></div>

  <!-- settings -->
  <SettingsComponent />

  <!-- form creator -->
  <!-- -->
  <QuizHomeView v-if="isFormVisible" />
  <div class="d-flex justify-content-center">
    <button @click.prevent="handleUpdate" class="btn btn-danger mb-4 btn-lg">
      UPDATE
    </button>
  </div>
</template>

<style>
.home-comp {
  background-color: #f9f9f9;
  height: 100%;
  /* min-height: 100vh; */
}

.fixed-button-toolbar {
  position: fixed;
  transition: all 0.5s ease-in-out;
  top: 25%;
  right: 12%;
  z-index: 1000;
}
@media (max-width: 1800px) {
  .fixed-button-toolbar {
    right: 4%;
  }
}
@media (max-width: 1500px) {
  .fixed-button-toolbar {
    right: 1%;
  }
}
@media (max-width: 1200px) {
  .fixed-button-toolbar {
    right: 2%;
  }
}
@media (max-width: 1000px) {
  .fixed-button-toolbar {
    right: 2%;
  }
}
@media (max-width: 800px) {
  .fixed-button-toolbar {
    right: 16%;
  }
}

@media (max-width: 600px) {
  div.home-comp {
    width: 95% !important;
  }
  .fixed-button-toolbar {
    bottom: 0px !important;
  }
}

/* transition component */
.fade-group-enter-from {
  opacity: 0.7;
}
.fade-group-enter-active {
  transition: all 0.2s linear;
}
.fade-group-leave-to {
  transition: all 0.2s linear;
  opacity: 0.7;
}
.fade-group-move {
  transition: all 0.2s linear;
}

.tiptap.question {
  font-size: 25px;
  min-height: 50px;
  border-bottom: 1px solid black;
  line-height: 50px;
  outline: none;
  padding: 0px 10px;
  overflow-y: visible; /* Hide content that overflows */
}
</style>

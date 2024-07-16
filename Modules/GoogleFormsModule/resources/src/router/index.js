import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ModalData from "../components/ModalData.vue";
import QuizViewVue from "../views/QuizView.vue";
import EnterExamFormView from "../views/EnterExamFormView.vue";
import ResultView from "../views/ResultView.vue";
import LoginPage from "../views/LoginPage.vue";
import myQuizzes from "../views/myQuizzes.vue";
import ViewExamTakers from "../views/ViewExamTakers.vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "../stores/auth";
import QuizResultViewer from "../views/QuizResultViewer.vue";
import EditForm from "../views/editForm.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    // history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/googleformsmodule",
            name: "home",
            component: myQuizzes,
            meta: {
                title: "Home Page",
                requireAuth: true,
            },
            children: [
                {
                    path: "popup",
                    name: "popup",
                    component: ModalData,
                },
            ],
        },
        {
            path: "/googleformsmodule/login",
            name: "login",
            component: LoginPage,
            beforeEnter: (to, from) => {
                const { token } = useAuthStore();
                if (token) {
                    router.push("/googleformsmodule");
                }
            },
            meta: {
                title: "Login Page",
            },
        },
        {
            path: "/googleformsmodule/generateQuiz",
            name: "generateQuiz",
            component: HomeView,
            meta: {
                title: "All quizzes",
                requireAuth: true,
            },
        },
        {
            path: "/googleformsmodule/:id/examTakers",
            name: "examTakers",
            component: ViewExamTakers,
            meta: {
                title: "Exam Takers",
                requireAuth: true,
            },
        },
        {
            path: "/googleformsmodule/:id/quizResults",
            name: "quizResults",
            component: QuizResultViewer,
            meta: {
                title: "quiz results",
                requireAuth: true,
            },
        },
        {
            path: "/googleformsmodule/EditForm/:id",
            name: "FormEdit",
            component: EditForm,
            meta: {
                title: "edit quiz",
                requireAuth: true,
            },
        },
        {
            path: "/home",
            name: "homeAlt",
            component: HomeView,
            meta: {
                title: "Home Page",
            },
            children: [
                {
                    path: "popup",
                    name: "popup",
                    component: ModalData,
                },
            ],
        },
        {
            path: "/quiz/:id",
            name: "quiz",
            component: QuizViewVue,
            meta: {
                title: "Quiz Page",
            },
        },

        {
            path: "/enter/:id",
            name: "enter",
            component: EnterExamFormView,
            meta: {
                title: "Enter Exam Page",
            },
        },
        {
            path: "/result",
            name: "result",
            component: ResultView,
            meta: {
                title: "Result Page",
            },
        },
    ],
});
router.beforeEach((to, from, next) => {
    document.title = to.meta.title;

    return next();
});
//guarding the routs that needs auth
router.beforeEach((to, from) => {
    const { token } = useAuthStore();
    if (to.meta.requireAuth && !token) {
        return { name: "login" };
    }
});
export default router;

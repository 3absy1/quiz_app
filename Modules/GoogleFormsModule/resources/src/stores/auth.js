import { ref } from "vue";
import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import router from "../router";
import { formStore } from "../stores/formStore";
// const useFormStore = formStore()

export const useAuthStore = defineStore("authStore", () => {
    const id = ref(
        localStorage.getItem("id") ? localStorage.getItem("id") : null,
    );
    const name = ref(null);
    const email = ref(null);
    const token = ref(
        localStorage.getItem("token")
            ? JSON.parse(localStorage.getItem("token"))
            : null,
    );

    // on build uncomment below
    // const baseUrl = ref(window.location.origin);

    // on local un comment below

    const baseUrl = "https://quiz.astra-tech.net";

    const authenticate = async (credentials, url) => {
        try {
            console.log(credentials);
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(credentials),
            });
            const data = await res.json();
            // if(!data.ok){
            //     console.log("test")
            // }
            console.log(data);
            if (!data.success) {
                throw new Error(data.message);
            }
            //setting the values of the store
            email.value = data.message.email;
            id.value = data.message.id;
            name.value = data.message.name;
            token.value = data.token;

            // setting the form  store.token
            formStore().token = data.token;

            //storing the token and id in localStorage
            localStorage.setItem("token", JSON.stringify(token.value));

            localStorage.setItem("id", JSON.stringify(id.value)); // remove me  ------------->
            router.replace({ path: "/googleformsmodule" }).then(() => {
                toast.success("login successfully", {
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
    const logout = async () => {
        //clearing the data from the server
        try {
            const res = await fetch(`${baseUrl}/api/teacher/logout`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token.value}`,
                },
            });
            const data = await res.json();
            //clearing the data locally
            email.value = null;
            id.value = null;
            name.value = null;
            token.value = null;

            //clearing form store token
            formStore().token = null;

            localStorage.removeItem("token");
            localStorage.removeItem("id");

            if (!data.success) {
                throw new Error(
                    data.message || "something went wrong try again",
                );
            }
            router.push("/googleformsmodule/login").then(() => {
                toast.success(data.message, {
                    autoClose: 2000,
                    position: "top-left",
                });
            });
        } catch (error) {
            toast.error("something went wrong", {
                autoClose: 2000,
                position: "top-left",
            });
        }
    };

    const handleUnauthorized = () => {
        email.value = null;
        id.value = null;
        name.value = null;
        token.value = null;

        //clearing form store token
        formStore().token = null;

        localStorage.removeItem("token");
        localStorage.removeItem("id");

        router.push("/googleformsmodule/login").then(() => {
            toast.error("Unauthorized! please login again", {
                autoClose: 2000,
                position: "top-left",
            });
        });
    };
    return {
        id,
        name,
        token,
        email,
        authenticate,
        logout,
        handleUnauthorized,
        baseUrl,
    };
});

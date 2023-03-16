<template>
    <div class="login-container" style="height: 100vh">
        <q-card class="card">
            <div class="logo">
                <img
                    src="../../assets/logo.png"
                    class="logo_image"
                    alt="login"
                    srcset=""
                />
            </div>

            <div class="q-pa-md">
                <q-form @submit.prevent="login" class="q-gutter-md">
                    <q-input
                        v-model="formData.email"
                        label="Email *"
                        lazy-rules
                        outlined
                        :rules="[
                            (val) =>
                                (val && val.length > 0) || 'Email is required',
                        ]"
                    />

                    <q-input
                        type="password"
                        v-model="formData.password"
                        label="Password *"
                        lazy-rules
                        outlined
                        :rules="[
                            (val) =>
                                (val && val.length > 0) ||
                                'Password is required',
                        ]"
                    />

                    <div class="q-mt-lg">
                        <q-btn
                            :loading="loading"
                            class="full-width"
                            size="md"
                            color="primary"
                            label="SIgn In"
                            type="submit"
                        />
                    </div>
                </q-form>
            </div>
        </q-card>
    </div>
</template>
<script>
export default {
    name: "Login",
};
</script>
<script setup>
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();
const loading = ref(false);
const formData = ref({
    email: "",
    password: "",
});
const router = useRouter();
async function login() {
    loading.value = true;
    console.log(store.state.auth);
    await store
        .dispatch("auth/login", formData.value)
        .then((res) => {
            router.push({
                name: "Dashboard",
            });
            loading.value = false;
        })
        .catch((error) => {
            loading.value = false;
        });
}
</script>

<style lang="scss" scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}
.logo_image {
    height: 90px;
    width: 90px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid white;
}
.wave {
    height: 100%;
    position: fixed;
    left: 0;
    bottom: 0;
    z-index: -1;
}
.card {
    width: 440px;
}
.logo {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    width: 100px;
    border-radius: 50% !important;
    background-color: white;
    margin-top: -50px;
    margin: -50px auto 40px auto;
}
</style>

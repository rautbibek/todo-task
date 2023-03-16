<template>
    <div class="page_error">
        <div>
            <img class="image" src="../../../assets/404.gif" alt="logo" />

            <div style="text-align: center; margin-top: -40px">
                <h6 class="text-h4">OOPS! PAGE NOT FOUND</h6>
                <p>The page you are looking for might have been removed</p>
                <p>or is temporarily unavailable.</p>
            </div>
            <div class="text-center q-mt-md">
                <q-btn
                    @click="gotoHome"
                    unelevated
                    label="go home"
                    icon="home"
                    color="primary"
                    outline
                />
                <q-btn
                    class="q-ml-md"
                    @click="goBack"
                    unelevated
                    label="GO back"
                    icon="arrow_back"
                    color="red"
                    outline
                />
            </div>
        </div>
    </div>
</template>
<script setup>
import { useRouter } from "vue-router";
const router = useRouter();
function goBack() {
    router.go(-1);
}
function gotoHome() {
    router.push({ name: "Dashboard" });
}
</script>
<style scoped>
.page_error {
    min-height: 500px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    flex-direction: column;

    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
.image {
    width: 100%;
    max-height: 450px;
    object-fit: cover;
}
h6 {
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin: 5px;
}
.logo {
    height: 100px;
    width: 100px;

    border-radius: 50%;
}
p {
    padding: 0px;
    margin: 1px;
    color: grey;
}
.logo-container {
    margin: 10px;
}
</style>

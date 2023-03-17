<template>
    <div class="page_error">
        <!-- <div class="logo-container">
      <img class="logo" src="../../assets/logo.png" alt="logo" />
    </div> -->
        <div>
            <img class="image" src="../../../assets/403.gif" alt="logo" />

            <div style="text-align: center; margin-top: -40px">
                <h6 class="text-h4">Access Denied</h6>
                <p>The page you are trying to access has restricted access.</p>
                <p>Please refer to your system administrator</p>
            </div>
            <div class="text-center q-mt-md">
                <q-btn
                    @click="gotoHome"
                    unelevated
                    outline
                    color="primary"
                    label="home"
                    icon="home"
                />
                <q-btn
                    @click="gotoHome"
                    outline
                    class="q-ml-md"
                    unelevated
                    color="red"
                    label="back"
                    icon="arrow_back"
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
    height: 100vh;
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
    max-height: 400px;
    object-fit: cover;
}
h6 {
    font-weight: bold;
    padding: 5px;
    margin: 0px;
}
p {
    padding: 0px;
    margin: 1px;
    color: grey;
}
.logo {
    height: 100px;
    width: 100px;

    border-radius: 50%;
}
.logo-container {
    margin: 10px;
}
</style>

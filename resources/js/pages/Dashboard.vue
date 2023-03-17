<template>
    <div>
        <h6 style="padding: 0px; margin: 0px">My Projects</h6>
        <div class="">
            <div class="row q-gutter-md">
                <div
                    class="col-md-3 col-sm-6 col-xs-12 col-lg-3 q-mt-lg"
                    v-for="project in projects"
                >
                    <q-card
                        flat
                        bordered
                        clickable
                        class="my-card"
                        @click="gotoTask(project.id)"
                    >
                        <q-card-section>
                            <div class="text-h6 q-mt-sm q-mb-xs">
                                {{ project.name }}
                            </div>
                            <div class="text-overline text-orange-9">
                                {{ project.visibility ? "Public" : "Private" }}
                            </div>
                        </q-card-section>
                    </q-card>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-3 q-mt-lg">
                    <q-card flat bordered class="my-card add-new text-dark">
                        <q-card-section>
                            <q-btn
                                @click="addNewProject"
                                round
                                color="primary"
                                outline=""
                                icon="add"
                            />
                        </q-card-section>
                    </q-card>
                </div>
                <!-- <div class="col-3 col-md-3 q-mt-lg">
                    <q-card flat bordered class="my-card add-new text-dark">
                        <q-card-section>
                            <q-btn
                                round
                                color="primary"
                                outline=""
                                icon="add"
                            />
                        </q-card-section>
                    </q-card>
                </div>
                <div class="col-3 col-md-3 q-mt-lg">
                    <q-card flat bordered class="my-card add-new text-dark">
                        <q-card-section>
                            <q-btn
                                round
                                color="primary"
                                outline=""
                                icon="add"
                            />
                        </q-card-section>
                    </q-card>
                </div>
                <div class="col-3 col-md-3 q-mt-lg">
                    <q-card flat bordered class="my-card add-new text-dark">
                        <q-card-section>
                            <q-btn
                                round
                                color="primary"
                                outline=""
                                icon="add"
                            />
                        </q-card-section>
                    </q-card>
                </div> -->
            </div>
        </div>
        <q-dialog v-model="add_project_model">
            <q-card>
                <q-form
                    @submit="onSubmit"
                    @reset="onReset"
                    class="q-gutter-md"
                    ref="form"
                >
                    <q-card-section>
                        <div class="text-h6">Add new project</div>
                    </q-card-section>

                    <q-separator />

                    <q-card-section
                        style="max-height: 50vh; min-width: 400px"
                        class="scroll"
                    >
                        <q-input
                            outlined
                            dense
                            v-model="formData.name"
                            label="Project Name*"
                            lazy-rules
                            class="q-mb-md"
                            :rules="[
                                (val) =>
                                    (val && val.length > 0) ||
                                    'Please type something',
                            ]"
                        />

                        <q-toggle
                            v-model="formData.visibility"
                            label="Visibility"
                        />
                    </q-card-section>

                    <q-separator />

                    <q-card-actions align="right" class="">
                        <q-btn
                            color="red"
                            outlined
                            class="q-mr-sm"
                            @click="closeModel"
                            ><q-icon small name="close" left> </q-icon>
                            Cancel</q-btn
                        >
                        <q-btn
                            :loading="loading"
                            type="submit"
                            color="green"
                            outline
                        >
                            <q-icon small name="save" left> </q-icon> save
                        </q-btn>
                    </q-card-actions>
                </q-form>
            </q-card>
        </q-dialog>
    </div>
</template>

<script setup>
import { useQuasar } from "quasar";
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import axiosClient from "../interceptor/axios";
const add_project_model = ref(false);
const loading = ref(false);
const router = useRouter();
const form = ref(null);
const projects = ref({});
const $q = useQuasar();
const formData = ref({
    name: "",
    visibility: false,
});
function closeModel() {
    add_project_model.value = false;
    formData.value = {};
}
function addNewProject() {
    add_project_model.value = true;
}
function onSubmit() {
    loading.value = true;
    form.value.validate().then((success) => {
        if (success) {
            axiosClient
                .post("/project/store", formData.value)
                .then((res) => {
                    loading.value = false;
                    add_project_model.value = false;
                    formData.value = {};
                    getProjectData();
                })
                .catch((error) => {
                    loading.value = false;
                });
        }
        loading.value = false;
    });
}
function getProjectData() {
    $q.loading.show();
    axiosClient
        .get("project")
        .then((res) => {
            console.log(res.data);
            projects.value = res.data.projects;
            $q.loading.hide();
        })
        .catch((error) => {
            console.log(error);
            $q.loading.hide();
        });
}
getProjectData();

function gotoTask(id) {
    router.push({ name: "Task", params: { id: id } });
}
</script>

<style lang="scss" scoped>
.my-card {
    width: 100%;
    min-height: 120px;
    cursor: pointer;
}
.add-new {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

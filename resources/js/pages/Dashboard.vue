<template>
    <div>
        <h6 style="padding: 0px; margin: 0px">My Projects</h6>
        <div class="">
            <div class="row q-gutter-md">
                <div
                    class="col-md-3 col-sm-6 col-xs-12 col-lg-3 q-mt-lg"
                    v-for="project in projects"
                >
                    <q-card flat bordered clickable class="my-card">
                        <q-card-section @click="gotoTask(project.id)">
                            <div
                                class="text-h6 q-mt-sm q-mb-xs"
                                style="text-transform: capitalize"
                            >
                                {{ project.name }}
                            </div>
                            <div class="text-overline text-orange-9">
                                {{ project.visibility ? "Public" : "Private" }}
                            </div>
                        </q-card-section>

                        <q-card-actions align="right">
                            <q-btn
                                @click="confirmation(project.id)"
                                flat
                                round
                                color="red"
                                small
                                icon="delete"
                            />
                            <q-btn
                                flat
                                round
                                color="primary"
                                small
                                icon="edit"
                                @click="edit(project)"
                            />
                        </q-card-actions>
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
                        <q-separator />
                    </q-card>
                </div>
            </div>
        </div>
        <q-dialog v-model="add_project_model">
            <q-card>
                <q-form @submit="onSubmit" class="q-gutter-md" ref="form">
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
                            :true-value="1"
                            :false-value="0"
                            label="Visibility (public or private)"
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
                            <q-icon
                                small
                                :name="edit_item ? 'update' : 'save'"
                                left
                            >
                            </q-icon>
                            <span v-if="edit_item">Update</span
                            ><span v-else>save</span>
                        </q-btn>
                    </q-card-actions>
                </q-form>
            </q-card>
        </q-dialog>
        <q-dialog v-model="confirm" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar
                        icon="message"
                        color="primary"
                        outline
                        text-color="white"
                    />
                    <span class="q-ml-sm"
                        >Are you sure to want to delete this project</span
                    >
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn color="red" label="Cancel" outline v-close-popup />
                    <q-btn
                        outline
                        label="ok"
                        color="primary"
                        @click="removeProject(project_id)"
                    />
                </q-card-actions>
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
const confirm = ref(false);
const project_id = ref(null);
const edit_item = ref(false);
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
    edit_item.value = false;
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

function confirmation(id) {
    confirm.value = true;
    project_id.value = id;
}

function removeProject(id) {
    axiosClient
        .delete(`/project/${id}/delete`)
        .then((res) => {
            getProjectData();
            confirm.value = false;
        })
        .catch((error) => {
            //
        });
}
function edit(item) {
    edit_item.value = true;
    formData.value = item;
    add_project_model.value = true;
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
    min-height: 170px;
    justify-content: center;
    align-items: center;
}
</style>

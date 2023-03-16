<template>
    <div>
        <div class="header">
            <h6 style="margin: 0px">{{ project.name }}</h6>
            <q-btn color="primary" size="small" @click="addNewCard">
                <q-icon name="add" left></q-icon>add new card</q-btn
            >
        </div>
        <div class="wrapper">
            <div class="scrolls">
                <div v-for="card in cards" :key="card.id">
                    <q-card flat bordered class="my-card add-new text-dark">
                        <q-item>
                            <q-item-section>
                                <q-item-label
                                    style="
                                        text-transform: capitalize;
                                        display: flex;
                                        justify-content: space-between;
                                    "
                                    >{{ card.title }}
                                </q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-separator />
                        <div
                            style="
                                padding: 10px;
                                background: white;
                                border: 1px solid #d9d1d1;
                                margin: 10px;
                                border-radius: 5px;
                                white-space: pre-line;
                            "
                            v-for="task in card.tasks"
                        >
                            {{ task.title }}
                        </div>

                        <div>
                            <q-item
                                clickable
                                v-ripple
                                @click="addNewTask(card.id)"
                            >
                                <q-item-section avatar>
                                    <q-icon name="add" />
                                </q-item-section>

                                <q-item-section>Add new task</q-item-section>
                            </q-item>
                        </div>
                    </q-card>
                </div>
            </div>
        </div>
        <q-dialog v-model="add_new_card">
            <q-card>
                <q-form @submit="onSubmit" class="q-gutter-md" ref="form">
                    <q-card-section>
                        <div class="text-h6">Add new card</div>
                    </q-card-section>

                    <q-separator />

                    <q-card-section
                        style="max-height: 50vh; min-width: 400px"
                        class="scroll"
                    >
                        <q-input
                            outlined
                            dense
                            v-model="formData.title"
                            label="Card Title*"
                            lazy-rules
                            class="q-mb-md"
                            :rules="[
                                (val) =>
                                    (val && val.length > 0) ||
                                    'card name required',
                            ]"
                        />
                    </q-card-section>

                    <q-separator />

                    <q-card-actions align="right" class="">
                        <q-btn
                            color="red"
                            outlined
                            class="q-mr-sm"
                            @click="add_new_card = !add_new_card"
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
        <q-dialog v-model="task_modal">
            <q-card>
                <q-form @submit="storeTask" class="q-gutter-md" ref="task_form">
                    <q-separator />

                    <q-card-section
                        style="max-height: 50vh; min-width: 500px"
                        class="scroll"
                    >
                        <q-input
                            type="textarea"
                            outlined
                            dense
                            rows="2"
                            v-model="taskData.title"
                            label="Task*"
                            lazy-rules
                            :rules="[
                                (val) =>
                                    (val && val.length > 0) || '* required',
                            ]"
                        />
                        <q-select
                            outlined
                            dense
                            option-value
                            v-model="taskData.priority"
                            :options="task_priority"
                            label="Priority"
                            class="q-mb-md"
                        />
                        <q-input
                            type="textarea"
                            outlined
                            dense
                            rows="7"
                            v-model="taskData.description"
                            label="Task Detail"
                            lazy-rules
                            class="q-mb-md"
                        />
                    </q-card-section>

                    <q-separator />

                    <q-card-actions align="right" class="">
                        <q-btn
                            color="red"
                            outlined
                            class="q-mr-sm"
                            @click="task_modal = !task_modal"
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
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import axiosClient from "../interceptor/axios";
const loading = ref(false);
const add_new_card = ref(false);
const taskData = ref({});
const card_id = ref(null);
const cards = ref({});
const project = ref({});
const formData = ref({});
const task_modal = ref(false);
const router = useRouter();
const route = useRoute();
const form = ref(null);
const task_form = ref(null);
function addNewCard() {
    add_new_card.value = !add_new_card.value;
}

function onSubmit() {
    loading.value = true;
    form.value.validate().then((success) => {
        if (success) {
            axiosClient
                .post("card/store", {
                    title: formData.value.title,
                    project_id: route.params.id,
                })
                .then((res) => {
                    loading.value = false;
                    add_new_card.value = false;
                    getProjectCards();
                    // getProjectData();
                })
                .catch((error) => {
                    loading.value = false;
                });
        }
        loading.value = false;
    });
}
function getProjectCards() {
    axiosClient
        .get(`/card/${route.params.id}`)
        .then((res) => {
            cards.value = res.data.cards;
            project.value = res.data.project;
        })
        .catch((error) => {
            console.log(error);
        });
}
getProjectCards();
function addNewTask(id) {
    task_modal.value = true;
    card_id.value = id;
}
function storeTask() {
    loading.value = true;
    task_form.value.validate().then((success) => {
        if (success) {
            axiosClient
                .post("task/store", {
                    title: taskData.value.title,
                    description: taskData.value.description,
                    card_id: card_id.value,
                })
                .then((res) => {
                    loading.value = false;
                    task_modal.value = false;
                    getProjectCards();

                    // getProjectData();
                })
                .catch((error) => {
                    loading.value = false;
                });
        }
        loading.value = false;
    });
}
const task_priority = ref([
    {
        label: "High",
        value: "high",
    },
    {
        label: "Medium",
        value: "medium",
    },
    {
        label: "Low",
        value: "low",
    },
]);
</script>

<style lang="scss" scoped>
.scrolls {
    display: flex;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
    min-height: calc(100vh - 100px);
    padding: 20px;
    gap: 20px;
}
.my-card {
    width: 290px;
    min-height: 100px;
    cursor: pointer;
}
.header {
    display: flex;
    justify-content: space-between;
}
</style>

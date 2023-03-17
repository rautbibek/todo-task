<template>
    <div>
        <div class="header">
            <h6 style="margin: 0px">{{ project.name }}</h6>
            <q-btn
                v-if="cards.length > 0"
                color="primary"
                size="small"
                @click="addNewCard"
            >
                <q-icon name="add" left></q-icon>add new card</q-btn
            >
        </div>
        <div v-if="cards.length > 0">
            <div class="wrapper">
                <draggable
                    class="scrolls"
                    v-model="cards"
                    @start="startDrag()"
                    @end="drag = false"
                    :move="checkMove"
                    :drag="drag"
                    item-key="order"
                    tag="q-item-label"
                    :component-data="{
                        tag: 'q-item-section',
                        name: 'flip-list',
                        type: 'transition',
                    }"
                    dragClass="drag"
                    ghostClass="ghost"
                >
                    <template #item="{ element }">
                        <div>
                            <q-card
                                flat
                                bordered
                                class="my-card add-new text-dark"
                            >
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            style="
                                                text-transform: capitalize;
                                                display: flex;
                                                font-weight: bold;
                                                justify-content: space-between;
                                            "
                                            >{{ element.title }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>

                                <draggable
                                    :key="element.id"
                                    dragClass="task_drag"
                                    ghostClass="task_ghost"
                                    group="cards"
                                    @start="drag = true"
                                    @end="drag = false"
                                    item-key="order"
                                    :drag="drag"
                                    @change="checkTaskPosition"
                                    @update="updateOrder"
                                    @sort="sortedData"
                                    :options="{
                                        animation: 2000,
                                        group: 'task',
                                    }"
                                    v-model="element.tasks"
                                >
                                    <template #item="{ element }">
                                        <div class="draggable_card_container">
                                            <div class="card_list">
                                                <span>{{ element.title }}</span>
                                                <q-icon
                                                    @click="editTask(element)"
                                                    style="color: gray"
                                                    name="edit"
                                                ></q-icon>
                                            </div>
                                        </div>
                                    </template>
                                </draggable>

                                <div>
                                    <q-item
                                        clickable
                                        v-ripple
                                        @click="addNewTask(element.id)"
                                    >
                                        <q-item-section avatar>
                                            <q-icon name="add" />
                                        </q-item-section>

                                        <q-item-section
                                            >Add new task</q-item-section
                                        >
                                    </q-item>
                                </div>
                            </q-card>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
        <div v-else class="col-md-3 col-sm-6 col-xs-12 col-lg-3 q-mt-lg">
            <q-card
                flat
                bordered
                class="my-card"
                style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                "
            >
                <q-btn
                    @click="addNewCard"
                    round
                    color="primary"
                    outline=""
                    icon="add"
                />
            </q-card>
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
                            @click="cancelCardForm"
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
                            v-model="taskData.priority"
                            :options="task_priority"
                            label="Priority"
                            option-value="value"
                            option-label="label"
                            emit-value
                            class="q-mb-md"
                            :rules="[
                                (val) =>
                                    (val && val.length > 0) || '* required',
                            ]"
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
                            @click="cancelTaskFrom"
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
                                :name="edit_action ? 'update' : 'save'"
                                left
                            >
                            </q-icon>
                            <span v-if="edit_action">Update</span
                            ><span v-else>Save</span>
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
import draggable from "vuedraggable";
const loading = ref(false);
const add_new_card = ref(false);
const taskData = ref({});
const card_id = ref(null);
const cards = ref([]);
const edit_action = ref(false);
const show_edit_icon = ref(false);
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
function editTask(item) {
    card_id.value = item.card_id;
    edit_action.value = true;
    taskData.value = item;
    task_modal.value = true;
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
                    formData.value = {};
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
function cancelTaskFrom() {
    task_modal.value = false;
    taskData.value = {};
}
function cancelCardForm() {
    add_new_card.value = false;
    formData.value = {};
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
                    id: taskData.value.id,
                    priority: taskData.value.priority,
                })
                .then((res) => {
                    loading.value = false;
                    task_modal.value = false;
                    taskData.value = {};
                    getProjectCards();
                })
                .catch((error) => {
                    loading.value = false;
                });
        }
        loading.value = false;
    });
}
function checkMove(evt) {
    console.log(evt.draggedContext.element);
    //return (evt.draggedContext.element.name!=='apple');
}
function drag() {
    console.log("test");
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

function checkTaskPosition(e) {
    let item = e.added || e.moved;
    if (!item) return;
    if (e.moved) {
        cards.value.forEach((card) => {
            const data = card.tasks.find(
                (element) => element.id == e.moved.element.id
            );
            if (data) {
                axiosClient
                    .put("/task/update-moved-card-order", card)
                    .then((res) => {})
                    .catch((error) => {});
            }
            return;
        });
    }
    if (e.added) {
        cards.value.forEach((card) => {
            const data = card.tasks.find(
                (element) => element.id == e.added.element.id
            );
            if (data) {
                axiosClient
                    .put("/task/update-moved-card-order", card)
                    .then((res) => {})
                    .catch((error) => {});
            }
            return;
        });
    }

    //console.log({ previous: prevCard, next: nextCard, current: card });
}
</script>

<style lang="scss" scoped>
.scrolls {
    display: flex;
    overflow-x: scroll;
    overflow-y: scroll;
    white-space: nowrap;
    min-height: calc(100vh - 100px);
    padding: 0px;
    gap: 20px;
}
.drag > div {
    transform: rotate(5deg);
}
.ghost {
    background-color: lightgray;
    border-radius: 6px;
}
.ghost > div {
    visibility: hidden;
}

.task_drag > * {
    transform: rotate(5deg) !important;
}
.task_ghost > div {
    background-color: lightgray;
    border-radius: 6px;
}
.task_ghost > div > * {
    visibility: hidden;
}
.my-card {
    margin-top: 20px;
    width: 290px;
    min-height: 100px;
    cursor: pointer;
    background-color: #e5e6ea;
}
.header {
    display: flex;
    justify-content: space-between;
}
.card_list {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    background: white;
    border: 1px solid #d9d1d1;
    margin: 10px;
    border-radius: 5px;
    white-space: pre-line;
}
</style>

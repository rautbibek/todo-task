<template>
    <div>
        <div class="header">
            <h6 style="margin: 0px">Project Name</h6>
            <q-btn color="primary" size="small" @click="addNewCard">
                <q-icon name="add" left></q-icon>add new card</q-btn
            >
        </div>
        <div class="wrapper">
            <div class="scrolls">
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
                <div class="">
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
            </div>
        </div>
        <q-dialog v-model="add_new_card">
            <q-card>
                <q-form
                    @submit="onSubmit"
                    @reset="onReset"
                    class="q-gutter-md"
                    ref="form"
                >
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
                            v-model="formData.name"
                            label="Card Name*"
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
    </div>
</template>

<script setup>
import { ref } from "vue";

const loading = ref(false);
const add_new_card = ref(false);
const formData = ref({});
function addNewCard() {
    add_new_card.value = !add_new_card.value;
}
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

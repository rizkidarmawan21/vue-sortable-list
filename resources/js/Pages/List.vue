<script setup>
import axios from "axios";
import { ref } from "vue";
import Draggable from "vuedraggable";

const props = defineProps({
    users: {
        type: Array,
    },
});

const dragging = ref(false);

function checkMove(e) {
    console.log("Future index: " + e.draggedContext.futureIndex);
}

async function dragEnd(e) {
    const users = props.users;
    const newData = users.map((data, index) => {
        return {
            ...data,
            position: index + 1,
        };
    });

    axios
        .post(route("update.order"), {
            data: newData,
        })
        .then((response) => {
            console.log(response.data);
            alert("Order Updated Successfully");
        })
        .catch((error) => {
            console.log(error);
            alert("Order Update Failed");
        })
        .finally(() => {
            dragging.value = false;
        });
}
</script>

<template>
    <div
        class="w-full h-screen flex flex-col items-center justify-center space-y-2"
    >
        <button
            class="bg-blue-500 text-white px-3 py-1 rounded"
            @click="dragging = !dragging"
        >
            Edit Order
        </button>
        <div class="w-1/3 min-h-[400px] bg-slate-50 p-5 rounded-lg">
            <Draggable
                :list="users"
                :disabled="!dragging"
                handle=".handle"
                class="w-full space-y-2"
                ghost-class="ghost"
                @update="dragEnd"
            >
                <template #item="{ element }">
                    <div
                        class="w-full flex justify-between items-center bg-slate-200 p-3 rounded-lg"
                    >
                        <h1>{{ element.name }}</h1>
                        <button v-if="dragging" class="handle text-black">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="2em"
                                height="2em"
                                viewBox="0 0 24 24"
                            >
                                <rect width="24" height="24" fill="none" />
                                <path
                                    fill="currentColor"
                                    d="M7 19v-2h2v2zm4 0v-2h2v2zm4 0v-2h2v2zm-8-4v-2h2v2zm4 0v-2h2v2zm4 0v-2h2v2zm-8-4V9h2v2zm4 0V9h2v2zm4 0V9h2v2zM7 7V5h2v2zm4 0V5h2v2zm4 0V5h2v2z"
                                />
                            </svg>
                        </button>
                    </div>
                </template>
            </Draggable>
        </div>
    </div>

    <ul>
        <li v-for="user in users" :key="user.id">
            {{ user.name }} / {{ user.position }}
        </li>
    </ul>
</template>

<style scoped>
.ghost {
    opacity: 0.5;
    background: #f1f1f1;
}
</style>

<script setup>
import CartTableRow from "./CartTableRow.vue";
import { useForm } from "@inertiajs/vue3";
import { useCartStore } from "@/stores/CartStore";
import { computed, onUnmounted } from "vue";

const props = defineProps({
    patient_id: {
        type: Number,
        required: true,
    },
    full_name: {
        type: String,
    },
});

const cart = useCartStore();

const form = useForm({
    orderItems: [],
    patientId: props.patient_id,
});

const submit = () => {
    form.orderItems = [...cart.orderItems];
    form.post(route("order-items.store", props.patient_id), {
        onSuccess: () => {
            form.reset();
        },
    });
};

const errors = computed(() => {
    const errors = Object.values(form.errors);
    return errors;
});
onUnmounted(() => {
    cart.orderedItemsReset();
});


</script>

<template>
    <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
    >
        <form @submit.prevent="submit(1)">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-xl font-medium mb-4">Cart</h2>
                <h2
                    class="text-2xl font-medium mb-8 uppercase text-cyan-700 font-medium"
                >
                    {{ full_name }}
                </h2>
                <ul class="list-disc mb-3 ml-5" v-if="errors">
                    <li class="text-sm text-red-500" v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-900 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th></th>
                            <th
                                scope="col"
                                class="p-4 text-xs"
                                style="width: 260px"
                            >
                                Item Name
                            </th>
                            <th scope="col" class="p-4 text-xs" style="width: 120px;">Quantity</th>
                            <th scope="col" class="p-4 text-xs">Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <CartTableRow
                            v-for="orderedItem in cart.orderItems"
                            :key="orderedItem.id"
                            :orderedItem="orderedItem"
                        />
                    </tbody>
                </table>

                <button
                    v-if="cart.orderItems.length"
                    type="submit"
                    :class="{
                        'opacity-25 cursor-not-allowed': form.processing,
                    }"
                    :disabled="form.processing"
                    class="w-full mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Save
                </button>

            </div>
        </form>
    </div>
</template>

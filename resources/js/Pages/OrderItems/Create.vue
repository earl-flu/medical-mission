<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import OrderItemRow from "./Components/OrderItemRow.vue";
import Cart from "./Components/Cart.vue";


import throttle from "lodash/throttle";
import { ref, watch } from 'vue';

const props = defineProps({
    items: { //for list of available items
        type: Object,
        required: true
    },
    full_name: {
        type: String,
    },
    patient_id: {
        type: Number,
        required: true,
    },
    filters: Object,
})



const search = ref(props.filters.search || '')


watch(search, throttle(function (search) {
    router.get(route('order-items.create', props.patient_id), {
        search
    },
        { preserveState: true, replace: true, })
}, 300))



</script>


<template>
    <Head title="Patient - Order Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Patient - Order Items</h2>
            <p class="text-xs text-gray-500 mt-2 ">
                <Link :href="route('patients.index')"><span class="text-indigo-500">Patients</span> </Link> >
                <Link :href="route('patients.show', props.patient_id)"><span class="text-indigo-500">{{ full_name }}</span>
                </Link> >
                Add Order
            </p>
        </template>
        <div class="py-12 px-8 flex justify-center max-w-7xl mx-auto gap-8">
            <div class="flex-1">
                <!-- Cart Here -->
                <Cart :patient_id="props.patient_id" :full_name="full_name"/>
            </div>
            <div class="mx-auto" style="width: 500px;">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-medium mb-4">Items</h2>
                        <div class="mb-10">
                            <div class="relative z-0 w-full mb-6 group">
                                <TextInput name="search" id="search" type="text" class="mt-1 block w-full"
                                    placeholder="Search..." v-model="search" required autocomplete="off" />
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Item name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <OrderItemRow v-for="item in items.data" :key="item.id" :item="item" />
                                </tbody>
                            </table>
                            <p v-if="!items.data.length" class="text-red-500 text-xs text-center font-medium uppercase p-5">
                                No
                                Items</p>
                        </div>

                        <div class="mt-6 flex">
                            <div class="flex-1"></div>
                            <Pagination :links="items.links" v-if="items.total" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
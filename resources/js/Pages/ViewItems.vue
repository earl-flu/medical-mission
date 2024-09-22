<script setup>
import { Head, router } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ViewItemRow from '@/Components/ItemRowGuest.vue';
import { ref, watch } from 'vue';
import throttle from "lodash/throttle";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    items: {
        type: Object,
        required: true,
    },
    filters: Object,
})

const search = ref(props.filters.search || '')


watch(search, throttle(function (search) {
    router.get(route('view.items'), {
        search
    },
        { preserveState: true, preserveScroll: true, replace: true, })
}, 300))

</script>

<template>
    <Head title="Inventory" />
    <div class="relative min-h-screen 
         bg-gradient-to-r from-cyan-500 to-blue-900 selection:bg-red-500 selection:text-white">

        <div class="max-w-7xl p-6 lg:p-8">
            <div class="flex">
                <div class="text-white text-xl flex gap-4 uppercase">
                    <div class="image-logos flex gap-1">
                        <img style="height:70px" src="/images/catanduanes-official-seal.png" alt="PLGU Catanduanes Logo">
                        <img style="height:70px" src="/images/CIA-LOGO.png" alt="CIA Logo">
                    </div>
                    <div>
                        <p class="text-xs">Catanduanes International Association, Inc.</p>
                        <p class="text-2xl font-bold">11<span>ᵗʰ</span> Medical Mission</p>
                        <p class="text-xs">"We Care About Catanduanes"</p>
                        <!-- <p class="text-xs opacity-25 mt-2">January 22-26, 2024</p>
                        <p class="text-xs opacity-25 ">PHO Warehouse, EBMC Compound</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-xl mb-5 font-bold text-white uppercase mt-5">Inventory</h1>
            <div class="p-6 text-gray-900 dark:text-gray-100 bg-gray-100 rounded-lg">
                <div class="mb-10">
                    <div class="relative z-0 w-full mb-6 group">
                        <InputLabel for="search" value="Search" />
                        <TextInput name="search" id="search" type="text" class="mt-1 block w-full" placeholder="Item Name"
                            v-model="search" required autocomplete="off" />
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Item name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Restock Threshold
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <ViewItemRow v-for="item in items.data" :key="item.id" :item="item" />
                        </tbody>
                    </table>
                    <p v-if="!items.data.length" class="text-red-500 text-xs text-center font-medium uppercase p-5">
                        NO ITEMS FOUND
                    </p>
                </div>

                <div class="mt-6 flex">
                    <div class="flex-1"></div>
                    <Pagination :links="items.links" v-if="items.total" />
                </div>
            </div>
        </div>
        <!-- <div class="absolute w-full bg-black bottom-0 left-0 text-white px-5 py-2">
            <div class="max-w-7xl text-xs text-gray-200">
                This web application is developed and maintained by PHO Catanduanes, IT Unit.
            </div>
        </div> -->
    </div>
</template>

<style>
th,
td {
    text-wrap: wrap !important;
}

.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>

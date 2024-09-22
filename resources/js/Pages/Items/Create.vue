<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';


const form = useForm({
    name: '',
    quantity: '',
    restock_threshold: '',
})

const submit = () => {
    form.post(route('items.store'), {
        onSuccess: () => { form.reset() }
    });
};

</script>


<template>
    <Head title="Add Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add Item</h2>
        </template>
        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit()">

                            <div class="">
                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="name" value="Item Name*" />
                                    <TextInput name="name" id="name" type="text" class="mt-1 block w-full" placeholder=" "
                                        v-model="form.name" required autocomplete="name" />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="quantity" value="Quantity*" />
                                    <TextInput name="quantity" id="quantity" type="number" class="mt-1 block w-full"
                                        placeholder=" " v-model="form.quantity" required autocomplete="quantity" />

                                    <InputError class="mt-2" :message="form.errors.quantity" />
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="restock_threshold" value="Restock Threshold*" />
                                    <TextInput name="restock_threshold" id="restock_threshold" type="number" class="mt-1 block w-full"
                                        placeholder=" " v-model="form.restock_threshold" required autocomplete="restock_threshold" />

                                    <InputError class="mt-2" :message="form.errors.restock_threshold" />
                                </div>
                            </div>
                            <button type="submit" :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
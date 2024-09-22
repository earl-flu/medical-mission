<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    medical_record: {
        type: Object,
        required: true,
    },
    full_name: {
        type: String,
        required: true,
    },
    diagnoses: {
        type: Array,
        required: true
    }
})

const form = useForm({
    name: '',
})

const submit = () => {
    form.post(route('diagnoses.store'), {
        onSuccess: () => { form.reset() }
    });
};

</script>


<template>
    <Head title="Diagnosis - Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Diagnosis</h2>
        </template>
        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit()">

                            <div class="">
                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="name" value="Diagnosis Desc*" />
                                    <TextInput name="name" id="name" type="text" class="mt-1 block w-full" placeholder=" "
                                        v-model="form.name" required autofocus autocomplete="name" />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
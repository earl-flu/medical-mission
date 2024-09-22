<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    import_file: null
})

const submit = () => {
    form.post(route('items.storeImport'), {
        onSuccess: () => { form.reset() }
    });
};

</script>


<template>
    <Head title="Import Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Import Items</h2>
            <p class="text-xs text-gray-500 mt-2 ">

                <span>Import Items</span>
            </p>
        </template>
        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="relative z-0 w-full mb-6 group">
                                <InputLabel for="import_file" value="File*" />
                                <input type="file" @input="form.import_file = $event.target.files[0]" />
                                <InputError class="mt-2" :message="form.errors.import_file" />
                            </div>
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                            <button type="submit" :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                                focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5
                                 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
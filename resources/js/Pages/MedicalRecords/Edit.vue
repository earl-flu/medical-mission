<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();

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
    ...props.medical_record
})

const submit = () => {
    form.put(route('medical-records.update', [props.medical_record.id]), {
        onSuccess: () => {
            showToast(`${props.full_name}, medical record updated!`);
            form.reset()
        }
    });
};

</script>


<template>
    <Head title="Medical Record - Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Medical Record</h2>
            <p class="text-xs text-gray-500 mt-2 ">
                <Link :href="route('patients.index')"><span class="text-indigo-500">Patients</span></Link> >
                <Link :href="route('patients.show', $props.medical_record.patient.id)"><span class="uppercase text-indigo-500">{{
                    full_name
                }}</span></Link> >
                <span>Edit Medical Record</span>
            </p>
        </template>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="text-xl font-bold text-cyan-700 uppercase mb-6">{{ full_name }} - Medical Record</h1>
                        <form @submit.prevent="submit()">
                            <div class="grid md:grid-cols-3 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <label class="flex items-center">
                                        <Checkbox v-bind:checked="form.is_opto == 1" name="remember"
                                            v-model:checked="form.is_opto" />
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Needs Opto</span>
                                    </label>
                                </div>

                                <div class="relative z-0 w-full mb-6 group" v-if="form.patient.sex == '0'">
                                    <label class="flex items-center">
                                        <Checkbox name="remember" v-bind:checked="form.is_pregnant == 1"
                                            v-model:checked="form.is_pregnant" />
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Pregnant</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="temperature" value="Temperature* (deg)" />
                                    <TextInput name="temperature" id="temperature" type="number" step="0.1"
                                        class="mt-1 block w-full" placeholder=" " v-model="form.temperature" required
                                        autofocus autocomplete="temperature" />

                                    <InputError class="mt-2" :message="form.errors.temperature" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="bp_systolic" value="BP Systolic*" />
                                    <TextInput name="bp_systolic" id="bp_systolic" type="number" class="mt-1 block w-full"
                                        placeholder="120" v-model="form.bp_systolic" required autofocus
                                        autocomplete="bp_systolic" />

                                    <InputError class="mt-2" :message="form.errors.temperature" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="bp_diastolic" value="BP Diastolic*" />
                                    <TextInput name="bp_diastolic" id="bp_diastolic" type="number" class="mt-1 block w-full"
                                        placeholder="80" v-model="form.bp_diastolic" required autofocus
                                        autocomplete="bp_diastolic" />

                                    <InputError class="mt-2" :message="form.errors.bp_diastolic" />
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="respiratory_rate" value="Respiratory Rate" />
                                    <TextInput name="respiratory_rate" id="respiratory_rate" type="number"
                                        class="mt-1 block w-full" placeholder=" " v-model="form.respiratory_rate" autofocus
                                        autocomplete="respiratory_rate" />

                                    <InputError class="mt-2" :message="form.errors.respiratory_rate" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="oxygen_saturation" value="Oxygen Saturation (%)" />
                                    <TextInput name="oxygen_saturation" id="oxygen_saturation" type="number"
                                        class="mt-1 block w-full" placeholder=" " v-model="form.oxygen_saturation" autofocus
                                        autocomplete="oxygen_saturation" />

                                    <InputError class="mt-2" :message="form.errors.oxygen_saturation" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="pulse_rate" value="Pulse Rate" />
                                    <TextInput name="pulse_rate" id="pulse_rate" type="number" class="mt-1 block w-full"
                                        placeholder=" " v-model="form.pulse_rate" autofocus autocomplete="pulse_rate" />

                                    <InputError class="mt-2" :message="form.errors.pulse_rate" />
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <InputLabel for="diagnosis_id" value="Diagnosis" />
                                    <select name="diagnosis_id" id="diagnosis_id" v-model="form.diagnosis_id" required
                                        class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="" selected>-</option>
                                        <option v-for="diagnosis in props.diagnoses" :key="diagnosis.id"
                                            :value="diagnosis.id">{{ diagnosis.name }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.diagnosis_id" />
                                </div>
                            </div>

                            <button type="submit" :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
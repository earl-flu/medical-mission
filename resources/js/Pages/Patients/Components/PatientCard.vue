<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    patient: {
        type: Object,
        required: true,
    },
});

const sex = computed(() => {
    return props.patient.sex == 0 ? 'Female' : 'Male';
})

// const isSeniorCitizen = computed(() => {
//     return props.patient.medical_record.age >= 60;
// })

// const isPedia = computed(() => {
//     return props.patient.medical_record.age <= 17;
// })

// const isPregnant = computed(() => {
//     return props.patient.medical_record.is_pregnant;
// })

// const needsOpto = computed(() => {
//     return props.patient.medical_record.is_opto;
// })
</script>

<template>
    <Link :href="route('patients.show', props.patient)">
    <div class="border border-gray-100 shadow p-5 flex gap-5 mb-5 hover:shadow-md hover:bg-gray-50">
        <div class="bg-gray-300 h-24 w-24"></div>
        <div>
            <p class="text-indigo-500 uppercase font-bold">{{ patient.full_name }}</p>
            <div class="text-sm text-gray-500 mt-2 font-medium">
                <p>{{ sex }}</p>
                <p>{{ patient.age_years }}
                </p>
                <p>{{ patient.full_address }}</p>

                <div class="flex gap-3 mt-3 text-white">
                    <!-- <div v-show="needsOpto" class="p-2 py-0.5 bg-emerald-700 rounded-md shadow">
                        Needs Opto
                    </div>
                    <div v-show="isSeniorCitizen" class="p-2 py-0.5 bg-pink-600 rounded-md shadow">
                        Senior Citizen
                    </div>
                    <div v-show="isPedia" class="p-2 py-0.5 bg-violet-600 rounded-md shadow">
                        Pedia
                    </div>
                    <div v-show="isPregnant" class="p-2 py-0.5 bg-yellow-600 rounded-md shadow">
                        Pregnant
                    </div> -->
                </div>

            </div>
        </div>
    </div>
    </Link>
</template>
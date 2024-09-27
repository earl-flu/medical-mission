<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";
import EncounterRow from "@/Components/EncounterRow.vue";
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();
const page = usePage();

const props = defineProps({
  success: {
    type: String,
    default: null,
  },
  patient: {
    type: Object,
    required: true,
  },
  encounters: {
    type: Array,
    required: true,
  },
});

onMounted(() => {
  if (page.props.flash.message) {
    showToast(page.props.flash.message);
  }
});

const showDiagnosis = computed(() => {
  return props.diagnosis_name || "No Diagnosis Yet";
});
</script>

<template>
  <Head title="Patients" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Patient Details
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('patients.index')"
          ><span class="text-indigo-500">Patients</span></Link
        >
        > <span class="uppercase">{{ patient.full_name }}</span>
      </p>
    </template>
    <div class="py-12 flex max-w-7xl mx-auto gap-8 px-8">
      <div class="max-w-2xl flex-1 mx-auto">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="pb-5">
              <div class="flex mb-4 justify-between items-center">
                <p class="text-xl text-gray-600 font-medium">
                  Personal Details
                </p>
                <p
                  class="text-sm text-indigo-500 font-semibold cursor-pointer hover:underline"
                >
                  <Link :href="route('patients.edit', props.patient.id)"
                    >Edit P. Details</Link
                  >
                </p>
              </div>
            </div>
            <div class="p-5 border flex gap-5">
              <div class="h-28 w-28 bg-gray-300"></div>
              <div class="text-gray-600">
                <p class="uppercase text-cyan-800 font-bold">
                  {{ patient.full_name }}
                </p>
                <p>{{ patient.sex_str }}</p>
                <p>{{ patient.birthdate_str }}</p>
                <p>{{ patient.age_years }}</p>
                <p>{{ patient.full_address }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-2xl flex-1 mx-auto">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="pb-5">
              <p class="text-xl text-gray-600 font-medium mb-8"><font-awesome-icon class="mr-2" :icon="['fas', 'person-walking-arrow-right']" />Encounters</p>
              <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table
                  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                  <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                  >
                    <tr>
                      <th scope="col" class="px-6 py-3">Date</th>

                      <th scope="col" class="px-6 py-3">Event</th>
                      <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <EncounterRow
                      v-for="encounter in encounters"
                      :encounter="encounter"
                      :key="encounter.id"
                    />
                  </tbody>
                </table>
              </div>
              <Link :href="route('encounter.create', props.patient)">
                <div
                  class="p-2 py-2.5 hover:shadow-md hover:bg-blue-800 bg-blue-700 text-white uppercase text-sm text-center mt-10 shadow rounded-md"
                >
                  Add Encounter
                </div>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

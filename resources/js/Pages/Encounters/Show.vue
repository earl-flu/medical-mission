<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { useToast } from "@/composables/useToast";
import { useFormatDate } from "@/composables/useFormatDate";

const { formatDate } = useFormatDate();
const { showToast } = useToast();

const props = defineProps({
  encounter: {
    type: Object,
    required: true,
  },
});

const bloodPressure = computed(() => {
  const hasBp = props.encounter.bp_systolic && props.encounter.bp_diastolic;
  if (hasBp) {
    return `${props.encounter.bp_systolic}/${props.encounter.bp_diastolic}`;
  } else {
    return "-";
  }
});
</script>

<template>
  <Head title="Create Patient" />
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Edit Patient Encounter
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('patients.index')"
          ><span class="text-indigo-500">Patients</span></Link
        >
        >
        <Link :href="route('patients.show', props.encounter.patient)"
          ><span class="uppercase text-indigo-500">{{
            $props.encounter.patient.full_name
          }}</span></Link
        >
        >
        <span>Show Encounter</span>
        >
        <span>{{ props.encounter.event_name }}</span>
      </p>
    </template>
    <div class="max-w-5xl mx-auto py-12 flex justify-center gap-5">
      <div class="max-w-2xl flex-1">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-5 border flex gap-5">
            <div class="h-28 w-28 bg-gray-300"></div>
            <div class="text-gray-600">
              <p class="uppercase text-cyan-800 font-medium">
                {{ encounter.patient.full_name }}
              </p>
              <p>{{ encounter.patient.sex_str }}</p>
              <p>{{ encounter.patient.birthdate_str }}</p>
              <p>{{ encounter.patient.age_years }}</p>
              <p>{{ encounter.patient.full_address }}</p>
            </div>
          </div>
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table>
              <tr>
                <td>Event</td>
                <td class="px-5">:</td>
                <td>{{ encounter.event_name }}</td>
              </tr>
              <tr>
                <td>Encounter Date</td>
                <td class="px-5">:</td>
                <td>{{ formatDate(encounter.encounter_date) || "-" }}</td>
              </tr>
              <tr>
                <td>Temperature</td>
                <td class="px-5">:</td>
                <td>{{ encounter.temperature || "-" }}</td>
              </tr>
              <tr>
                <td>Blood Pressure</td>
                <td class="px-5">:</td>
                <td>
                  {{ bloodPressure }}
                </td>
              </tr>
              <tr>
                <td>Respiratory Rate</td>
                <td class="px-5">:</td>
                <td>{{ encounter.respiratory_rate || "-" }}</td>
              </tr>
              <tr>
                <td>Oxygen Saturation</td>
                <td class="px-5">:</td>
                <td>{{ encounter.oxygen_saturation || "-" }}</td>
              </tr>
              <tr>
                <td>Pulse Rate</td>
                <td class="px-5">:</td>
                <td>{{ encounter.pulse_rate || "-" }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
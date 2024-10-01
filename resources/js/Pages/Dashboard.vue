<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EncounterStatisticsChart from "@/Components/EncounterStatisticsChart.vue";
import DispensedMedsChart from "@/Components/DispensedMedsChart.vue";
import EncounterServiceChart from "@/Components/EncounterServiceChart.vue";
import MunicipalityChart from "@/Components/MunicipalityChart.vue";
import DashboardCard from "@/Components/DashboardCard.vue";
import AvailableStocksChart from "@/Components/AvailableStocksChart.vue";
import InputLabel from "@/Components/InputLabel.vue";
import "vue-select/dist/vue-select.css";
import VueSelect from "vue-select";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import Datalabels from "chartjs-plugin-datalabels";
import ChartDataLabels from "chartjs-plugin-datalabels";
import EncountersByProgramChart from "@/Components/EncountersByProgramChart.vue";
const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
});
// The selected event ID
const selectedEventId = ref(
  props.events.find((event) => event.status === 1).id
); // Default to the first event
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 mb-10">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <InputLabel for="selectEvent" value="Select Event" />
            <vue-select
              v-model="selectedEventId"
              :options="props.events"
              label="name"
              class="mt-2"
              :reduce="(event) => event.id"
            ></vue-select>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <DashboardCard :eventId="selectedEventId" />

            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 500px"
              >
                <DispensedMedsChart :eventId="selectedEventId" />
              </div>
            </div>

            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 500px"
              >
                <AvailableStocksChart />
              </div>
            </div>

            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <DispensedMedsChart :eventId="selectedEventId" />
              </div>
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
              >
                <EncounterServiceChart :eventId="selectedEventId" />
              </div>
            </div>

            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <MunicipalityChart :eventId="selectedEventId" />
              </div>
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <EncountersByProgramChart :eventId="selectedEventId" />
              </div>
            </div>

            <div class="shadow-md p-4 mt-10">
              <!-- <Bar :options="chartOptions('Disposed Items')" :data="disposedMedsChartData" /> -->
            </div>
            <!-- <Bar :options="chartOptions('Diagnoses')" :data="diagnosesChartData" class="mt-10" /> -->
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

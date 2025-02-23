<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DrugTestOfficeChart from "@/Pages/Drugs/DrugTestOfficeChart.vue";
import PositivePerOfficeChart from "@/Pages/Drugs/PositivePerOfficeChart.vue";
import PositiveNegativeChart from "@/Pages/Drugs/PositiveNegativeChart.vue";
import EmploymentPieChart from "@/Pages/Drugs/EmploymentPieChart.vue";
import PositiveByEmploymentPieChart from "@/Pages/Drugs/PositiveByEmploymentPieChart.vue";
import TotalCards from "@/Pages/Drugs/TotalCards.vue";
import "vue-select/dist/vue-select.css";
import VueSelect from "vue-select";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import TextInput from "@/Components/TextInput.vue";
import Datalabels from "chartjs-plugin-datalabels";
import ChartDataLabels from "chartjs-plugin-datalabels";
import EncountersByProgramChart from "@/Components/EncountersByProgramChart.vue";

const officesData = ref([]);

// Fetch data from the API
const fetchData = async () => {
  try {
    const response = await fetch(route("drugs.getTotalPerOffice"));
    const data = await response.json();
    officesData.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Drug Test Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <TotalCards />
            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <DrugTestOfficeChart :data="officesData" />
              </div>
            </div>
            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <EmploymentPieChart :data="officesData" />
              </div>
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
              >
                <PositiveNegativeChart />
              </div>
            </div>

            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <PositivePerOfficeChart :data="officesData" />
              </div>
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <!-- <PositiveByEmploymentPieChart /> -->
              </div>
            </div>
            <div class="flex gap-10 mt-20">
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <!-- <EmploymentPieChart /> -->
              </div>
              <div
                class="flex-1 bg-white shadow p-4 flex items-center justify-center flex-col gap-4"
                style="height: 400px"
              >
                <!-- <EmploymentPieChart /> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

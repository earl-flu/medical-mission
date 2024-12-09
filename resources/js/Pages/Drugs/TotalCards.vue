<script setup>
import { ref, onMounted, computed, watch } from "vue";

const statistics = ref({});

const fetchData = async () => {
  try {
    const response = await fetch(route("drugs.getTotals"));
    const data = await response.json();

    statistics.value = {
      totalPatients: data.totalPatients,
      positive: data.positive,
      negative: data.negative,
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);

</script>

<template>
  <div class="flex justify-around">
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Total Patient
      </p>
      <p class="text-5xl mt-5">{{ statistics.totalPatients }}</p>
    </div>
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Positive
      </p>
      <p class="text-5xl mt-5">{{ statistics.positive }}</p>
    </div>
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Negative
      </p>
      <p class="text-5xl mt-5">{{ statistics.negative }}</p>
    </div>
    <!-- <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Pregnant
      </p>
      <p class="text-5xl mt-5">{{ statistics.total_pregnant }}</p>
    </div> -->
  </div>
</template>
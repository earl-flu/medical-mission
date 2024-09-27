<script setup>
import { ref, onMounted, computed, watch } from "vue";

const props = defineProps({
  eventId: {
    type: Number,
    required: true,
  },
});

const statistics = ref({});

const fetchData = async () => {
  try {
    const response = await fetch(route("event.statistics", props.eventId));
    const data = await response.json();

    statistics.value = {
      total_patients: data.total_patients,
      total_pedia: data.total_pedia,
      total_senior_citizen: data.total_senior_citizen,
      total_pregnant: data.total_pregnant,
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);

watch(
  () => props.eventId,
  (newEventId) => {
    fetchData(newEventId);
  }
);
</script>

<template>
  <div class="flex justify-around">
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Total Patient
      </p>
      <p class="text-5xl mt-5">{{ statistics.total_patients }}</p>
    </div>
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Pedia
      </p>
      <p class="text-5xl mt-5">{{ statistics.total_pedia }}</p>
    </div>
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Senior Citizen
      </p>
      <p class="text-5xl mt-5">{{ statistics.total_senior_citizen }}</p>
    </div>
    <div
      class="min-h-32 bg-white min-w-60 shadow-md border border-indigo-50 rounded-lg p-5"
    >
      <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">
        Pregnant
      </p>
      <p class="text-5xl mt-5">{{ statistics.total_pregnant }}</p>
    </div>
  </div>
</template>
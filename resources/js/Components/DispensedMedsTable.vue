<script setup>
import { ref, onMounted, watch } from "vue";

const props = defineProps({
  eventId: {
    type: [Number, String],
    required: true,
  },
});

const rows = ref([]);
const loading = ref(false);
const loadError = ref(null);

const fetchData = async () => {
  try {
    loading.value = true;
    loadError.value = null;
    const response = await fetch(route("event.dispensedMeds", props.eventId));
    const data = await response.json();
    data.sort((a, b) => Number(b.total_quantity) - Number(a.total_quantity));
    rows.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
    loadError.value = "Failed to load dispensed meds.";
  } finally {
    loading.value = false;
  }
};

onMounted(fetchData);

watch(
  () => props.eventId,
  () => {
    fetchData();
  }
);
</script>

<template>
  <div class="relative overflow-x-auto shadow sm:rounded-md">
    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
      <thead
        class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th scope="col" class="px-4 py-3">Item name</th>
          <th scope="col" class="px-4 py-3">Total quantity</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td colspan="2" class="px-4 py-3 text-center">Loading...</td>
        </tr>
        <tr v-else-if="loadError">
          <td colspan="2" class="px-4 py-3 text-center text-red-500">
            {{ loadError }}
          </td>
        </tr>
        <tr v-else-if="rows.length === 0">
          <td colspan="2" class="px-4 py-3 text-center">No data</td>
        </tr>
        <tr v-else v-for="item in rows" :key="item.item_name">
          <td class="px-4 py-3">{{ item.item_name }}</td>
          <td class="px-4 py-3">{{ Number(item.total_quantity) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
</style>
<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  encounter: {
    type: Object,
    required: true,
  },
});

function formatDate(dateString) {
  const date = new Date(dateString);
  const now = new Date();

  // Check if the date is valid
  if (isNaN(date.getTime())) {
    return "Invalid Date";
  }

  // Check if the date is today
  if (date.toDateString() === now.toDateString()) {
    return "Today";
  }

  // Format the date
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  };

  return date.toLocaleString("en-US", options);
}
</script>

<template>
  <tr
    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
  >
    <th
      scope="row"
      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
    >
      {{ formatDate(encounter.encounter_date) }}
    </th>
    <td class="px-6 py-4">
      {{ encounter.event_name }}
    </td>
    <td class="px-6 py-4 text-right">
      <Link
        :href="route('encounter.edit', props.encounter)"
        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
        >Edit</Link
      >
      <a
        href="#"
        @click="remove()"
        class="font-medium text-red-500 dark:text-red-100 hover:underline ml-3"
        >Remove</a
      >
    </td>
  </tr>
</template>
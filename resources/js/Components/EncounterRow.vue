<script setup>
import { Link, router } from "@inertiajs/vue3";
import { useToast } from "@/composables/useToast";
import { useFormatDate } from "@/composables/useFormatDate";

const { showToast } = useToast();
const { formatDate } = useFormatDate();

const props = defineProps({
  encounter: {
    type: Object,
    required: true,
  },
});

function deleteEncounter(encounter) {
  if (window.confirm("Are you sure you want to delete this encounter?")) {
    router.delete(route("encounter.destroy", encounter), {
      onSuccess: () => {
        showToast(`Encounter from ${encounter.event_name}, has been deleted`);
        form.reset();
      },
    });
  }
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
        :href="route('encounter.show', props.encounter)"
        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
        >Show</Link
      >
      <Link
        :href="route('encounter.edit', props.encounter)"
        class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-3"
        >Edit</Link
      >
      <a
        href="#"
        @click="deleteEncounter(props.encounter)"
        class="font-medium text-red-500 dark:text-red-100 hover:underline ml-3"
        >Remove</a
      >
    </td>
  </tr>
</template>
<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  patient: {
    type: Object,
    required: true,
  },
});

const sex = computed(() => {
  return props.patient.sex == 0 ? "F" : "M";
});
</script>

<template>
  <tr class="hover:text-blue-600 hover:bg-gray-100">
    <td>
      <Link :href="route('patients.show', props.patient)">
        <span class="uppercase text-teal-600">{{ patient.full_name }}</span>
      </Link>
    </td>
    <td class="text-gray-500 text-sm">{{ sex }}</td>
    <td class="text-gray-500 text-sm">
      {{
        new Date(patient.birthdate).toLocaleDateString("en-US", {
          year: "numeric",
          month: "2-digit",
          day: "2-digit",
        })
      }}
    </td>
    <!-- <div class="bg-gray-300 h-24 w-24"></div>
      <div>
        <p class="text-indigo-500 uppercase font-bold">
          {{ patient.full_name }}
        </p>
        <div class="text-sm text-gray-500 mt-2 font-medium">
          <p>{{ sex }}</p>
          <p>{{ patient.age_years }}</p>
          <p>{{ patient.full_address }}</p>

          <div class="flex gap-3 mt-3 text-white"></div>
        </div>
      </div> -->
  </tr>
</template>
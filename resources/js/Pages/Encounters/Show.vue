<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderedItemRow from "@/Components/OrderedItemRow.vue";
import { Head, router, useForm, usePage, Link } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { useToast } from "@/composables/useToast";
import { useFormatDate } from "@/composables/useFormatDate";

const { formatDate } = useFormatDate();
const { showToast } = useToast();
const page = usePage();

const props = defineProps({
  encounter: {
    type: Object,
    required: true,
  },
  ordered_items: {
    type: Array,
    required: true,
  },
});

onMounted(() => {
  if (page.props.flash.message) {
    showToast(page.props.flash.message);
  }
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
        Show Patient Encounter
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
    <div class="max-w-7xl mx-auto py-12 flex justify-center gap-5">
      <div class="max-w-2xl flex-1 mx-auto">
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
      <div class="max-w-2xl flex-1 mx-auto">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="pb-5">
              <p class="text-xl text-gray-600 font-medium mb-8">Orders</p>

              <div
                class="relative overflow-x-auto shadow-md sm:rounded-lg"
              >
                <table
                  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                  <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                  >
                    <tr>
                      <th scope="col" class="px-6 py-3">Item name</th>

                      <th scope="col" class="px-6 py-3">Quantity</th>
                      <th scope="col" class="px-6 py-3">Lot no.</th>
                      <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <OrderedItemRow
                      v-for="ordered_item in ordered_items"
                      :ordered_item="ordered_item"
                      :key="ordered_item.id"
                    />
                  </tbody>
                </table>
              </div>
              <Link :href="route('order-items.create', props.encounter)">
                <div
                  class="p-2 py-2.5 hover:shadow-md hover:bg-blue-800 bg-blue-700 text-white uppercase text-sm text-center mt-10 shadow rounded-md"
                >
                  Add Orders
                </div>
              </Link>
              <!-- <Link :href=""><i class="fas fa-home"></i> <i class="material-icons">home</i> </Link> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
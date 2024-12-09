<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, router, usePage, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
// import ItemRow from "./Components/ItemRow.vue";
import { ref, watch, onMounted } from "vue";
import throttle from "lodash/throttle";
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();
const page = usePage();

const props = defineProps({
  positiveEncounters: {
    type: Object,
    required: true,
  },
  totalPositive: {
    type: Number,
    required: true,
  },
  filters: Object,
});

onMounted(() => {
  if (page.props.flash.message) {
    showToast(page.props.flash.message);
  }
});

const search = ref(props.filters.search || "");

watch(
  search,
  throttle(function (search) {
    router.get(
      route("drugs.positiveList"),
      {
        search,
      },
      { preserveState: true, replace: true }
    );
  }, 300)
);
</script>


<template>
  <Head title="Drug Positive" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        All Positive
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="mb-10">
            <div class="relative z-0 w-full mb-6 group">
              <InputLabel for="search" value="Search" />
              <TextInput
                name="search"
                id="search"
                type="text"
                class="mt-1 block w-full"
                placeholder="First Name"
                v-model="search"
                required
                autocomplete="off"
              />
            </div>
          </div>
          <p class="mb-3 uppercase text-xs font-bold text-gray-600">
            Total: {{ totalPositive }}
          </p>
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
              class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="px-6 py-3">Name</th>
                  <th scope="col" class="px-6 py-3">Office</th>
                  <th scope="col" class="px-6 py-3">Age</th>
                  <th scope="col" class="px-6 py-3">Sex</th>
                  <th scope="col" class="px-6 py-3">Result</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="encounter in positiveEncounters.data"
                  :key="encounter.id"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                  <th
                    scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ encounter.patient.first_name[0] }}.
                    {{ encounter.patient.last_name[0] }}.
                  </th>
                  <td class="px-6 py-4">
                    {{ encounter.office.name }}
                  </td>
                  <td class="px-6 py-4">
                    {{ encounter.age }}
                  </td>
                  <td class="px-6 py-4">
                    {{ encounter.patient.sex ? "M" : "F" }}
                  </td>
                  <td class="px-6 py-4">
                    <span
                      class="text-xs p-1 rounded"
                      :class="
                        encounter.is_positive
                          ? 'bg-red-500 text-white'
                          : 'bg-green-500 text-white'
                      "
                      >{{
                        encounter.is_positive ? "Positive" : "Negative"
                      }}</span
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <p
              v-if="!positiveEncounters.data.length"
              class="text-red-500 text-xs text-center font-medium uppercase p-5"
            >
              NO POSITIVE PATIENT FOUND
            </p>
          </div>

          <div class="mt-6 flex">
            <div class="flex-1"></div>
            <Pagination
              :links="positiveEncounters.links"
              v-if="positiveEncounters.total"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>